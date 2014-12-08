<?php
//-----------------------------------------------------
// search module for Opencart v1.5.x
// Created by alys2007
// alys2008@gmail.com
//-----------------------------------------------------

class ModelModuleSearch extends Model {

	public function getCategoriesIdByManufacturerId($manufacturer_id) {

        $sql  = "";
        $sql .= "SELECT DISTINCT c.category_id ";
        $sql .= "FROM " . DB_PREFIX . "product p ";
        $sql .= "INNER JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id = p.product_id) ";
        $sql .= "INNER JOIN " . DB_PREFIX . "category c ON (p2c.category_id = c.category_id) ";
        $sql .= "WHERE p.manufacturer_id = '" . (int)$manufacturer_id . "'";
        $sql .= " ORDER BY c.sort_order ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getManufacturersByCategoryId($category_id) {

        $sql  = "";
        $sql .= "SELECT DISTINCT m.manufacturer_id, m.name, m.image FROM " . DB_PREFIX . "product p ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id = p.product_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "manufacturer m ON (m.manufacturer_id = p.manufacturer_id) ";
        $sql .= "WHERE p.status = '1' ";
        $sql .= "AND p2c.category_id = '" . (int)$category_id . "'";
        $sql .= " ORDER BY m.sort_order ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
?>