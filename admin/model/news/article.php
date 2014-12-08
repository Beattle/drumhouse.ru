<?php
class ModelNewsArticle extends Model {
	public function addNewsArticle($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET news_comment= '" . (isset($data['news_comment']) ? (int)$data['news_comment'] : 0) . "',news_top='".(isset($data['news_top']) ? (int)$data['news_top'] : 0) . "',news_showdate = '". (isset($data['news_showdate']) ? (int)$data['news_showdate'] : 0)."',news_showvote = '". (isset($data['news_showvote']) ? (int)$data['news_showvote'] : 0)."',news_showview = '". (isset($data['news_showview']) ? (int)$data['news_showview'] : 0)."',news_showrelated = '". (isset($data['news_showrelated']) ? (int)$data['news_showrelated'] : 0)."',news_showproduct = '". (isset($data['news_showproduct']) ? (int)$data['news_showproduct'] : 0)."', news_sort_order = '" . (int)$data['news_sort_order'] . "', news_status = '" . (int)$data['news_status'] . "', news_date_added = NOW(), news_date_modified = NOW(), news_vote = '0'");
	
		$news_id = $this->db->getLastId();
		
		if (isset($data['news_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET news_image = '" . $this->db->escape($data['news_image']) . "' WHERE news_id = '" . (int)$news_id . "'");
		}
		
		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', news_titles = '" . $this->db->escape($value['news_titles']) . "', news_meta_keyword = '" . $this->db->escape($value['news_meta_keyword']) . "', news_meta_description = '" . $this->db->escape($value['news_meta_description']) . "', news_description = '" . $this->db->escape($value['news_description']) . "'");
		}
		if (isset($data['news_category'])) {
			foreach ($data['news_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_category SET news_id = '" . (int)$news_id . "', news_category_id = '" . (int)$category_id . "'");
			}
		}
		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_store SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['news_layout'])) {
			foreach ($data['news_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_layout SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['news_meta_keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['news_meta_keyword']) . "'");
		}
		
		foreach ($data['news_tags'] as $language_id => $value) {
			if ($value) {
				$tags = explode(',', $value);
				
				foreach ($tags as $tag) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_tag SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', news_tag = '" . $this->db->escape(trim($tag)) . "'");
				}
			}
		}
		//
		
		
		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related SET news_id = '" . (int)$news_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$related_id . "' AND related_id = '" . (int)$news_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related SET news_id = '" . (int)$related_id . "', related_id = '" . (int)$news_id . "'");
			}
		}
		//product related 
		
		if (isset($data['article_product'])) {
			foreach ($data['article_product'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$news_id . "' AND product_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related_product SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$product_id . "' AND product_id = '" . (int)$news_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related_product SET news_id = '" . (int)$product_id . "', product_id = '" . (int)$news_id . "'");
			}
		}
		
		$this->cache->delete('news');
	}
	
	public function editNewsArticle($news_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news SET news_comment = '" . (isset($data['news_comment']) ? (int)$data['news_comment'] : 0) . "',news_top='".(isset($data['news_top']) ? (int)$data['news_top'] : 0) . "',news_showdate = '". (isset($data['news_showdate']) ? (int)$data['news_showdate'] : 0)."',news_showvote = '". (isset($data['news_showvote']) ? (int)$data['news_showvote'] : 0)."',news_showview = '". (isset($data['news_showview']) ? (int)$data['news_showview'] : 0)."',news_showrelated = '". (isset($data['news_showrelated']) ? (int)$data['news_showrelated'] : 0)."',news_showproduct = '". (isset($data['news_showproduct']) ? (int)$data['news_showproduct'] : 0)."',news_sort_order = '" . (int)$data['news_sort_order'] . "', news_status = '" . (int)$data['news_status'] . "', news_date_added = NOW() WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['news_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET news_image = '" . $this->db->escape($data['news_image']) . "' WHERE news_id = '" . (int)$news_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");

		foreach ($data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', news_titles = '" . $this->db->escape($value['news_titles']) . "', news_meta_keyword = '" . $this->db->escape($value['news_meta_keyword']) . "', news_meta_description = '" . $this->db->escape($value['news_meta_description']) . "', news_description = '" . $this->db->escape($value['news_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_category WHERE news_id = '" . (int)$news_id . "'");
		if (isset($data['news_category'])) {
			foreach ($data['news_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_category SET news_id = '" . (int)$news_id . "', news_category_id = '" . (int)$category_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_store WHERE news_id = '" . (int)$news_id . "'");
		
		if (isset($data['news_store'])) {		
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_store SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['news_layout'])) {
			foreach ($data['news_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_layout SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
		
		if ($data['news_meta_keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['news_meta_keyword']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_tag WHERE news_id = '" . (int)$news_id. "'");
		foreach ($data['news_tags'] as $language_id => $value) {
			if ($value) {
				$tags = explode(',', $value);
				
				foreach ($tags as $tag) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_tag SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', news_tag = '" . $this->db->escape(trim($tag)) . "'");
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE related_id = '" . (int)$news_id . "'");
		
		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related SET news_id = '" . (int)$news_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$related_id . "' AND related_id = '" . (int)$news_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related SET news_id = '" . (int)$related_id . "', related_id = '" . (int)$news_id . "'");
			}
		}
		//article product
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE product_id = '" . (int)$news_id . "'");
		
		if (isset($data['article_product'])) {
			foreach ($data['article_product'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$news_id . "' AND product_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related_product SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$product_id . "' AND product_id = '" . (int)$news_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related_product SET news_id = '" . (int)$product_id . "', product_id = '" . (int)$news_id . "'");
			}
		}
		$this->cache->delete('news');
	}
	
	public function deleteNewsArticle($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_store WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_category WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_tag WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_comment WHERE news_news_id = '".(int)$news_id. "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE related_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related_product WHERE product_id = '" . (int)$news_id . "'");
		$this->cache->delete('news');
	} 

	public function getNewsArticle($news_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "') AS news_meta_keyword FROM " . DB_PREFIX . "news n LEFT JOIN ".DB_PREFIX."news_description nd ON(n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '".(int)$this->config->get('config_language_id'). "'");
		
		return $query->row;
	} 
	
	public function getNewsArticles($data = array()) {
		if($data)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
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
			$news_data = $this->cache->get('news.' . $this->config->get('config_language_id'));
	
		if (!$news_data) {
			$news_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news c LEFT JOIN " . DB_PREFIX . "news_description cd ON (c.news_id = cd.news_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.news_sort_order, cd.news_titles ASC");
		
			foreach ($query->rows as $result) {
				$news_data[] = array(
					'news_image' => $result['news_image'],
					'news_id' => $result['news_id'],
					'news_titles' => $result['news_titles'],
					'news_status' => $result['news_status'],
					'news_sort_order'  => $result['news_sort_order']
				);
			}	
	
			$this->cache->set('news.' . $this->config->get('config_language_id') , $news_data);
			}
		}
		return $news_data;
	}
	
	public function getNewsArticleDescriptions($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'news_titles' => $result['news_titles'],
				'news_meta_keyword' => $result['news_meta_keyword'],
				'news_meta_description' => $result['news_meta_description'],
				'news_description' => $result['news_description']
			);
		}
		
		return $news_description_data;
	}	
	
	public function getNewsArticleStores($news_id) {
		$news_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_store WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_store_data[] = $result['store_id'];
		}
		
		return $news_store_data;
	}

	public function getNewsArticleLayouts($news_id) {
		$news_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $news_layout_data;
	}
		
	public function getNewsCategories($news_id) {
		$news_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_category WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_category_data[] = $result['news_category_id'];
		}

		return $news_category_data;
	}		
	
	public function getNewsTags($news_id) {
		$news_tag_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_tag WHERE news_id = '" . (int)$news_id . "'");
		
		$tag_data = array();
		
		foreach ($query->rows as $result) {
			$tag_data[$result['language_id']][] = $result['news_tag'];
		}
		
		foreach ($tag_data as $language => $tags) {
			$news_tag_data[$language] = implode(',', $tags);
		}
		
		return $news_tag_data;
	}
	
	public function getTotalArtilce()
	{
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function AjaxAutocomplete($data = array())
	{
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$sql .= " AND LCASE(nd.news_titles) LIKE '" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%'";
			}
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND n.news_status = '" . (int)$data['filter_status'] . "'";
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
			$news_article_data = $this->cache->get('article.' . $this->config->get('config_language_id'));
		
			if (!$news_product_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY nd.news_titles ASC");
	
				$news_article_data = $query->rows;
			
				$this->cache->set('article.' . $this->config->get('config_language_id'), $news_article_data);
			}	
	
			return $news_article_data;
		}
	}
	public function getArticleRelated($news_id) {
		$article_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}
		
		return $article_related_data;
	}
	public function getArticleRelatedProduct($news_id) {
		$article_related_product = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_related_product WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_product[] = $result['product_id'];
		}
		
		return $article_related_product;
	}
}
?>