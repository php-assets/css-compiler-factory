<?php

$interpreterResolver = new InterpreterResolver();
$interpreterResolver->register('css', function () {
    return new CssFileInterpreter;
});
$interpreterResolver->register('scss', function () {
    return new CssFileInterpreter;
});
$interpreterResolver->register('blade.php', function () {
    return new BladeInterpreter;
});

$compilerResolver = new CompilerResolver();
$compilerResolver->register('css', function () {
    return new CssCompiler;
});
$compilerResolver->register('scss', function () {
    return new SassCompiler;
});

$factory = new Factory(
    $compilerResolver,
    $interpreterResolver
);

$style = $factory->make('app.css');

echo $style->compile();
