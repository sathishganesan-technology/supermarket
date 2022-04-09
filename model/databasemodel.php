<?php

class DatabaseModel extends DatabaseManager {

    public function fetchProducts($productId = NULL) {
        $sql = "select * from products LEFT JOIN specialoffers ON products.id = specialoffers.id";
        if (!empty($productId)) {

            $sql .= " WHERE products.id = $productId";
        }
        return $sql;
    }
    
    public function fetchProductById($productIds = NULL) {
        $sql = "select * from products LEFT JOIN specialoffers ON products.id = specialoffers.id WHERE specialoffers.combo_offer_mapping IN ($productIds)";
        return $sql;
    }

}

?>