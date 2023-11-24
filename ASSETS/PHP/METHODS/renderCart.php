<?php
    function renderCart() {
        echo  "
            <aside>
                <h4>Shopping Cart</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Tech Feature</th>
                            <th>Stock Units</th>
                        </tr>
                    </thead>
        ";

        foreach($_SESSION['cart']->showProducts() as $product) {
            echo 
                "
                <tr>
                <td>{$product->getProductName()}</td>
                <td>{$product->getProductCode()}</td>
                <td>{$product->getProductPrice()}</td>
                <td>{$product->getProductCategory()}</td>
                <td>{$product->getStockUnits()}</td>
            </tr>
        ";
        }

    echo "</table>";
    echo "<a href='?page=customerData'><button>Submit Order</button></a>";
    echo "</aside>";
    }

    function createCartIfNotExist() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = new Cart();
        }
    }

    function addProductToCart() {
        if (!isset($GET['p'])) {
            $product = json_decode(base64_decode($_GET['p']));
            $_SESSION['cart']->addProduct(
                new Product(
                    $product->id,
                    $product->product_code,
                    $product->name,
                    $product->price,
                    $product->category,
                    $product->stock_units
                )
            );
        }
    }
?>