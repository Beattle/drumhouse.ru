<?php
class ModelCatalogVideo extends Model {
	public function addVideo($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video SET name = '" . $data['name'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', link = '" . $data['code'] . "', description = '" . $this->db->escape($data['description']) . "', date_added = NOW()");
	
		$video_id = $this->db->getLastId();

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ocart_video SET image = '" . $this->db->escape($data['image']) . "' WHERE video_id = '" . (int)$video_id . "'");
		}

		if (isset($data['video_store'])) {		
			foreach ($data['video_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_to_store SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		if (isset($data['video_category'])) {
			foreach ($data['video_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_to_category SET video_id = '" . (int)$video_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
		
		if (isset($data['video_related'])) {
			foreach ($data['video_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$video_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_related SET video_id = '" . (int)$video_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$related_id . "' AND related_id = '" . (int)$video_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_related SET video_id = '" . (int)$related_id . "', related_id = '" . (int)$video_id . "'");
			}
		}
		
		$this->cache->delete('video');
	}
	
	public function editVideo($video_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "ocart_video SET name = '" . $data['name'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', link = '" . $data['code'] . "', description = '" . $this->db->escape($data['description']) . "' WHERE video_id = '" . (int)$video_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ocart_video SET image = '" . $this->db->escape($data['image']) . "' WHERE video_id = '" . (int)$video_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_to_store WHERE video_id = '" . (int)$video_id . "'");
		
		if (isset($data['video_store'])) {		
			foreach ($data['video_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_to_store SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_to_category WHERE video_id = '" . (int)$video_id . "'");
		
		if (isset($data['video_category'])) {
			foreach ($data['video_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_to_category SET video_id = '" . (int)$video_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE related_id = '" . (int)$video_id . "'");

		if (isset($data['video_related'])) {
			foreach ($data['video_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$video_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_related SET video_id = '" . (int)$video_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$related_id . "' AND related_id = '" . (int)$video_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_related SET video_id = '" . (int)$related_id . "', related_id = '" . (int)$video_id . "'");
			}
		}
		
		$this->cache->delete('video');
	}
	
	public function deleteVideo($video_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_to_store WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ocart_video_related WHERE related_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id. "'");

		$this->cache->delete('video');
	} 

	
	public function getVideos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "ocart_video v";
					
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(v.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND v.status = '" . (int)$data['filter_status'] . "'";
			}
					
			$sql .= " GROUP BY v.video_id";
						
			$sort_data = array(
				'v.name',
				'v.status',
				'v.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY v.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			$video_data = $this->cache->get('video');
		
			if (!$video_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video v ORDER BY v.name ASC");
	
				$video_data = $query->rows;
			
				$this->cache->set('video', $video_data);
			}	
	
			return $video_data;
		}
	}
	
	public function getVideo($video_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "') AS keyword FROM " . DB_PREFIX . "ocart_video WHERE video_id = '" . (int)$video_id . "'");
		
		return $query->row;
	} 
	
	public function getCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_category vc WHERE vc.status = '1' ORDER BY vc.sort_order, LCASE(vc.name)");
		
		return $query->rows;
	}
	
	
	public function getVideoCategories($video_id) {
		$video_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_to_category WHERE video_id = '" . (int)$video_id . "'");
		
		foreach ($query->rows as $result) {
			$video_category_data[] = $result['category_id'];
		}

		return $video_category_data;
	}
	
	public function getVideoStores($video_id) {
		$video_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_to_store WHERE video_id = '" . (int)$video_id . "'");

		foreach ($query->rows as $result) {
			$video_store_data[] = $result['store_id'];
		}
		
		return $video_store_data;
	}

	public function getTotalVideos($data = array()) {
		$sql = "SELECT COUNT(DISTINCT v.video_id) AS total FROM " . DB_PREFIX . "ocart_video v";
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(v.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND v.status = '" . (int)$data['filter_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
		
	public function getVideoRelated($video_id) {
		$video_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_related WHERE video_id = '" . (int)$video_id . "'");
		
		foreach ($query->rows as $result) {
			$video_related_data[] = $result['related_id'];
		}
		
		return $video_related_data;
	}
}
?>