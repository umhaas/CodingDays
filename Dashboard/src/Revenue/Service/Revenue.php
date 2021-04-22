<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Service;


use \DateTimeInterface;
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

    public function revenue(?string $from, ?string $to): RevenueDataType
    {
        $qbfi = ContainerFactory::getInstance()
            ->getContainer()
            ->get(QueryBuilderFactoryInterface::class);

        $datefilter = ($from || $to ? new DateFilter(null, [
            date_create($from ?? date("Y-m-d")),
            date_create($to ?? date("Y-m-d 23:59:59"))
        ]) : null);

        return new RevenueDataType($qbfi, $datefilter);
    }
}
