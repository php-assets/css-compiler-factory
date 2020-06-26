<?php

namespace PhpAssets\Css\CompilerFactory\Interpreter;

use Closure;
use InvalidArgumentException;
use PhpAssets\Css\InterpreterInterface;

class InterpreterResolver
{
    /**
     * The array of interpreter resolvers.
     *
     * @var array
     */
    protected $resolvers = [];

    /**
     * The resolved engine instances.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Register a new interpreter resolver by file extension.
     *
     * @param  string  $extension
     * @param  \Closure  $resolver
     * @return void
     */
    public function register($extension, Closure $resolver)
    {
        unset($this->resolved[$extension]);

        $this->resolvers[$extension] = $resolver;
    }

    /**
     * Resolve an file interpreter instance by path.
     *
     * @param  string  $path
     * @return \PhpAssets\Css\InterpreterInterface
     *
     * @throws \InvalidArgumentException
     */
    public function resolve($path)
    {
        $extension = $this->getFileExtension($path);

        if (isset($this->resolved[$extension])) {
            return $this->resolved[$extension];
        }

        if (isset($this->resolvers[$extension])) {
            return $this->resolved[$extension] = call_user_func($this->resolvers[$extension]);
        }

        throw new InvalidArgumentException("CSS interpreter for file extension [{$extension}] not found.");
    }

    /**
     * Get file extension from path.
     *
     * @param  string $path
     * @return string
     */
    protected function getFileExtension($path)
    {
        return pathinfo($path)['extension'];
    }
}
