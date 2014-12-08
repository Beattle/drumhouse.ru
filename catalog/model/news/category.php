<?php
class ModelNewsCategory extends Model {
	public function getNewsCategory($news_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.news_category_id = '" . (int)$news_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.news_category_status = '1'");
		
		return $query->row;
	}
	
	public function getNewsCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.news_category_parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.news_category_status = '1' ORDER BY c.news_category_sort_order, LCASE(cd.news_category_name)");
		
		return $query->rows;
	}

	public function getNewsCategoriesByParentId($news_category_id) {
		$news_category_data = array();
		
		$news_category_data[] = $news_category_id;
		
		$news_category_query = $this->db->query("SELECT news_category_id FROM " . DB_PREFIX . "news_category WHERE news_category_parent_id = '" . (int)$news_category_id . "'");
		
		foreach ($news_category_query->rows as $news_category) {
			$children = $this->getNewsCategoriesByParentId($news_category['news_category_id']);
			
			if ($children) {
				$news_category_data = array_merge($children, $news_category_data);
			}			
		}
		
		return $news_category_data;
	}
		
	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_category');
		}
	}
					
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}
}
?>