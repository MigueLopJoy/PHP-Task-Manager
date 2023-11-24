<?php

class Cart {
    private int $cartId;
    private array $products;
    private Customer $customer;
    private float $total;

    public function __construct() {
        $this->products = array();
        $this->total = 0;
    }

    public function getCartId(): int {
        return $this->cartId;
    }

    public function setCartId(int $cartId): void {
        $this->cartId = $cartId;
    }

    public function getProducts(): array {
        return $this->products;
    }

    public function setProducts(array $products): void {
        $this->products = $products;
    }

    public function getCustomer(): Customer {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void {
        $this->customer = $customer;
    }

    public function getTotal(): float {
        return $this->total;
    }

    public function setTotal(float $total): void {
        $this->total = $total;
    }

    public function addProduct(Product $product): void {
        array_push($this->products, $product);
    }

    public function addCustomer(Customer $customer): Customer {
        $this->customer = $customer;
    }

    public function showProducts(): array {
        return $this->products;
    }

    public function sumTotal(): float {
        foreach($this->products as $product) {
            $total += $product->productPrice;
        }
        return $total;
    }
}
?>