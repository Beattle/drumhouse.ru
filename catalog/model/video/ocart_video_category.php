<?php
class ModelVideoOcartvideocategory extends Model {

	public function getCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_category vc LEFT JOIN " . DB_PREFIX . "ocart_video_category_to_store vc2s ON (vc.category_id = vc2s.category_id) WHERE vc2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND vc.status = '1' ORDER BY vc.sort_order, LCASE(vc.name)");
		
		return $query->rows;
	}

}
?>