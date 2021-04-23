<?php

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\Infrastructure;

use Doctrine\DBAL\Exception;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\DataType\DateFilter;

final class ReportRepository
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
     * @param DateFilter $dateBetween
     *
     * @return int
     * @throws Exception
     */
    public function getReportCountByDateDiff(DateFilter $dateBetween): int
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder
            ->select('COUNT(*)')
            ->from('oxorder')
        ;

        $dateBetween->addToQuery($queryBuilder, 'oxorderdate');

        return (int)$queryBuilder->execute()->fetchOne();
    }

    /**
     * @param int $day
     *
     * @return int
     * @throws Exception
     */
    public function reportCountLastDays(int $days): int
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder
            ->select('COUNT(*)')
            ->from('oxorder')
            ->where('oxorderdate >= DATE(NOW()) - INTERVAL :days DAY')
            ->setParameter('days', $days)
        ;

        return (int)$queryBuilder->execute()->fetchOne();
    }

    /**
     * @param DateFilter $dateBetween
     * @param int        $limit
     *
     * @return array
     * @throws Exception
     */
    public function getReportTopProductsByDateDiff(DateFilter $dateBetween, int $limit): array
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder
            ->select('ooa.oxartnum, SUM(ooa.oxamount) as sum')
            ->from('oxorder', 'oo')
            ->innerJoin('oo', 'oxorderarticles', 'ooa', 'ooa.oxorderid = oo.oxid');
        ;
         $dateBetween->addToQuery($queryBuilder, 'oxorderdate');

         $queryBuilder
            ->groupBy('ooa.oxartnum')
            ->orderBy('sum', 'DESC')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->execute()->fetchAll();
    }
}
