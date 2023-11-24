<?php
    include "./ASSETS/PHP/MODEL/product.php";
    include "./ASSETS/PHP/MODEL/customer.php";
    include "./ASSETS/PHP/MODEL/cart.php";
    include "./ASSETS/PHP/methods.php";

    session_start();
    createCartIfNotExist();
    addProductToCart();

    include "./ASSETS/PHP/LAYERS/header.php";

    if (!isset($_GET['page'])) {
        renderProducts();
    } else {
        if ($_GET['page'] == "customerData") {
            echo "
                <h4>Customer Data</h4>
                <form method='POST' action='?page='submitOrder''>
                    <input type='text' name='customer_name' placeholder='Introduce Name'>
                    <input type='text' name='customer_surname' placeholder='Introduce Surname'>
                    <input type='text' name='customer_email' placeholder='Introduce Name'>
                    <input type='text' name='customer_phone_number' placeholder='Introduce Name'>
                </form>
            ";
        } else if ($_GET['page'] == "submitOrder") {
            echo "<h4>Your order has been processed successfully</h4>";
            $_SESSION['cart']->addCustomer(
                new Customer(
                    $_POST['customer_name'],
                    $_POST['customer_surname'],
                    $_POST['customer_email'],
                    $_POST['customer_phone_number']
                )
            );
            $order = json_encode($_SESSION['cart']);
            file_put_contents("./ASSETS/JSON/ORDERS/".date('U').".json", $ORDER);
            session_destroy();            
        }
    }

    renderCart();

    include "./ASSETS/PHP/LAYERS/footer.php";

?>  