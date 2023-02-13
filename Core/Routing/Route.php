<?php

namespace Core\Routing;

class Route
{
    private HttpMethod $httpMethod;
    private string $pattern;
    private string $controllerClass;
    private string $actionMethod;
    private array $args = [];
    private bool $withAuth = false;

    /**
     * @param HttpMethod $method
     * @param string $pattern
     * @param string $controllerClass
     * @param string $actionMethod
     */
    public function __construct(HttpMethod $method, string $pattern, string $controllerClass, string $actionMethod)
    {
        $this->httpMethod = $method;
        $this->pattern = $pattern;
        $this->controllerClass = $controllerClass;
        $this->actionMethod = $actionMethod;
    }

    public function withAuth(): Route
    {

        $this->withAuth = true;

        return $this;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    /**
     * @return HttpMethod
     */
    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * @return string
     */
    public function getActionMethod(): string
    {
        return $this->actionMethod;
    }

    /**
     * @return bool
     */
    public function isWithAuth(): bool
    {
        return $this->withAuth;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }


}
