<?php
class ModelCatalogVideocategory extends Model {
    public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_category SET name = '" . $data['name'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', meta_description = '" . $this->db->escape($data['meta_description']) . "' , date_added = NOW()");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ocart_video_category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('video_category');
	}


    public function editCategory($category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "ocart_video_category SET name = '" . $data['name'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' , meta_description = '" . $this->db->escape($data['meta_description']) . "' WHERE category_id = '" . (int)$category_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_category_to_store WHERE category_id = '" . (int)$category_id . "'");
        
		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_category_id=" . (int)$category_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('video_category');
	}
	
	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_category_id=" . (int)$category_id . "'");

		$this->cache->delete('video_category');
	} 
	
	public function getCategories() {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_category vc ORDER BY vc.sort_order, vc.name ASC");
		return $query->rows;
	}
	
	
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'video_category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "ocart_video_category WHERE category_id = '" . (int)$category_id . "'");

		return $query->row;
	} 
	
	public function getCategoryStores($category_id) {
		$video_category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$video_category_store_data[] = $result['store_id'];
		}
		
		return $video_category_store_data;
	}
}
?>