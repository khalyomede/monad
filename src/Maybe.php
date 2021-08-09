<?php

namespace Khalyomede\Monad;

use Webmozart\Assert\Assert;

/**
 * Represents a data that can either exist (just) or not (nothing).
 *
 * @template T
 */
final class Maybe implements MonadWithOutcome
{
    public const KIND_JUST = 1;
    public const KIND_NOTHING = 2;

    /**
     * The concrete value in case the state is "just".
     *
     * @var T
     */
    private mixed $_value;

    /**
     * @var int<1, 2>
     */
    private int $_kind;

    /**
     * @param int<1, 2> $kind
     * @param T         $value
     */
    public function __construct(int $kind, mixed $value = null)
    {
        Assert::inArray($kind, [self::KIND_JUST, self::KIND_NOTHING]);

        $this->_value = $value;
        $this->_kind = $kind;
    }

    /**
     * @param T $value
     *
     * @return self<T>
     */
    public static function just(mixed $value): self
    {
        return new self(self::KIND_JUST, $value);
    }

    /**
     * @return self<null>
     */
    public static function nothing(): self
    {
        return new self(self::KIND_NOTHING);
    }

    /**
     * Handles a successful outcome (just).
     *
     * @return self<T>
     */
    public function then(callable $callback): self
    {
        return match ($this->_kind) {
            self::KIND_JUST => new self(self::KIND_JUST, \call_user_func($callback, $this->_value)),
            self::KIND_NOTHING => $this,
        };
    }

    /**
     * Handles a failed outcome (nothing).
     *
     * @return self<T>
     */
    public function catch(callable $callback): mixed
    {
        return match ($this->_kind) {
            self::KIND_JUST => $this->_value,
            self::KIND_NOTHING => \call_user_func($callback),
        };
    }
}
