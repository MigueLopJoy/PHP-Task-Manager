<?php
    include "./ASSETS/PHP/MODEL/product.php";
    include "./ASSETS/PHP/MODEL/customer.php";
    include "./ASSETS/PHP/MODEL/cart.php";
    include "./ASSETS/PHP/METHODS/renderProducts.php";
    include "./ASSETS/PHP/METHODS/renderCart.php";

    session_start();
    createProductIfNotExists();
    addProductToCart();

    include "./ASSETS/PHP/LAYERS/header.php";

    if (!isset($GET_['page'])) {
        renderCart();
    } else {
        if ($_GET['page'] == "customerData") {
            echo "<h4>Customer Data</h4>";
        }
    }

    renderCart();

    include "./ASSETS/PHP/LAYERS/footer.php";

?>  