<?php

namespace PhpAssets\Css\CompilerFactory;

use InterpreterInterface;
use PhpAssets\Minify\MinifierInterface;
use PhpAssets\Css\CompilerFactory\Interpreter\InterpreterResolver;
use PhpAssets\Css\CompilerFactory\Compiler\CompilerResolver;

class Factory
{
    /**
     * Compiler resolver instance.
     * 
     * @var \PhpAssets\Css\CompilerFactory\Compiler\CompilerResolver
     */
    protected $compilerResolver;

    /**
     * File interpreter resolver instance.
     *
     * @var \PhpAssets\Css\CompilerFactory\Interpreter\InterpreterResolver
     */
    protected $interpreterResolver;

    /**
     * Default minifier instance.
     *
     * @var \PhpAssets\Minify\MinifierInterface
     */
    protected $minifier;

    /**
     * Create new Factory instance.
     *
     * @param CompilerResolver $compilerResolver
     * @param InterpreterResolver $interpreterResolver
     * @param MinifierInterface $minifier
     */
    public function __construct(
        CompilerResolver $compilerResolver,
        InterpreterResolver $interpreterResolver,
        MinifierInterface $minifier = null
    ) {
        $this->compilerResolver = $compilerResolver;
        $this->interpreterResolver = $interpreterResolver;
        $this->minifier = $minifier;
    }

    /**
     * Create new Style instance from path.
     *
     * @param string $path
     * @param MinifierInterface $minifier
     * @return \PhpAssets\Css\CompilerFactory\Style
     */
    public function make(string $path, MinifierInterface $minifier = null)
    {
        $interpreter = $this->interpreterResolver->resolve($path);

        $this->getCompiler($interpreter);

        $lang = $this->getLang($path, $interpreter);

        $compiler = $this->compilerResolver->resolve($lang);

        $minifier = $minifier === null ? $this->minifier : $minifier;

        return new Style($path, $lang, $compiler, $interpreter, $this->minifier);
    }

    /**
     * Get CSS extension language name from path.
     *
     * @param string $path
     * @param InterpreterInterface $interpreter
     * @return string
     */
    public function getLang($path, InterpreterInterface $interpreter)
    {
        return $interpreter->lang($path);
    }
}
