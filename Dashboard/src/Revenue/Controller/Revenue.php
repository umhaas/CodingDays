<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Controller;

use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Right;
use CodingDays\Dashboard\Revenue\DataType\Revenue as RevenueDataType;
use CodingDays\Dashboard\Revenue\Service\Revenue as RevenueService;

final class Revenue
{
    /** @var RevenueService */
    private RevenueService $service;

    /**
     * Revenue constructor.
     *
     * @param RevenueService $service
     */
    public function __construct(
        RevenueService $service
    ) {
        $this->service = $service;
    }

    /**
     * @Query()
     * @Logged()
     * @Right("SEE_REPORTS")
     *
     * @param string|null $from
     * @param string|null $to
     *
     * @return RevenueDataType
     */
    public function revenue(?string $from = null, ?string $to = null): RevenueDataType
    {
        return $this->service->revenue($from, $to);
    }

    /**
     * @Query()
     * @Logged()
     * @Right("SEE_REPORTS")
     *
     * @param ?string $type
     * @param ?string $from
     * @param ?string $to
     *
     * @return RevenueDataType[]
     */
    public function revenues(?string $type="daily", ?string $from = null, ?string $to = null): array
    {
        return $this->service->revenues($type, $from, $to);
    }
}
