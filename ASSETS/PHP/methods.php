<?php
    function renderProducts() {
        $productsData = file_get_contents("./ASSETS/JSON/inventory.json");
        $products = json_decode($productsData);

        foreach($products as $product) {
            echo 
                "
                <article>
                    <h2>" .$product->name."</h2>
                    <p><strong>Product Code:</strong>" .$product->product_code."</p>
                    <p><strong>Category:</strong>" .$product->category."</p>
                    <p><strong>Stock Units:</strong>" .$product->stock_units."</p>
                    <p><strong>Price:</strong>" .$product->price."</p>
                    <a href='?p=".base64_encode(json_encode($product))."'><button>Add to cart</button></a>
                </article>
                ";
        }
    }

    function renderCart() {
        echo  "
            <aside>
                <h4>Shopping Cart</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Category</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
        ";

        foreach($_SESSION['cart']->showProducts() as $product) {
            echo 
                "
                <tr>
                <td>{$product->getProductName()}</td>
                <td>{$product->getProductCode()}</td>
                <td>{$product->getProductCategory()}</td>
                <td>{$product->getProductPrice()}</td>
            </tr>
        ";
        }
    
    echo    
        "
                <tr>
                    <th colspan='3'>Total</th>
                    <td>{$_SESSION['cart']->sumTotal()}</td>
                </tr>
            </table>
            <a href='?page=customerData'><button>Process Order</button></a>
        </aside>
        ";
    }

    function createCartIfNotExist() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = new Cart();
        }
    }

    function addProductToCart() {
        if (isset($_GET['p'])) {
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

    function renderCustomerForm() {
        echo "
        <h4>Customer Data</h4>
        <form method='POST' action='?page=submitOrder'>
            <input type='text' name='customer_name' placeholder='Introduce Name'>
            <input type='text' name='customer_surname' placeholder='Introduce Surname'>
            <input type='email' name='customer_email' placeholder='Introduce Email'>
            <input type='text' name='customer_phone_number' placeholder='Introduce Phone Number'>
            <input type='submit' value='Submit Order'>
        </form>
        ";
    }

    function submitOrder() {
        echo "<h4>Your order has been submited successfully</h4>";
        $_SESSION['cart']->addCustomer(
            new Customer(
                $_POST['customer_name'],
                $_POST['customer_surname'],
                $_POST['customer_email'],
                $_POST['customer_phone_number']
            )
        );
        $order = json_encode($_SESSION['cart'], JSON_PRETTY_PRINT);
        file_put_contents("./ASSETS/JSON/ORDERS/".date('U').".json", $order);
        session_destroy();     
        echo "<p>Redirigiendo...</p>";
        header("refresh:5; url=?");
    }
?>