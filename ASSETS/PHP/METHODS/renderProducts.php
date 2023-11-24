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
?>