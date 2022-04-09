<HTML>
    <HEAD>

        <TITLE>Super Market</TITLE>
        <link href="css/style.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type='text/javascript'>
            $(document).ready(function () {
                var cart = '<?php echo (!empty($_SESSION["cart_details"])) ? true : false; ?>';
                if (cart) {
                    document.getElementById("btnClear").style.display = "show";
                } else {
                    document.getElementById("btnClear").style.display = "none";
                }

            });

        </script>
    </HEAD>
    <BODY>
        <div id="shopping-cart">
            <h3 align="left">Supermarket</h3>
            <div class="heading-block">
                <h3 align="center">Cart</h3>
            </div>
            <?php
            if (isset($_SESSION["cart_details"])) {
                $total_quantity = 0;
                $total_price = 0;
                ?>
                <table class="tbl-cart-list" cellpadding="10" cellspacing="1">
                    <tbody>
                        <tr>
                            <th style="width:15%;">S.No</th>
                            <th>Name</th>
                            <th style="width:10%;">SKU</th>
                            <th style="width:5%;">Quantity</th>

                            <th style="width:15%;">Price</th>
                            <th style="width:15%;">Delete</th>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($_SESSION["cart_details"] as $product_list) {
                            $i++;
                            $total_quantity += $product_list["quantity"];
                            $total_price += ($product_list["price"]);
                            $product_list_price = $product_list["price"];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td id="prod_name"><strong><?php echo $product_list["product_name"]; ?></strong></td>
                                <td><?php echo $product_list["sku"]; ?></td>
                                <td><?php echo $product_list["quantity"]; ?></td>
                                <td><?php echo "£ " . $product_list["price"]; ?></td>
                                <td><a href="index.php?action=remove&id=<?php echo $product_list["id"]; ?>" class="removeButtonAction"><img src="images/deletebin-icon.png" alt="Remove Item" /></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2" style="text-align: right;"></td>
                            <td><strong>Total:</strong</td>
                            <td><strong><?php echo $total_quantity; ?></strong></td>
                            <td colspan="1"><strong><?php echo "£  " . number_format($total_price, 2); ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <?php
            } else {
                echo '<div class="empty-product-list">Add products to cart</div>';
            }
            ?>

        </div>
        <a id="btnClear" href="index.php?action=empty">Clear cart</a>
        <div id="product-grid">
            <div class="heading-block">
                <h3 align="center">Products</h3>
            </div>
            <?php
            if (!empty($product_list_array)) {
                foreach ($product_list_array as $key => $value) {
                    ?>
                    <div class="product-item">
                        <form method="post" id="<?php echo $product_list_array[$key]["id"]; ?>" action="index.php?action=add">
                            <div class="product-tile-footer">
                                <div class="product-title"><?php echo $product_list_array[$key]["product_name"]; ?></div>
                                <div class="product-price">Actual Price <?php echo "£" . $product_list_array[$key]["product_price"]; ?></div>
                                <br>
                                <input type="hidden" id="id" name="id" value="<?php echo $product_list_array[$key]["id"]; ?>" />

                                <?php if (!empty($product_list_array[$key]["combo_offer_mapping"])) { ?>
                                    <br>
                                    <div class="product-price">Special combo price <?php echo "£" . $product_list_array[$key]["special_price"]; ?> along with A </div>
                                <?php } else if ($product_list_array[$key]["s_id"]) { ?>
                                    <br>
                                    <div class="product-price">Buy <?php echo $product_list_array[$key]["quantity"] ?> for special price <?php echo "£" . $product_list_array[$key]["special_price"]; ?></div>
                                <?php } else { ?>
                                    <br>
                                    <div class="product-price">No offer </div>
                                <?php } ?>
                                <br>
                                <br>
                                <div class="cart-class"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAdd" name="insert" /></div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </BODY>
</HTML>