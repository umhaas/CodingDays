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
}
