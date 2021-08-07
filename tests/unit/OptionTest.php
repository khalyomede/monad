<?php

use Khalyomede\Monad\Option;

test(
    'it returns none',
    function () {
        $value = Option::none()
            ->then(fn () => true)
            ->catch(fn () => false)
        ;

        expect($value)->toBeFalse();
    }
);

test(
    'it return some',
    function () {
        $value = Option::some(true)
            ->then(fn ($value) => $value)
            ->catch(fn () => false)
        ;

        expect($value)->toBeTrue();
    }
);

test('it should throw an exception if constructed with a bad kind', function () {
    /*
     * @phpstan-ignore-next-line
     *
     * $this is bind.
     */
    $this->expectException(Exception::class);

    /*
     * @phpstan-ignore-next-line
     *
     * $this is bind.
     */
    $this->expectExceptionMessage('Expected one of: 1, 2. Got: 3');

    /*
     * @phpstan-ignore-next-line
     *
     * Testing bad case (error is intentional).
     */
    new Option(3);
});
