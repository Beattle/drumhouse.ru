<?php
class ModelDesignLayout extends Model {	
	public function getLayout($route) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape($route) . "' LIKE CONCAT(route, '%') AND store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY route ASC LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getLayoutImagesOrder($layout_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout WHERE layout_id = '" . (int)$layout_id . "'");

		if ($query->num_rows) {
			return $query->row['image_order'];
		} else {
			return 0;
		}
	}

	public function getLayoutImages($layout_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_image WHERE layout_id = '" . (int)$layout_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

}
?>