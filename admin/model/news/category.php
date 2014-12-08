<?php
class ModelNewsCategory extends Model {
	public function addNewsCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_category SET news_category_parent_id = '" . (int)$data['news_category_parent_id'] . "', `news_category_top` = '" . (isset($data['news_category_top']) ? (int)$data['news_category_top'] : 0) . "', `news_category_column` = '" . (int)$data['news_category_column'] . "', news_category_sort_order = '" . (int)$data['news_category_sort_order'] . "', news_category_status = '" . (int)$data['news_category_status'] . "', news_category_date_added = NOW(), news_category_date_modified = NOW()");
	
		$news_category_id = $this->db->getLastId();
		
		if (isset($data['news_category_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_category SET news_category_image = '" . $this->db->escape($data['news_category_image']) . "' WHERE news_category_id = '" . (int)$news_category_id . "'");
		}
		
		foreach ($data['news_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_description SET news_category_id = '" . (int)$news_category_id . "', language_id = '" . (int)$language_id . "', news_category_name = '" . $this->db->escape($value['news_category_name']) . "', news_category_meta_keyword = '" . $this->db->escape($value['news_category_meta_keyword']) . "', news_category_meta_description = '" . $this->db->escape($value['news_category_meta_description']) . "', news_category_description = '" . $this->db->escape($value['news_category_description']) . "'");
		}
		
		if (isset($data['news_category_store'])) {
			foreach ($data['news_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_to_store SET news_category_id = '" . (int)$news_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['news_category_layout'])) {
			foreach ($data['news_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_to_layout SET 	news_category_id = '" . (int)$news_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['news_category_meta_keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_category_id=" . (int)$news_category_id . "', keyword = '" . $this->db->escape($data['news_category_meta_keyword']) . "'");
		}
		
		$this->cache->delete('news_category');
	}
	
	public function editNewsCategory($news_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news_category SET news_category_parent_id = '" . (int)$data['news_category_parent_id'] . "', `news_category_top` = '" . (isset($data['news_category_top']) ? (int)$data['news_category_top'] : 0) . "', `news_category_column` = '" . (int)$data['news_category_column'] . "', news_category_sort_order = '" . (int)$data['news_category_sort_order'] . "', news_category_status = '" . (int)$data['news_category_status'] . "', news_category_date_added = NOW() WHERE news_category_id = '" . (int)$news_category_id . "'");

		if (isset($data['news_category_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news_category SET news_category_image = '" . $this->db->escape($data['news_category_image']) . "' WHERE news_category_id = '" . (int)$news_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_description WHERE news_category_id = '" . (int)$news_category_id . "'");

		foreach ($data['news_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_description SET news_category_id = '" . (int)$news_category_id . "', language_id = '" . (int)$language_id . "', news_category_name = '" . $this->db->escape($value['news_category_name']) . "', news_category_meta_keyword = '" . $this->db->escape($value['news_category_meta_keyword']) . "', news_category_meta_description = '" . $this->db->escape($value['news_category_meta_description']) . "', news_category_description = '" . $this->db->escape($value['news_category_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_to_store WHERE news_category_id = '" . (int)$news_category_id . "'");
		
		if (isset($data['news_category_store'])) {		
			foreach ($data['news_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_to_store SET news_category_id = '" . (int)$news_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_to_layout WHERE news_category_id = '" . (int)$news_category_id . "'");

		if (isset($data['news_category_layout'])) {
			foreach ($data['news_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_category_to_layout SET news_category_id = '" . (int)$news_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_category_id=" . (int)$news_category_id. "'");
		
		if ($data['news_category_meta_keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_category_id=" . (int)$news_category_id . "', keyword = '" . $this->db->escape($data['news_category_meta_keyword']) . "'");
		}
		
		$this->cache->delete('news_category');
	}
	
	public function deleteNewsCategory($news_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category WHERE news_category_id = '" . (int)$news_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_description WHERE news_category_id = '" . (int)$news_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_to_store WHERE news_category_id = '" . (int)$news_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_category_to_layout WHERE news_category_id = '" . (int)$news_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_category_id=" . (int)$news_category_id . "'");
		
		$query = $this->db->query("SELECT news_category_id FROM " . DB_PREFIX . "news_category WHERE news_category_parent_id = '" . (int)$news_category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteNewsCategory($result['news_category_id']);
		}
		
		$this->cache->delete('news_category');
	} 

	public function getNewsCategory($news_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_category_id=" . (int)$news_category_id . "') AS news_category_meta_keyword FROM " . DB_PREFIX . "news_category WHERE news_category_id = '" . (int)$news_category_id . "'");
		
		return $query->row;
	} 
	
	public function getNewsCategories($news_parent_id) {
		$news_category_data = $this->cache->get('news_category.' . $this->config->get('config_language_id') . '.' . $news_parent_id);
	
		if (!$news_category_data) {
			$news_category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) WHERE c.news_category_parent_id = '" . (int)$news_parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.news_category_sort_order, cd.news_category_name ASC");
		
			foreach ($query->rows as $result) {
				$news_category_data[] = array(
					'news_category_id' => $result['news_category_id'],
					'news_category_name' => $this->getNewsPath($result['news_category_id'], $this->config->get('config_language_id')),
					'news_category_status' => $result['news_category_status'],
					'news_category_sort_order'  => $result['news_category_sort_order']
				);
			
				$news_category_data = array_merge($news_category_data, $this->getNewsCategories($result['news_category_id']));
			}	
	
			$this->cache->set('news_category.' . $this->config->get('config_language_id') . '.' . $news_parent_id, $news_category_data);
		}
		
		return $news_category_data;
	}
	
	public function getNewsPath($news_category_id) {
		$query = $this->db->query("SELECT news_category_name, news_category_parent_id FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) WHERE c.news_category_id = '" . (int)$news_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.news_category_sort_order, cd.news_category_name ASC");
		
		$news_category_info = $query->row;
		
		if ($news_category_info['news_category_parent_id']) {
			return $this->getNewsPath($news_category_info['news_category_parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $news_category_info['news_category_name'];
		} else {
			return $news_category_info['news_category_name'];
		}
	}
	
	public function getNewsCategoryDescriptions($news_category_id) {
		$news_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_description WHERE news_category_id = '" . (int)$news_category_id . "'");
		
		foreach ($query->rows as $result) {
			$news_category_description_data[$result['language_id']] = array(
				'news_category_name' => $result['news_category_name'],
				'news_category_meta_keyword' => $result['news_category_meta_keyword'],
				'news_category_meta_description' => $result['news_category_meta_description'],
				'news_category_description' => $result['news_category_description']
			);
		}
		
		return $news_category_description_data;
	}	
	
	public function getNewsCategoryStores($news_category_id) {
		$category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_to_store WHERE news_category_id = '" . (int)$news_category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		
		return $category_store_data;
	}

	public function getNewsCategoryLayouts($news_category_id) {
		$news_category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_to_layout WHERE news_category_id = '" . (int)$news_category_id . "'");
		
		foreach ($query->rows as $result) {
			$news_category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $news_category_layout_data;
	}
		
	public function getTotalNewsCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category");
		
		return $query->row['total'];
	}	
		
	public function getTotalNewsCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>