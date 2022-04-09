<?php

class Cartmanager {

    protected $db_manager;

    public function __construct(DatabaseManager $handle) {
        $this->db_model = new DatabaseModel();
        $this->db_manager = $handle;
    }

    /**
     * 
     *  @param:  product ID and ID of the combo offer product
     *  @return : special price 
     */
    function dependencyOffer($product_id, $productDependedId) {
        $sql_query = $this->db_model->fetchProducts();
        $products = $this->db_manager->productByID($sql_query);
        foreach ($products as $product_value) {
            if (!empty($product_value['combo_offer_mapping']) && !empty($_SESSION['cart_details'][$productDependedId])) {

                $special_offer_price = $product_value['special_price'];
            } else {
                $special_offer_price = $product_value['product_price'];
            }
        }
        return $special_offer_price;
    }

    public function removeDependancyOffer() {
        $product_id_array = array();
        $cart_details = $_SESSION['cart_details'];
        foreach ($cart_details as $cart_key => $cart_values) {
            $product_id_array[] = $cart_values['id'];
        }
        $product_id_string = implode(',', $product_id_array);
        $depended_product_sql = $this->db_model->fetchProductById($product_id_string);
        $dependency_list = $this->db_manager->executeQuery($depended_product_sql);
        $depended_id = $dependency_list[0]['combo_offer_mapping'];
    }

    /**
     * 
     *  @param:  product list array, product ID and product quantity
     *  @return : special price 
     */
    function applyDiscount($product_id, $added_product_quantity, $product_list = NULL) {

        $index = 0;
        if ($added_product_quantity == $product_list[$index]['quantity']) {//input quantity matched offer count
            if (!empty($product_list[$index]['combo_offer_mapping'])) {
                $special_offer_price = $this->dependencyOffer($product_id, $product_list[$index]['combo_offer_mapping']);
            } else {
                $special_offer_price = $product_list[$index]['special_price'];
            }
        }
        if ($added_product_quantity < $product_list[$index]['quantity']) {//input quantity less than  offer count
            $special_offer_price = $product_list[$index]['product_price'] * $added_product_quantity;
        }
        if ($added_product_quantity > $product_list[$index]['quantity']) {// calculating additional pricing with offer
            $calculated_qty = $added_product_quantity - $product_list[$index]['quantity'];
            $remainder = $calculated_qty % $product_list[$index]['quantity'];
            if (($remainder) == 0) {//product is multiple of configured quantity 
                $bundle_number = $added_product_quantity / $product_list[$index]['quantity'];
                $special_offer_price = $product_list[$index]['special_price'] * $bundle_number;
            } else {// if product is not multiple of configured quantity
                $special_offer_price = ($calculated_qty > $product_list[$index]['quantity']) ? $product_list[$index]['special_price'] + $this->applyDiscount($product_list[$index]['id'], $calculated_qty, $product_list) : $product_list[$index]['special_price'] + ($calculated_qty * $product_list[$index]['product_price']);
            }
        }

        return $special_offer_price;
    }

}
