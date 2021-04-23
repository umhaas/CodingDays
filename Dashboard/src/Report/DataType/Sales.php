<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Sales
{
    /** @var string */
    private string $orderIdentifier;
    /** @var string */
    private string $orderInterval;
    /** @var int|null */
    private ?int $orderCount;

    public function __construct(
        string $orderIdentifier,
        string $orderInterval,
        int $orderCount = null
    ) {
        $this->orderIdentifier = $orderIdentifier;
        $this->orderInterval = $orderInterval;
        $this->orderCount = $orderCount;
    }

    /**
     * @Field
     */
    public function orderIdentifier(): string
    {
        return $this->orderIdentifier;
    }

    /**
     * @Field
     */
    public function orderInterval(): string
    {
        return $this->orderInterval;
    }

    /**
     * @Field
     */
    public function orderCount(): ?int
    {
        return $this->orderCount;
    }
}
