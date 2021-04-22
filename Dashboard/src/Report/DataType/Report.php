<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\DataType;

use Doctrine\DBAL\Exception;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Report
{
    /** @var QueryBuilderFactoryInterface */
    private QueryBuilderFactoryInterface $queryBuilderFactory;

    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * @Field
     * @throws Exception
     */
    public function orders(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("COUNT(*)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne();
    }

    /**
     * @Field
     * @throws Exception
     */
    public function newOrders(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("COUNT(*)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxfolder = 'ORDERFOLDER_NEW'")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne();
    }

    /**
     * @Field
     * @throws Exception
     */
    public function valueMin(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("MIN(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne();
    }

    /**
     * @Field
     * @throws Exception
     */
    public function valueAvg(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("AVG(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne();
    }

    /**
     * @Field
     * @throws Exception
     */
    public function valueMax(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("MAX(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne();
    }

    /**
     * @Field
     * @throws Exception
     */
    public function revenue(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxfolder = 'ORDERFOLDER_NEW'")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne() ?? "0";
    }

    /**
     * @Field
     * @throws Exception
     */
    public function revenuePaid(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxpaid != '0000-00-00 00:00:00'")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne() ?? "0";
    }

    /**
     * @Field
     * @throws Exception
     */
    public function revenueUnpaid(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxpaid = '0000-00-00 00:00:00'")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;

        return $data->fetchOne() ?? "0";
    }

    /**
     * @Field
     * @throws Exception
     */
    public function orderCanceled(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("COUNT(*)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxstorno = 1")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;
        return $data->fetchOne() ?? "0";
    }

    /**
     * @Field
     * @throws Exception
     */
    public function orderSum(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("SUM(OXTOTALORDERSUM)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxstorno = 0")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;
        return $data->fetchOne() ?? "0";
    }

    /**
     * @Field
     * @throws Exception
     */
    public function orderSumCanceled(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $data = $qb->select("SUM(OXTOTALORDERSUM)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxstorno = 1")
            ->setParameter("date", date("Y-m-d"))
            ->execute()
        ;
        return $data->fetchOne() ?? "0";
    }
}
