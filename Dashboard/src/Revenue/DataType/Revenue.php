<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\DataType;

use CodingDays\Dashboard\Revenue\Infrastructure\Revenue as InfrastructureRevenue;
use Doctrine\DBAL\Exception;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
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
    private QueryBuilderFactoryInterface $queryBuilderFactory;
    private ?DateFilter                  $dateFilter;
    private InfrastructureRevenue        $revenueRepository;

    /**
     * Revenue constructor.
     *
     * @param QueryBuilderFactoryInterface $queryBuilderFactory
     * @param DateFilter|null $dateFilter
     */
    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory,
        ?DateFilter $dateFilter = null
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
        $this->dateFilter = $dateFilter;

        $container = ContainerFactory::getInstance();
        $this->revenueRepository = $container->getContainer()->get(InfrastructureRevenue::class);
    }

    /**
     * min order value
     *
     * @Field
     */
    public function min(): string
    {
       return $this->revenueRepository->min($this->dateFilter);
    }

    /**
     * average order value
     *
     * @Field
     * @throws Exception
     */
    public function avg(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $qb->select("AVG(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId())
        ;

        if ($this->dateFilter) {
            $this->dateFilter->addToQuery($qb, "oxorderdate");
        }

        $data = $qb->execute();

        return $data->fetchOne();
    }

    /**
     * max order value
     *
     * @Field
     * @throws Exception
     */
    public function max(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $qb->select("MAX(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId())
        ;

        if ($this->dateFilter) {
            $this->dateFilter->addToQuery($qb, "oxorderdate");
        }

        $data = $qb->execute();

        return $data->fetchOne();
    }

    /**
     * total paid and unpaid revenue
     * @Field
     */
    public function total(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId())
        ;

        if ($this->dateFilter) {
            $this->dateFilter->addToQuery($qb, "oxorderdate");
        }

        $data = $qb->execute();

        return $data->fetchOne() ?? "0";
    }

    /**
     * total paid revenue
     * @Field
     * @throws Exception
     */
    public function paid(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->andWhere("oxpaid != '0000-00-00 00:00:00'")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId())
        ;

        if ($this->dateFilter) {
            $this->dateFilter->addToQuery($qb, "oxorderdate");
        }

        $data = $qb->execute();

        return $data->fetchOne() ?? "0";
    }

    /**
     * open items
     *
     * @Field
     * @throws Exception
     */
    public function unpaid(): string
    {
        $qb = $this->queryBuilderFactory->create();
        $qb->select("SUM(oxtotalordersum)")
            ->from("oxorder")
            ->where("oxshopid = :shopid")
            ->andWhere("oxpaid = '0000-00-00 00:00:00'")
            ->setParameter("shopid", EshopRegistry::getConfig()->getShopId())
        ;

        if ($this->dateFilter) {
            $this->dateFilter->addToQuery($qb, "oxorderdate");
        }

        $data = $qb->execute();

        return $data->fetchOne() ?? "0";
    }
}
