<?php

namespace Khalyomede\Monad;

use Webmozart\Assert\Assert;

/**
 * Represents the presence or absence of value.
 *
 * @template T
 */
final class Option implements MonadWithOutcome
{
    public const KIND_SOME = 1;
    public const KIND_NONE = 2;

    /**
     * The value if the outcome is "value present".
     *
     * @var T
     */
    private mixed $value;

    /**
     * The outcome (either KIND_SOME or KIND_NONE).
     *
     * @var int<1, 2>
     */
    private int $kind;

    /**
     * @param int<1, 2> $kind
     * @param T         $value
     */
    public function __construct(int $kind, mixed $value = null)
    {
        Assert::inArray($kind, [self::KIND_SOME, self::KIND_NONE]);

        $this->value = $value;
        $this->kind = $kind;
    }

    /**
     * @return self<null>
     */
    public static function none(): self
    {
        return new self(self::KIND_NONE);
    }

    /**
     * @param T $value
     *
     * @return self<T>
     */
    public static function some(mixed $value): self
    {
        return new self(self::KIND_SOME, $value);
    }

    /**
     * Handles a successful outcome ("some").
     *
     * @return self<T>
     */
    public function then(callable $callback): self
    {
        return match ($this->kind) {
            self::KIND_SOME => new self(self::KIND_SOME, \call_user_func($callback, $this->value)),
            self::KIND_NONE => $this,
        };
    }

    /**
     * Handles a failed outcome ("none").
     */
    public function catch(callable $callback): mixed
    {
        return match ($this->kind) {
            self::KIND_SOME => $this->value,
            self::KIND_NONE => \call_user_func($callback),
        };
    }
}
