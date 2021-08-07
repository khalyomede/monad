<?php

namespace Khalyomede\Monad;

/**
 * Shared by all monads to be able to handle successful or failed outcomes.
 */
interface MonadWithOutcome
{
    /**
     * Handle a successful outcome.
     */
    public function then(callable $callback): self;

    /**
     * Handle a failed outcome.
     */
    public function catch(callable $callback): mixed;
}
