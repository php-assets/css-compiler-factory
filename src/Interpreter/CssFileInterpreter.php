<?php

namespace PhpAssets\Css\CompilerFactory\Interpreter;

use PhpAssets\Css\InterpreterInterface;

class CssFileInterpreter implements InterpreterInterface
{
    /**
     * Get CSS extension language name from path.
     *
     * @param string $path
     * @return string
     */
    public function lang($path)
    {
        return pathinfo($path)['extension'];
    }

    /**
     * Get raw CSS or extension string from path.
     *
     * @param string $path
     * @return string
     */
    public function raw($path)
    {
        return file_get_contents($path);
    }
}
