<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\Infrastructure;

use Doctrine\DBAL\Exception;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\DataType\DateFilter;

final class Revenue
{
    private $queryBuilderFactory;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory
    )
    {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * @param DateFilter|null $dateFilter
     *
     * @return mixed
     * @throws Exception
     */
    public function min(?DateFilter $dateFilter = null)
    {
        $qb = $this->queryBuilderFactory->create();
        $qb->select("MIN(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId())
        ;

        if ($dateFilter) {
            $dateFilter->addToQuery($qb, "oxorderdate");
        }

        $data = $qb->execute();

        return $data->fetchOne();
    }
}
