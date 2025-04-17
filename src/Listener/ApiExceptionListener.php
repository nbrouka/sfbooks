<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exception\ExceptionHandler\ExceptionMapping;
use App\Exception\ExceptionHandler\ExceptionMappingResolver;
use App\Model\Error\ErrorDebugDetails;
use App\Model\Error\ErrorResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListener
{
    public function __construct(
        readonly private ExceptionMappingResolver $resolver,
        readonly private LoggerInterface $logger,
        readonly private SerializerInterface $serializer,
        readonly private bool $isDebug,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $mapping = $this->resolver->resolve($throwable::class);

        if (null == $mapping) {
            $mapping = ExceptionMapping::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($mapping->getCode() >= Response::HTTP_INTERNAL_SERVER_ERROR || $mapping->isLoggable()) {
            $this->logger->error(
                $throwable->getMessage(),
                [
                    'trace' => $throwable->getTraceAsString(),
                    'previous' => null !== $throwable->getPrevious() ? $throwable->getPrevious()->getMessage() : '',
                    'request' => $event->getRequest(),
                ]
            );
        }

        $message = $mapping->isHidden() && !$this->isDebug
            ? Response::$statusTexts[$mapping->getCode()]
            : $throwable->getMessage();
        $details = $this->isDebug ? new ErrorDebugDetails($throwable->getTraceAsString()) : null;
        $data = $this->serializer->serialize(new ErrorResponse($message, $details), JsonEncoder::FORMAT);

        $event->setResponse(new JsonResponse($data, $mapping->getCode(), [], true));
    }
}
