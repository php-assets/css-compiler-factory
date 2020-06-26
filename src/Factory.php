<?php

namespace PhpAssets\Css\CompilerFactory;

use PhpAssets\Css\InterpreterInterface;
use PhpAssets\Minify\CssMinifierInterface;
use PhpAssets\Css\CompilerFactory\Compiler\CompilerResolver;
use PhpAssets\Css\CompilerFactory\Interpreter\InterpreterResolver;

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
     * @param CssMinifierInterface $minifier
     */
    public function __construct(
        CompilerResolver $compilerResolver,
        InterpreterResolver $interpreterResolver,
        CssMinifierInterface $minifier = null
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
    public function make(string $path, CssMinifierInterface $minifier = null)
    {
        $interpreter = $this->interpreterResolver->resolve($path);

        $lang = $this->getLang($path, $interpreter);

        $compiler = $this->compilerResolver->resolve($lang);

        $minifier = $minifier === null ? $this->minifier : $minifier;

        return new Style($path, $lang, $compiler, $interpreter, $this->minifier);
    }

    /**
     * Get CSS extension language name from path.
     *
     * @param string $path
     * @param \PhpAssets\Css\InterpreterInterface $interpreter
     * @return string
     */
    public function getLang($path, InterpreterInterface $interpreter)
    {
        return $interpreter->lang($path);
    }
}
