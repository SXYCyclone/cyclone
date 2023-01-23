<?php

namespace Src\Common\Domain\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class DomainException extends \RuntimeException implements HttpExceptionInterface
{
    public int $httpCode = 500;

    public function __construct(
        string $message,
    ) {
        parent::__construct($message);
    }

    abstract public function getDomain(): string;

    public function getUniqueIdentifier(): string
    {
        // turn CamelCase to PASCALE_CASE, e.g. UserExistsException -> USER_EXISTS
        $class = (new \ReflectionClass($this))->getShortName();
        $class = substr($class, 0, -9); // remove 'Exception' suffix
        $class = preg_replace('/(?<!^)[A-Z]/', '_$0', $class);
        return strtoupper($class);
    }

    public function getStatusCode(): int
    {
        return $this->httpCode;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
