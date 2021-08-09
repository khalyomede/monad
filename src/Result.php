<?php

namespace Khalyomede\Monad;

use Webmozart\Assert\Assert;

/**
 * Represents an result that can be successful or failed.
 *
 * @template T
 *
 * @todo Find how to declare @template <T, E>
 */
final class Result implements MonadWithOutcome
{
    public const KIND_OK = 1;
    public const KIND_ERROR = 2;

    /**
     * The value in case of success.
     *
     * @var T
     */
    private mixed $okValue;

    /**
     * The value in case of failure.
     */
    private mixed $errorValue;

    /**
     * The kind of outcome (either KIND_OK or KIND_ERROR).
     *
     * @var int<1, 2>
     */
    private int $kind;

    /**
     * @param int<1, 2> $kind
     * @param T         $okValue
     */
    public function __construct(int $kind, mixed $okValue = null, mixed $errorValue = null)
    {
        Assert::inArray($kind, [self::KIND_OK, self::KIND_ERROR]);

        $this->okValue = $okValue;
        $this->errorValue = $errorValue;
        $this->kind = $kind;
    }

    /**
     * @return self<null>
     */
    public static function error(mixed $value): self
    {
        return new self(
            kind: self::KIND_ERROR,
            errorValue: $value
        );
    }

    /**
     * @param T $value
     *
     * @return self<T>
     */
    public static function ok(mixed $value): self
    {
        return new self(
            kind: self::KIND_OK,
            okValue: $value
        );
    }

    /**
     * Handles a successful outcome ("ok").
     *
     * @return self<T>
     */
    public function then(callable $callback): self
    {
        return match ($this->kind) {
            self::KIND_OK => new self(self::KIND_OK, \call_user_func($callback, $this->okValue)),
            self::KIND_ERROR => $this,
        };
    }

    /**
     * Handles a failed outcome ("error").
     */
    public function catch(callable $callback): mixed
    {
        return match ($this->kind) {
            self::KIND_OK => $this->okValue,
            self::KIND_ERROR => \call_user_func($callback, $this->errorValue),
        };
    }
}
