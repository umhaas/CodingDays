<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Controller;

use CodingDays\Dashboard\Revenue\DataType\Revenue as RevenueDataType;
use Doctrine\DBAL\Exception;
use OxidEsales\GraphQL\Base\DataType\DateFilter;
use TheCodingMachine\GraphQLite\Annotations\Query;
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
     */
    public function revenue(?string $from = null, ?string $to = null): RevenueDataType
    {
        return $this->service->revenue($from, $to);
    }
}
