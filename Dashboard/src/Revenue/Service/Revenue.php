<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Service;

use GraphQL\Error\Error;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use CodingDays\Dashboard\Revenue\DataType\Revenue as RevenueDataType;
use OxidEsales\GraphQL\Base\DataType\DateFilter;

final class Revenue
{
    /**
     * Revenue constructor.
     */
    public function __construct() { }

    /**
     * @param string|null $from
     * @param string|null $to
     *
     * @return RevenueDataType
     * @throws Error
     */
    public function revenue(?string $from, ?string $to): RevenueDataType
    {
        $queryBuilderFactory = ContainerFactory::getInstance()
            ->getContainer()
            ->get(QueryBuilderFactoryInterface::class);

        $dateFilter = ($from || $to ? new DateFilter(null, [
            date_create($from ?? date("Y-m-d")),
            date_create($to ?? date("Y-m-d 23:59:59"))
        ]) : null);

        return new RevenueDataType($queryBuilderFactory, $dateFilter);
    }
}
