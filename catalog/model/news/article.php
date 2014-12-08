<?php
class ModelNewsArticle extends Model
{
	public function updateViewed($news_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "news SET news_viewed = (news_viewed + 1) WHERE news_id = '" . (int)$news_id . "'");
	}
	public function getNewsArticle($news_id)
	{
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

        $sql  = "SELECT * FROM ". DB_PREFIX ."news n ";
        $sql .= "LEFT JOIN ". DB_PREFIX ."news_description nd ON (n.news_id = nd.news_id) ";
        $sql .= "LEFT JOIN ". DB_PREFIX ."news_to_category n2c ON (n.news_id = n2c.news_id) ";
        $sql .= "LEFT JOIN ". DB_PREFIX ."news_category nc ON (nc.news_category_id = n2c.news_category_id) ";
        $sql .= "LEFT JOIN ". DB_PREFIX ."news_category_description ncd ON (n2c.news_category_id = ncd.news_category_id) ";
        $sql .= "LEFT JOIN ". DB_PREFIX ."news_to_store ns ON (n.news_id = ns.news_id) ";
        $sql .= "WHERE n.news_id = '" . (int)$news_id . "' ";
        $sql .= "AND ns.store_id = '" .(int)$this->config->get('config_store_id')."' ";
        $sql .= "AND nd.language_id='".(int)$this->config->get('config_language_id')."' ";
        $sql .= "AND n.news_status = '1' ";
        $sql .= "ORDER BY n.news_date_modified ASC";

        //$this->log->write($sql);
		$query = $this->db->query($sql);
		
		if($query->num_rows)
		{
			return array(
				'news_id' => $query->row['news_id'],
				'news_image' => $query->row['news_image'],
				'news_date_modified' => $query->row['news_date_modified'],
				'news_date_added' => $query->row['news_date_added'],
				'news_viewed' => $query->row['news_viewed'],
				'news_comment' => $query->row['news_comment'],
				'news_vote' => $query->row['news_vote'],
				'news_titles' => $query->row['news_titles'],
				'news_description' => $query->row['news_description'],
				'news_meta_description' => $query->row['news_meta_description'],
				'news_meta_keyword' => $query->row['news_meta_keyword'],
				'news_category_parent_id' => $query->row['news_category_parent_id'],
				'news_category_id' => $query->row['news_category_id'],
				'news_category_name' => $query->row['news_category_name'],
				'news_total_comment' => $this->getTotalComment((int)$query->row['news_id']),
				'news_showdate' => $query->row['news_showdate'],
				'news_showvote' => $query->row['news_showvote'],
				'news_showview' => $query->row['news_showview'],
				'news_showrelated' => $query->row['news_showrelated'],
				'news_showproduct' => $query->row['news_showproduct']
			);
		}
		else
		{
			return false;
		}
	}
	public function getNewsArticleCategory($data = array())
	{
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$cache = md5(http_build_query($data));
		
		$news_article_data = $this->cache->get('news.article.' . $cache . '.' . $customer_group_id);
		
		if (!$news_article_data) {
		
			$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON(n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store ns ON(n.news_id = ns.news_id) WHERE ns.store_id = '".(int)$this->config->get('config_store_id')."' AND nd.language_id = '" . (int)$this->config ->get('config_language_id'). "' AND n.news_status = '1'";
			
			if (isset($data['filter_tag']) && $data['filter_tag']) {
			$sql .= " AND n.news_id IN (SELECT n.news_id FROM " . DB_PREFIX . "news_tag nt WHERE nt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(nt.news_tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_tag'], 'UTF-8')) . "%')";
			}
										
			if (isset($data['filter_category_id']) && $data['filter_category_id']) {
				if (isset($data['filter_sub_category']) && $data['filter_sub_category']) {
					$implode_data = array();
					
					$this->load->model('news/category');
					
					$categories = $this->model_news_category->getNewsCategoriesByParentId($data['filter_category_id']);
					
					foreach ($categories as $category_id) {
						$implode_data[] = "nc.news_category_id = '" . (int)$category_id . "'";
					}
					
					$sql .= " AND n.news_id IN (SELECT nc.news_id FROM " . DB_PREFIX . "news_to_category nc WHERE " . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND n.news_id IN (SELECT nc.news_id FROM " . DB_PREFIX . "news_to_category nc WHERE nc.news_category_id = '" . (int)$data['filter_category_id'] . "')";
				}
			}
			
			$sql .= " GROUP BY n.news_id";
			
			$sort_data = array(
				'nd.news_titles',
				'n.news_date_added',
				'n.news_date_modified',
				'n.news_viewed',
				'n.news_vote',
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'nd.news_titles') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				}else{
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY n.news_sort_order";	
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
			
			$news_article_data = array();
					
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$news_article_data[$result['news_id']] = $this->getNewsArticle($result['news_id']);
			}
			
			$this->cache->set('news.article.' . $cache . '.' . $customer_group_id, $news_article_data);
		}
		
		return $news_article_data;
	}
	
	public function getTotalComment($news_id)
	{
		$sql = "SELECT COUNT(DISTINCT news_comment_id) AS total FROM " . DB_PREFIX . "news_comment WHERE news_news_id = '".(int)$news_id."' AND news_comment_status = '1'";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	public function getNewsTotalArticle($data = array())
	{
			$sql = "SELECT COUNT(DISTINCT n.news_id) AS total FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON(n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store ns ON(n.news_id = ns.news_id) WHERE ns.store_id = '".(int)$this->config->get('config_store_id')."' AND nd.language_id = '" . (int)$this->config ->get('config_language_id'). "' AND n.news_status = '1'";
			
			if (isset($data['filter_tag']) && $data['filter_tag']) {
			$sql .= " AND n.news_id IN (SELECT nt.news_id FROM " . DB_PREFIX . "news_tag nt WHERE nt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(nt.news_tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_tag'], 'UTF-8')) . "%')";
			}
										
			if (isset($data['filter_category_id']) && $data['filter_category_id']) {
				if (isset($data['filter_sub_category']) && $data['filter_sub_category']) {
					$implode_data = array();
					
					$this->load->model('news/category');
					
					$categories = $this->model_news_category->getNewsCategoriesByParentId($data['filter_category_id']);
					
					foreach ($categories as $category_id) {
						$implode_data[] = "nc.news_category_id = '" . (int)$category_id . "'";
					}
					
					$sql .= " AND n.news_id IN (SELECT nc.news_id FROM " . DB_PREFIX . "news_to_category nc WHERE " . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND n.news_id IN (SELECT nc.news_id FROM " . DB_PREFIX . "news_to_category nc WHERE nc.news_category_id = '" . (int)$data['filter_category_id'] . "')";
				}
			}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function updateVote($news_id)
	{
		$this->db->query("UPDATE " . DB_PREFIX . "news SET news_vote = (news_vote + 1) WHERE news_id = '" . (int)$news_id . "'");
	}
	public function getAllowcomment($news_id)
	{
		$sql = "SELECT news_comment FROM " . DB_PREFIX . "news WHERE news_id = '".(int)$news_id."' AND news_status = '1'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getNewsArticleTags($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_tag WHERE news_id = '" . (int)$news_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->rows;
	}

	public function getCatidbyArticleid($news_id)
	{
		$result = $this->db->query("SELECT news_category_id FROM ". DB_PREFIX ."news_to_category WHERE news_id ='".(int)$news_id."' GROUP BY news_id");
		return $result->row;
	}
	public function getArticleTopmenu()
	{
		$result = $this->db->query("SELECT n.news_id,nd.news_titles,n.news_sort_order FROM ".DB_PREFIX."news n INNER JOIN ".DB_PREFIX."news_description nd ON(n.news_id = nd.news_id) INNER JOIN ".DB_PREFIX."news_to_store n2t ON(n.news_id = n2t.news_id) AND n.news_top = '1' AND n2t.store_id='".(int)$this->config->get('store_id')."' AND nd.language_id='".(int)$this->config->get('config_language_id')."'");
		return $result->rows;
		return $result->rows;
	}

	public function getArticleRelated($news_id) {
		$article_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_related nl LEFT JOIN " . DB_PREFIX . "news n ON (nl.related_id = n.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE nl.news_id = '" . (int)$news_id . "' AND n.news_status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$article_data[$result['related_id']] = $this->getNewsArticle($result['related_id']);
		}
		
		return $article_data;
	}
	public function getArticleRelatedproduct($news_id) {
		$product_data = array();
		$this->load->model('catalog/product');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_related_product np LEFT JOIN " . DB_PREFIX . "product p ON (np.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE np.news_id = '" . (int)$news_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $product_data;
	}
}
?>