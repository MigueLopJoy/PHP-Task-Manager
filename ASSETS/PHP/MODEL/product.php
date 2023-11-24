<?php
class Product implements JsonSerializable {
    private int $productId;
    private string $productCode;
    private string $productName;
    private float $productPrice;
    private string $productCategory;
    private int $stockUnits;

    public function __construct(int $productId, string $productCode, string $productName, float $productPrice, string $productCategory, int $stockUnits) {
        $this->productId = $productId;
        $this->productCode = $productCode;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
        $this->productCategory = $productCategory;
        $this->stockUnits = $stockUnits;
    }

    public function getProductId(): int {
        return $this->productId;
    }

    public function getProductCode(): string {
        return $this->productCode;
    }

    public function getProductName(): string {
        return $this->productName;
    }

    public function getProductPrice(): float {
        return $this->productPrice;
    }

    public function getProductCategory(): string {
        return $this->productCategory;
    }

    public function getStockUnits(): int {
        return $this->stockUnits;
    }

    public function setProductCode(string $productCode): void {
        $this->productCode = $productCode;
    }

    public function setProductName(string $productName): void {
        $this->productName = $productName;
    }

    public function setProductPrice(float $productPrice): void {
        $this->productPrice = $productPrice;
    }

    public function setProductCategory(string $productCategory): void {
        $this->productCategory = $productCategory;
    }

    public function setStockUnits(int $stockUnits): void {
        $this->stockUnits = $stockUnits;
    }

    public function jsonSerialize(): mixed {
        
    }
}

?>