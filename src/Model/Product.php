<?php

namespace Model;


class  Product extends Model
{

    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $img_url;

    public function __construct(int $id, string $name, string $description, float $price, string $img_url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->img_url = $img_url;
    }

    public static function getAll(): ?array
    {
        $stmt = self::getPDO()->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        foreach ($products as $product) {
            $data[] = new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['img_url']);
        }
        if (empty($data)) {
            return null;
        } else {
            return $data;
        }
    }

    public static function getAllByIds(array $ids): ?array
    {    $string = implode(", ", $ids);
        $stmt = self::getPDO()->query("SELECT * FROM products WHERE id IN ($string)");

        $products = $stmt->fetchAll();

        foreach ($products as $product) {
            $data[] = new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['img_url']);
        }
        if (empty($data)) {
            return null;
        } else {
            return $data;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImgUrl(): string
    {
        return $this->img_url;
    }
}