<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\DataType;

use Doctrine\DBAL\Exception;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\DataType\DateFilter;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Revenue
{
    /** @var QueryBuilderFactoryInterface */
    private $qbfi;
    private $dateFilter;

    public function __construct(
        QueryBuilderFactoryInterface $qbfi,
        ?DateFilter $dateFilter = null
    ) {
        $this->qbfi = $qbfi;
        $this->dateFilter = $dateFilter;
    }

    /**
     * min order value
     *
     * @Field
     */
    public function min(): string
    {
        $qb = $this->qbfi->create();
        $qb->select("MIN(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        if($this->dateFilter) $this->dateFilter->addToQuery($qb,"oxorderdate");

        $data = $qb->execute();

        return $data->fetchOne();
    }

    /**
     * average order value
     *
     * @Field
     */
    public function avg(): string
    {
        $qb = $this->qbfi->create();
        $qb->select("AVG(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        if($this->dateFilter) $this->dateFilter->addToQuery($qb,"oxorderdate");

        $data = $qb->execute();

        return $data->fetchOne();
    }

    /**
     * max order value
     *
     * @Field
     */
    public function max(): string
    {
        $qb = $this->qbfi->create();
        $qb->select("MAX(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        if($this->dateFilter) $this->dateFilter->addToQuery($qb,"oxorderdate");

        $data = $qb->execute();

        return $data->fetchOne();
    }

    /**
     * total paid and unpaid revenue
     * @Field
     */
    public function total(): string
    {
        $qb = $this->qbfi->create();
        $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        if($this->dateFilter) $this->dateFilter->addToQuery($qb,"oxorderdate");

        $data = $qb->execute();

        return $data->fetchOne() ?? "0";
    }

    /**
     * total paid revenue
     * @Field
     */
    public function paid(): string
    {
        $qb = $this->qbfi->create();
        $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->andWhere("oxpaid != '0000-00-00 00:00:00'")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        if($this->dateFilter) $this->dateFilter->addToQuery($qb,"oxorderdate");

        $data = $qb->execute();

        return $data->fetchOne() ?? "0";
    }

    /**
     * open items
     * @Field
     */
    public function unpaid(): string
    {
        $qb = $this->qbfi->create();
        $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->andWhere("oxpaid = '0000-00-00 00:00:00'")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId());

        if($this->dateFilter) $this->dateFilter->addToQuery($qb,"oxorderdate");

        $data = $qb->execute();

        return $data->fetchOne() ?? "0";
    }
}
