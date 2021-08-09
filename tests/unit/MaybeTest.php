<?php

use Khalyomede\Monad\Maybe;

test(
    'it return just',
    function () {
        /**
         * @var Maybe<bool>
         */
        $value = Maybe::just(true)
            ->then(fn ($value) => $value)
            ->catch(fn () => false)
        ;

        expect($value)->toBeTrue();
    }
);

test(
    'it return nothing',
    function () {
        /**
         * @var Maybe<bool>
         */
        $value = Maybe::nothing()
            ->then(fn () => true)
            ->catch(fn () => false)
        ;

        expect($value)->toBeFalse();
    }
);

it('throws an exception if constructed with a wrong kind', function () {
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
    new Maybe(3);
});
