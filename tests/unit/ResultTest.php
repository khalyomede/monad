<?php

use Khalyomede\Monad\Result;

test(
    'it returns error',
    function () {
        /**
         * @var Result<bool>
         */
        $value = Result::error(false)
            ->then(fn () => true)
            ->catch(fn ($error) => $error)
        ;

        expect($value)->toBeFalse();
    }
);

test(
    'return ok',
    function () {
        /**
         * @var Result<bool>
         */
        $value = Result::ok(true)
            ->then(fn ($value) => $value)
            ->catch(fn () => false)
        ;

        expect($value)->toBeTrue();
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
    new Result(3);
});
