<?php

namespace PhpAssets\Css\CompilerFactory\Compiler;

use PhpAssets\Css\CompilerInterface;

class CssCompiler implements CompilerInterface
{
    /**
     * Compile raw CSS or extension string.
     *
     * @param string $raw
     * @return string
     */
    public function compile($raw)
    {
        return $raw;
    }
}
