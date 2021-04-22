<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\DataType;

use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Report
{
    /** @var QueryBuilderFactoryInterface */
    private $qbfi;

    public function __construct(
        QueryBuilderFactoryInterface $qbfi
    ) {
        $this->qbfi = $qbfi;
    }

    /**
     * @Field
     */
    public function orders(): string
    {
        $qb = $this->qbfi->create();
        $data = $qb->select("COUNT(*)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->setParameter("date", date("Y-m-d"))
            ->execute();

        return $data->fetchColumn(0);
    }

    /**
     * @Field
     */
    public function newOrders(): string
    {
        $qb = $this->qbfi->create();
        $data = $qb->select("COUNT(*)")
            ->from("oxorder")
            ->where("oxorderdate >= :date")
            ->andWhere("oxfolder = 'ORDERFOLDER_NEW'")
            ->setParameter("date", date("Y-m-d"))
            ->execute();

        return $data->fetchColumn(0);
    }
}
