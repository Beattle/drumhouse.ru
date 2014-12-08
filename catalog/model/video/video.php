<?php
class ModelVideovideo extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ocart_video_category vc LEFT JOIN " . DB_PREFIX . "ocart_video_category_to_store vc2s ON (vc.category_id = vc2s.category_id) WHERE vc.category_id = '" . (int)$category_id . "' AND vc2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND vc.status = '1'");
		
		return $query->row;
	}
	
	public function getCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_category vc LEFT JOIN " . DB_PREFIX . "ocart_video_category_to_store vc2s ON (vc.category_id = vc2s.category_id) WHERE vc2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND vc.status = '1' ORDER BY vc.sort_order, LCASE(vc.name)");
		
		return $query->rows;
	}
	
	public function getTotalVideos($data = array()) {
		$sql = "SELECT COUNT(DISTINCT v.video_id) AS total FROM " . DB_PREFIX . "ocart_video v LEFT JOIN " . DB_PREFIX . "ocart_video_to_store v2s ON (v.video_id = v2s.video_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "ocart_video_to_category v2c ON (v.video_id = v2c.video_id)";			
		}
					
		$sql .= " WHERE v.status = '1' AND v2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND (";
								
			if (!empty($data['filter_name'])) {
				$implode = array();
				
				$words = explode(' ', $data['filter_name']);
				
				foreach ($words as $word) {
					if (!empty($data['filter_description'])) {
						$implode[] = "LCASE(v.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(v.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					} else {
						$implode[] = "LCASE(v.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					}				
				}
				
				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . "";
				}
			}
			
			if (!empty($data['filter_name'])) {
				$sql .= " OR ";
			}
			
			$sql .= ")";
		}
		
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "v2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				
				$this->load->model('catalog/category');
				
				$categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);
					
				foreach ($categories as $category_id) {
					$implode_data[] = "v2c.category_id = '" . (int)$category_id . "'";
				}
							
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND v2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
		}
			
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}

	public function getVideo($video_id) {

        $sql  = "SELECT DISTINCT *, v.name AS name, v.image, v.sort_order, vc.category_id as vcat_id, vc.name as vcat_name, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ocart_video_review r2 WHERE r2.video_id = v.video_id AND r2.status = '1' GROUP BY r2.video_id) AS reviews FROM " . DB_PREFIX . "ocart_video v ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_to_store v2s ON (v.video_id = v2s.video_id) ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_to_category v2c ON (v.video_id = v2c.video_id) ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_category vc ON (v2c.category_id = vc.category_id) ";
        $sql .= "WHERE v.video_id = '" . (int)$video_id . "' ";
        $sql .= "AND v.status = '1' ";
        $sql .= "AND v2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}

	}

	public function getLatestVideos($limit) {
		$sql  = "SELECT *, v.name AS name, vc.category_id as vcat_id, vc.name as vcat_name FROM " . DB_PREFIX . "ocart_video v ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_to_category v2c ON (v.video_id = v2c.video_id) ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_category vc ON (v2c.category_id = vc.category_id) ";
        $sql .= "ORDER BY RAND() DESC LIMIT 0," . $limit ;
        //$sql .= "ORDER BY v.date_added DESC LIMIT 0," . $limit ;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getRandomVideos($limit) {
		$sql  = "SELECT *, v.name AS name, vc.category_id as vcat_id, vc.name as vcat_name FROM " . DB_PREFIX . "ocart_video v ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_to_category v2c ON (v.video_id = v2c.video_id) ";
        $sql .= "INNER JOIN " . DB_PREFIX . "ocart_video_category vc ON (v2c.category_id = vc.category_id) ";
        $sql .= "ORDER BY RAND() DESC LIMIT 0," . $limit ;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function get11Videos() {
		$sql = "SELECT * FROM " . DB_PREFIX . "ocart_video";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getVideos($data = array()) {

		$cache = md5(http_build_query($data));
		
		$video_data = $this->cache->get('video.' . (int)$this->config->get('config_store_id') . '.' . $cache);
		
		if (!$video_data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "ocart_video v LEFT JOIN " . DB_PREFIX . "ocart_video_to_store v2s ON (v.video_id = v2s.video_id)"; 

			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "ocart_video_to_category v2c ON (v.video_id = v2c.video_id)";			
			}

			$sql .= " WHERE v.status = '1' AND v2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
			
		
			if (!empty($data['filter_name'])) {
				$sql .= " AND (";
											
				if (!empty($data['filter_name'])) {
					$implode = array();
					
					$words = explode(' ', $data['filter_name']);
					
					foreach ($words as $word) {
						if (!empty($data['filter_description'])) {
							$implode[] = "LCASE(v.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(v.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						} else {
							$implode[] = "LCASE(v.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						}				
					}
					
					if ($implode) {
						$sql .= " " . implode(" OR ", $implode) . "";
					}
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR ";
				}
				
				
			
				$sql .= ")";
			}
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = "v2c.category_id = '" . (int)$data['filter_category_id'] . "'";
					
					$this->load->model('catalog/category');
					
					$categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);
										
					foreach ($categories as $category_id) {
						$implode_data[] = "p2c.category_id = '" . (int)$category_id . "'";
					}
								
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND v2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}		
					
			
			$sql .= " GROUP BY v.video_id";
			
			$sort_data = array(
				'v.name',
				'v.sort_order',
				'v.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'v.name') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY v.sort_order";	
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
			
			
			
			$video_data = array();
					
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$video_data[$result['video_id']] = $this->getVideo($result['video_id']);
			}
			
			$this->cache->set('video.' . (int)$this->config->get('config_store_id') . '.' . $cache, $video_data);
		}
		
		return $video_data;
		//return $query->rows;
	}
			
	public function getVideoRelated($video_id) {
		$video_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocart_video_related vr LEFT JOIN " . DB_PREFIX . "ocart_video v ON (vr.related_id = v.video_id) LEFT JOIN " . DB_PREFIX . "ocart_video_to_store v2s ON (v.video_id = v2s.video_id) WHERE vr.video_id = '" . (int)$video_id . "' AND v.status = '1' AND v2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$video_data[$result['related_id']] = $this->getVideo($result['related_id']);
		}
		
		return $video_data;
	}
}
?>