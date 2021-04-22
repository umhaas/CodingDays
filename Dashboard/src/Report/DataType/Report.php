<?php

/**
 * Copyright © __Vender__. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace CodingDays\Dashboard\Report\DataType;

use DateTimeImmutable;
use DateTimeInterface;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\Eshop\Core\Database\Adapter\Doctrine\Database;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Report
{
    /** @var Database */
    private $db;

    public function __construct(
        DatabaseInterface $db
    ) {
        $this->db = $db;
    }

    /**
     * @Field
     */
    public function orders(): string
    {
        return (string) $this->db->getOne("SELECT COUNT(*) FROM oxorder WHERE oxorderdate >= ?",[date("Y-m-d")]);
    }

    /**
     * @Field
     */
    public function newOrders(): string
    {
        return (string) $this->db->getOne("SELECT COUNT(*) FROM oxorder WHERE oxfolder = 'ORDERFOLDER_NEW' AND oxorderdate >= ?",[date("Y-m-d")]);
    }
}
