<?php
$index = 0;
if (!empty($_GET["action"]) && isset($_GET["action"])) {
    switch ($_GET["action"]) {

        case "add":
            if (!empty($_POST["quantity"]) && !empty($_POST["id"])) {
                $sql_query = $db_model->fetchProducts($_POST["id"]);
                $product_list = $db_handle->executeQuery($sql_query);
                $discounted_amount = $checkout->applyDiscount($_POST["id"], $_POST["quantity"], $product_list);

                $addItem = array(
                    $product_list[$index]["id"] =>
                    array(
                        'product_name' => $product_list[$index]["product_name"],
                        'sku' => $product_list[$index]["sku"],
                        'id' => $product_list[$index]["id"],
                        'quantity' => $_POST["quantity"],
                        'price' => $discounted_amount
                    )
                );
                addItemIntoCart($product_list, $index, $checkout, $_POST["quantity"], $addItem);
            }
            break;
        case "empty":
            unset($_SESSION["cart_details"]);
            break;
        case "remove":
            if (!empty($_SESSION["cart_details"]) && isset($_SESSION["cart_details"])) {
                foreach ($_SESSION["cart_details"] as $cart_key => $cart_value) {
                    if ($_GET["id"] == $cart_key) {
                        unset($_SESSION["cart_details"][$cart_key]);
                    }
                    if (empty($_SESSION["cart_details"])) {
                        unset($_SESSION["cart_details"]);
                    }
                }
            }
            break;
    }
}

function addItemIntoCart($product_list, $index, $checkout, $quantity, $addItem) {//add an item into the cart
    if (!empty($_SESSION["cart_details"])) {
        if (in_array($product_list[$index]["id"], array_keys($_SESSION["cart_details"]))) {

            foreach ($_SESSION["cart_details"] as $cart_key => $cart_value) {
                if ($product_list[$index]["id"] == $cart_key) {
                    if (empty($_SESSION["cart_details"][$cart_key]["quantity"])) {
                        $_SESSION["cart_details"][$cart_key]["quantity"] = $index;
                    }
                    $_SESSION["cart_details"][$cart_key]["quantity"] += $quantity;
                    $_SESSION["cart_details"][$cart_key]["price"] = $checkout->applyDiscount($_SESSION["cart_details"][$cart_key]["id"], $_SESSION["cart_details"][$cart_key]["quantity"], $product_list);
                }
            }
        } else {
            $_SESSION["cart_details"] = $_SESSION["cart_details"] + $addItem;
        }
    } else {
        $_SESSION["cart_details"] = $addItem;
    }
}

$sql_query = $db_model->fetchProducts();
$product_list_array = $db_handle->productByID($sql_query);


