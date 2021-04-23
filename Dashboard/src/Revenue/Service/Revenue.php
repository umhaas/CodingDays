<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Service;

use CodingDays\Dashboard\Revenue\Infrastructure\RevenueRepository;
use CodingDays\Dashboard\Revenue\DataType\Revenue as RevenueDataType;
use GraphQL\Error\Error;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;

final class Revenue
{

    private RevenueRepository $repository;

    /**
     * Revenue constructor.
     *
     * @param RevenueRepository $repository
     */
    public function __construct(
        RevenueRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param ?string $from
     * @param ?string $to
     *
     * @return RevenueDataType
     * @throws Error
     */
    public function revenue(?string $from, ?string $to): RevenueDataType
    {
        return $this->repository->revenue($from, $to);
    }

    /**
     * @param ?string $type
     * @param ?string $from
     * @param ?string $to
     *
     * @return RevenueDataType[]
     * @throws Error
     */
    public function revenues(?string $type, ?string $from, ?string $to): array
    {
        return $this->repository->revenues($type, $from, $to);
    }
}
