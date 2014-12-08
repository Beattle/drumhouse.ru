<?php
class ModelNewsAlbums extends Model {
	public function addNewsAlbums($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album SET news_gallery_album_parent_id = '" . (int)$data['news_albums_parent_id'] . "', news_gallery_album_sort_order = '" . (int)$data['news_albums_sort_order'] . "', news_gallery_album_status = '" . (int)$data['news_albums_status'] . "', news_gallery_album_date_added = NOW(), news_gallery_album_date_modified = NOW()");
	
		$news_albums_id = $this->db->getLastId();
		
		if (isset($data['news_albums_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_gallery_album SET news_gallery_album_image = '" . $this->db->escape($data['news_albums_image']) . "' WHERE news_gallery_album_id = '" . (int)$news_albums_id . "'");
		}
		
		foreach ($data['news_albums_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album_description SET news_gallery_album_id = '" . (int)$news_albums_id . "', language_id = '" . (int)$language_id . "', news_gallery_album_name = '" . $this->db->escape($value['news_albums_name']) . "', news_gallery_album_meta_keyword = '" . $this->db->escape($value['news_albums_meta_keyword']) . "', news_gallery_album_meta_description = '" . $this->db->escape($value['news_albums_meta_description']) . "', news_gallery_album_description = '" . $this->db->escape($value['news_albums_description']) . "'");
		}
		
		if (isset($data['news_albums_store'])) {
			foreach ($data['news_albums_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album_to_store SET news_gallery_album_id = '" . (int)$news_albums_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['news_albums_layout'])) {
			foreach ($data['news_albums_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album_to_layout SET news_gallery_album_id = '" . (int)$news_albums_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['news_albums_meta_keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$news_albums_id . "', keyword = '" . $this->db->escape($data['news_albums_meta_keyword']) . "'");
		}
		
		$this->cache->delete('news_albums');
	}
	
	public function editNewsAlbums($news_album_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news_gallery_album SET news_gallery_album_parent_id = '" . (int)$data['news_albums_parent_id'] . "', news_gallery_album_sort_order = '" . (int)$data['news_albums_sort_order'] . "', news_gallery_album_status = '" . (int)$data['news_albums_status'] . "', news_gallery_album_date_modified = NOW() WHERE news_gallery_album_id  = '" . (int)$news_album_id . "'");

		if (isset($data['news_albums_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_gallery_album SET news_gallery_album_image = '" . $this->db->escape($data['news_albums_image']) . "' WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album_description WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");

		foreach ($data['news_albums_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album_description SET news_gallery_album_id = '" . (int)$news_album_id . "', language_id = '" . (int)$language_id . "', news_gallery_album_name = '" . $this->db->escape($value['news_albums_name']) . "', news_gallery_album_meta_keyword = '" . $this->db->escape($value['news_albums_meta_keyword']) . "', news_gallery_album_meta_description = '" . $this->db->escape($value['news_albums_meta_description']) . "', news_gallery_album_description = '" . $this->db->escape($value['news_albums_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album_to_store WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		
		if (isset($data['news_albums_store'])) {		
			foreach ($data['news_albums_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album_to_store SET news_gallery_album_id = '" . (int)$news_album_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album_to_layout WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");

		if (isset($data['news_albums_layout'])) {
			foreach ($data['news_albums_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_gallery_album_to_layout SET news_gallery_album_id = '" . (int)$news_album_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$news_album_id. "'");
		
		if ($data['news_albums_meta_keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$news_album_id . "', keyword = '" . $this->db->escape($data['news_albums_meta_keyword']) . "'");
		}
		
		$this->cache->delete('news_albums');
	}
	
	public function deleteNewsAlbums($news_album_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album_description WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album_to_store WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_gallery_album_to_layout WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$news_album_id . "'");
		
		$query = $this->db->query("SELECT news_gallery_album_id FROM " . DB_PREFIX . "news_gallery_album WHERE news_gallery_album_parent_id = '" . (int)$news_album_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteNewsAlbums($result['news_gallery_album_id']);
		}
		
		$this->cache->delete('news_albums');
	} 

	public function getNewsAlbum($news_album_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$news_album_id . "') AS news_gallery_album_meta_keyword FROM " . DB_PREFIX . "news_gallery_album WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		
		return $query->row;
	} 
	
	public function getNewsAlbums($gallery_album_id) {
		$news_albums_data = $this->cache->get('news_albums.' . $this->config->get('config_language_id') . '.' . $gallery_album_id);
	
		if (!$news_albums_data) {
			$news_albums_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_album ga LEFT JOIN " . DB_PREFIX . "news_gallery_album_description gad ON (ga.news_gallery_album_id = gad.news_gallery_album_id) WHERE ga.news_gallery_album_parent_id = '" . (int)$gallery_album_id . "' AND gad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ga.news_gallery_album_sort_order, gad.news_gallery_album_name ASC");
		
			foreach ($query->rows as $result) {
				$news_albums_data[] = array(
					'news_gallery_album_id' => $result['news_gallery_album_id'],
					'news_gallery_album_name' => $this->getNewsAlbumsPath($result['news_gallery_album_id'], $this->config->get('config_language_id')),
					'news_gallery_album_status' => $result['news_gallery_album_status'],
					'news_gallery_album_image' => $result['news_gallery_album_image'],
					'news_gallery_album_sort_order'  => $result['news_gallery_album_sort_order']
				);
			
				$news_albums_data = array_merge($news_albums_data, $this->getNewsAlbums($result['news_gallery_album_id']));
			}	
	
			$this->cache->set('news_albums.' . $this->config->get('config_language_id') . '.' . $gallery_album_id, $news_albums_data);
		}
		
		return $news_albums_data;
	}
	
	public function getNewsAlbumsPath($news_albums_id) {
		$query = $this->db->query("SELECT news_gallery_album_name, news_gallery_album_parent_id FROM " . DB_PREFIX . "news_gallery_album ga LEFT JOIN " . DB_PREFIX . "news_gallery_album_description gad ON (ga.news_gallery_album_id = gad.news_gallery_album_id) WHERE ga.news_gallery_album_id = '" . (int)$news_albums_id . "' AND gad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ga.news_gallery_album_sort_order, gad.news_gallery_album_name ASC");
		
		$news_album_info = $query->row;
		
		if ($news_album_info['news_gallery_album_parent_id']) {
			return $this->getNewsAlbumsPath($news_album_info['news_gallery_album_parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $news_album_info['news_gallery_album_name'];
		} else {
			return $news_album_info['news_gallery_album_name'];
		}
	}
	
	public function getNewsalbumsDescriptions($news_album_id) {
		$news_albums_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_album_description WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		
		foreach ($query->rows as $result) {
			$news_albums_description_data[$result['language_id']] = array(
				'news_albums_name' => $result['news_gallery_album_name'],
				'news_albums_meta_keyword' => $result['news_gallery_album_meta_keyword'],
				'news_albums_meta_description' => $result['news_gallery_album_meta_description'],
				'news_albums_description' => $result['news_gallery_album_description']
			);
		}
		
		return $news_albums_description_data;
	}	
	
	public function getNewsAlbumsStores($news_album_id) {
		$albums_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_album_to_store WHERE 	news_gallery_album_id = '" . (int)$news_album_id . "'");

		foreach ($query->rows as $result) {
			$albums_store_data[] = $result['store_id'];
		}
		
		return $albums_store_data;
	}

	public function getNewsAlbumsLayouts($news_album_id) {
		$news_album_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_gallery_album_to_layout WHERE news_gallery_album_id = '" . (int)$news_album_id . "'");
		
		foreach ($query->rows as $result) {
			$news_album_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $news_album_layout_data;
	}
		
	public function getTotalNewsAlbums() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_gallery_album");
		
		return $query->row['total'];
	}	
		
	public function getTotalNewsAlbumByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_gallery_album_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>