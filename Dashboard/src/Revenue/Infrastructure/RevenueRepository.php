<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Infrastructure;

use CodingDays\Dashboard\Revenue\DataType\Revenue as RevenueDataType;
use Doctrine\DBAL\Exception;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\DataType\DateFilter;

final class RevenueRepository
{


    /**
     * @var QueryBuilderFactoryInterface
     */
    private QueryBuilderFactoryInterface $queryBuilderFactory;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return RevenueDataType
     * @throws Exception
     */
    public function revenue(?string $from, ?string $to): RevenueDataType
    {
        $dateFilter = new DateFilter(null, [
            date_create($from ?? date("Y-m-d")),
            date_create($to ?? date("Y-m-d 23:59:59"))
        ]);

        $querybuilder = $this->queryBuilderFactory->create();
        $querybuilder->select("*")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        $dateFilter->addToQuery($querybuilder, "oxorderdate");
        $result = $querybuilder->execute();
        $orders =  $result->fetchAll();

        return new RevenueDataType($from, $to, $orders);
    }
    /**
     * @param string $type day
     * @param string $from
     * @param string $to
     *
     * @return RevenueDataType[]
     * @throws Exception
     */
    public function revenues(string $type = "daily", string $from, ?string $to): array
    {
        $period = new \DatePeriod(
            new \DateTime($from),
            \DateInterval::createFromDateString('1 day'),
            new \DateTime($to)
        );

        $revenues = [];

        foreach ($period as $date) {
            $from = $date->format("Y-m-d");
            $to = $date->format("Y-m-d 23:59:59");

            $revenues[$from] = $this->revenue($from, $to);
        }

        return $revenues;
    }

}
