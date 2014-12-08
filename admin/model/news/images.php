<?php
class ModelNewsImages extends Model {
	public function addNewsImages($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery SET news_gallery_showdate= '" . (isset($data['news_images_showdate']) ? (int)$data['news_images_showdate'] : 0) . "', news_gallery_showvote = '". (isset($data['news_images_showvote']) ? (int)$data['news_images_showvote'] : 0)."',news_gallery_showviewed = '". (isset($data['news_images_showview']) ? (int)$data['news_images_showview'] : 0)."',news_gallery_order = '" . (int)$data['news_images_sort_order'] . "', news_gallery_status = '" . (int)$data['news_images_status'] . "', news_gallery_added = NOW(), news_gallery_modified = NOW(), news_gallery_vote = '0'");
	
		$images_id = $this->db->getLastId();
		
		if (isset($data['news_images_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_gallery SET news_gallery_image = '" . $this->db->escape($data['news_images_image']) . "' WHERE news_gallery_id = '" . (int)$images_id . "'");
		}
		
		foreach ($data['news_images_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_description SET news_gallery_id = '" . (int)$images_id . "', language_id = '" . (int)$language_id . "', news_gallery_titles = '" . $this->db->escape($value['news_images_images_titles']) . "', news_gallery_description = '" . $this->db->escape($value['news_images_description']) . "'");
		}
		if (isset($data['news_images_albums'])) {
			foreach ($data['news_images_albums'] as $album_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_to_album SET news_gallery_id = '" . (int)$images_id . "', news_gallery_album_id = '" . (int)$album_id . "'");
			}
		}
		if (isset($data['news_images_store'])) {
			foreach ($data['news_images_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_to_store SET news_gallery_id = '" . (int)$images_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['news_images_layout'])) {
			foreach ($data['news_images_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_to_layout SET 	news_gallery_id = '" . (int)$images_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->cache->delete('images');
	}
	
	public function editNewsImages($image_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news_gallery SET news_gallery_showdate= '" . (isset($data['news_images_showdate']) ? (int)$data['news_images_showdate'] : 0) . "', news_gallery_showvote = '". (isset($data['news_images_showvote']) ? (int)$data['news_images_showvote'] : 0)."',news_gallery_showviewed = '". (isset($data['news_images_showview']) ? (int)$data['news_images_showview'] : 0)."',news_gallery_order = '" . (int)$data['news_images_sort_order'] . "', news_gallery_status = '" . (int)$data['news_images_status'] . "', news_gallery_modified = NOW() WHERE news_gallery_id = '" . (int)$image_id . "'");

		if (isset($data['news_images_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_gallery SET news_gallery_image = '" . $this->db->escape($data['news_images_image']) . "' WHERE news_gallery_id = '" . (int)$image_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_description WHERE news_gallery_id = '" . (int)$image_id . "'");

		foreach ($data['news_images_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_description SET news_gallery_id = '" . (int)$image_id . "', language_id = '" . (int)$language_id . "', news_gallery_titles = '" . $this->db->escape($value['news_images_images_titles']) . "',news_gallery_description = '" . $this->db->escape($value['news_images_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_to_album WHERE news_gallery_id = '" . (int)$image_id . "'");
		if (isset($data['news_images_albums'])) {
			foreach ($data['news_images_albums'] as $album_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_to_album SET news_gallery_id = '" . (int)$image_id . "', news_gallery_album_id = '" . (int)$album_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_to_store WHERE news_gallery_id = '" . (int)$image_id . "'");
		
		if (isset($data['news_images_store'])) {		
			foreach ($data['news_images_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_to_store SET news_gallery_id = '" . (int)$image_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_to_layout WHERE news_gallery_id = '" . (int)$image_id . "'");

		if (isset($data['news_images_layout'])) {
			foreach ($data['news_images_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_to_layout SET news_gallery_id = '" . (int)$image_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		$this->cache->delete('images');
	}
	
	public function deleteNewsImages($image_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery WHERE news_gallery_id = '" . (int)$image_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_description WHERE news_gallery_id = '" . (int)$image_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_to_store WHERE news_gallery_id = '" . (int)$image_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_to_layout WHERE news_gallery_id = '" . (int)$image_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_to_album WHERE news_gallery_id = '" . (int)$image_id . "'");
		$this->cache->delete('images');
	} 

	public function getNewsImage($image_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery ga LEFT JOIN ".DB_PREFIX."news_gallery_description gad ON(ga.news_gallery_id = gad.news_gallery_id) WHERE ga.news_gallery_id = '" . (int)$image_id . "' AND gad.language_id = '".(int)$this->config->get('config_language_id'). "'");
		
		return $query->row;
	} 
	
	public function getNewsImages($data = array()) {
		if($data)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "news_gallery ga LEFT JOIN " . DB_PREFIX . "news_gallery_description gad ON (ga.news_gallery_id = gad.news_gallery_id) WHERE gad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
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
		}
		else
		{
			$images_data = $this->cache->get('images.' . $this->config->get('config_language_id'));
	
		if (!$images_data) {
			$images_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery ga LEFT JOIN " . DB_PREFIX . "news_gallery_description gad ON (ga.news_gallery_id = gad.news_gallery_id) AND gad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ga.news_gallery_order, gad.news_gallery_titles ASC");
		
			foreach ($query->rows as $result) {
				$images_data[] = array(
					'news_gallery_image' => $result['news_gallery_image'],
					'news_gallery_id' => $result['news_gallery_id'],
					'news_gallery_titles' => $result['news_gallery_titles'],
					'news_gallery_order'  => $result['news_gallery_order']
				);
			}	
	
			$this->cache->set('images.' . $this->config->get('config_language_id') , $images_data);
			}
		}
		return $images_data;
	}
	
	public function getNewsImagesDescriptions($image_id) {
		$image_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_description WHERE 	news_gallery_id = '" . (int)$image_id . "'");
		
		foreach ($query->rows as $result) {
			$image_description_data[$result['language_id']] = array(
				'news_images_titles' => $result['news_gallery_titles'],
				'news_images_description' => $result['news_gallery_description']
			);
		}
		
		return $image_description_data;
	}	
	
	public function getNewsimagesStores($image_id) {
		$image_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_to_store WHERE news_gallery_id = '" . (int)$image_id . "'");

		foreach ($query->rows as $result) {
			$image_store_data[] = $result['store_id'];
		}
		
		return $image_store_data;
	}

	public function getNewsImagesLayouts($image_id) {
		$image_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_to_layout WHERE news_gallery_id = '" . (int)$image_id . "'");
		
		foreach ($query->rows as $result) {
			$image_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $image_layout_data;
	}
		
	public function getNewsAlbums($image_id) {
		$news_albums_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_to_album WHERE news_gallery_id = '" . (int)$image_id . "'");
		
		foreach ($query->rows as $result) {
			$news_albums_data[] = $result['news_gallery_album_id'];
		}

		return $news_albums_data;
	}		
	
	public function getTotalImages()
	{
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_gallery ga LEFT JOIN " . DB_PREFIX . "news_gallery_description gad ON (ga.news_gallery_id = gad.news_gallery_id) WHERE gad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
}
?>