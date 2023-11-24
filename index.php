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
            renderCustomerForm();
        } else if ($_GET['page'] == "submitOrder") {
            submitOrder();
        }
    }

    renderCart();

    include "./ASSETS/PHP/LAYERS/footer.php";

?>  