<?php

use Khalyomede\Monad\Maybe;

final class Router
{
    public function addGetRoute(): Maybe
    {
        return Maybe::just($this);
    }
}

test("it can chain multiple ->then()", function () {
    $result = (new Router)->addGetRoute()
        ->then(fn (Router $router): Maybe => $router->addGetRoute())
        ->catch(fn () => false)
        ->then(fn (Router $router): Maybe => $router->addGetRoute())
        ->catch(fn () => false)
        ->then(fn (): bool => true)
        ->catch(fn (): bool => false);

    expect($result)->toBeTrue();
});
