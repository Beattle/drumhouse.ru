<?php
class ModelNewsComment extends Model
{
	public function addNewsComment($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."news_comment SET news_news_id = '".(int)$data['news_id']."',news_comment_author ='".$this->db->escape($data['author'])."',news_comment_date_added = NOW(),news_comment_date_modified = NOW(),news_comment_text='".$this->db->escape(strip_tags($data['text']))."',news_comment_title = '".$this->db->escape($data['title'])."',news_comment_email='".$this->db->escape($data['email'])."',news_comment_link='".$this->db->escape($data['link'])."',news_comment_status='".(int)$data['status']."'");
	}
	
	public function editNewsComment($news_comment_id, $data) {
		$this->db->query("UPDATE ".DB_PREFIX."news_comment SET news_news_id = '".(int)$data['news_id']."',news_comment_author ='".$this->db->escape($data['author'])."',news_comment_date_modified = NOW(),news_comment_text='".$this->db->escape(strip_tags($data['text']))."',news_comment_title = '".$this->db->escape($data['title'])."',news_comment_email='".$this->db->escape($data['email'])."',news_comment_link='".$this->db->escape($data['link'])."',news_comment_status='".(int)$data['status']."' WHERE news_comment_id='".(int)$news_comment_id."'");
	}
	
	public function deleteNewsComment($news_comment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_comment WHERE news_comment_id = '" . (int)$news_comment_id . "'");
	}
	
	public function getNewsComment($news_comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT nd.news_titles FROM " . DB_PREFIX . "news_description nd WHERE nd.news_id = nc.news_news_id AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS article FROM " . DB_PREFIX . "news_comment nc WHERE nc.news_comment_id = '" . (int)$news_comment_id . "'");
		
		return $query->row;
	}

	public function getNewsComments($data = array()) {
		$sql = "SELECT nc.news_comment_id, nd.news_titles, nc.news_comment_author, nc.news_comment_status, nc.news_comment_date_added FROM " . DB_PREFIX . "news_comment nc LEFT JOIN " . DB_PREFIX . "news_description nd ON (nc.news_news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";																																					  
		
		$sort_data = array(
			'nd.news_titles',
			'nc.news_comment_author',
			'nc.news_comment_status',
			'nc.news_comment_date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY nc.news_comment_date_added";	
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
	}
	
	public function getTotalNewsComment() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_comment");
		
		return $query->row['total'];
	}
	
	public function getTotalNewsCommentAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_comment WHERE news_comment_status = '0'");
		
		return $query->row['total'];
	}	
}
?>