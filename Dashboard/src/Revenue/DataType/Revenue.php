<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace CodingDays\Dashboard\Revenue\DataType;

use Doctrine\DBAL\Exception;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Revenue
{
    private string $from;
    private string $to;
    private array $orders;

    /**
     * Revenue constructor.
     *
     * @param array $orders
     */
    public function __construct(
        string $from,
        string $to,
        array $orders
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->orders = $orders;
    }

    /**
     * revenue date
     *
     * @Field
     */
    public function date(): string
    {
        return (substr($this->from, 0, 10) ==  substr($this->to, 0, 10) ? $this->from : $this->from . " - " . $this->to);
    }

    /**
     * min order value
     *
     * @Field
     */
    public function min(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "0";
        });
        return min(array_column($data,"OXTOTALORDERSUM")) ?? "0";
    }

    /**
     * average order value
     *
     * @Field
     */
    public function avg(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "0";
        });
        $values = array_column($data,"OXTOTALORDERSUM");
        return (string) (array_sum($values)/count($values)) ?? "0";
    }

    /**
     * max order value
     *
     * @Field
     */
    public function max(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "0";
        });
        return max(array_column($data,"OXTOTALORDERSUM")) ?? "0";
    }

    /**
     * total paid and unpaid revenue
     * @Field
     */
    public function total(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "0";
        });
        return (string) (array_sum(array_column($data,"OXTOTALORDERSUM"))) ?? "0";
    }

    /**
     * total paid revenue
     * @Field
     */
    public function paid(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "0" && $order["OXPAID"] !== "0000-00-00 00:00:00";
        });
        return (string) (array_sum(array_column($data,"OXTOTALORDERSUM"))) ?? "0";
    }

    /**
     * open items
     *
     * @Field
     */
    public function unpaid(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "0" && $order["OXPAID"] === "0000-00-00 00:00:00";
        });
        return (string) (array_sum(array_column($data,"OXTOTALORDERSUM"))) ?? "0";
    }

    /**
     * canceled order sum
     *
     * @Field
     */
    public function canceledtotal(): string
    {
        $data = array_filter($this->orders,function($order) {
            return $order["OXSTORNO"] === "1";
        });
        return (string) (array_sum(array_column($data,"OXTOTALORDERSUM"))) ?? "0";
    }
}
