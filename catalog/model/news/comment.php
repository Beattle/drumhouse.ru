<?php
class ModelNewsComment extends Model
{
	
	public function Addcomment($news_id,$data)
	{
		$query = "INSERT INTO ".DB_PREFIX."news_comment SET news_news_id = '".(int)$news_id."',news_comment_author ='".$this->db->escape($data['author'])."',news_comment_date_added = NOW(),news_comment_date_modified = NOW(),news_comment_text='".$this->db->escape(strip_tags($data['text']))."',news_comment_title = '".$this->db->escape($data['title'])."',news_comment_email='".$this->db->escape($data['email'])."',news_comment_link='".$this->db->escape($data['link'])."',news_comment_status='".$data['status']."'";
		$this->db->query($query);
		$last_id = $this->db->getLastId();
		$last_comment = $this->getCommentbyId($last_id);
		return $last_comment;
	}
	public function getCommentbyId($comment_id)
	{
		$result = $this->db->query("SELECT * FROM ".DB_PREFIX."news_comment WHERE news_comment_id ='".(int)$comment_id."' AND news_comment_status = '1'");
		return $result->row;
		
	}
	public function getCommentbyNewsid($news_id,$data = array())
	{
		$sql = "SELECT * FROM ".DB_PREFIX."news_comment nc LEFT JOIN ".DB_PREFIX."news n ON(n.news_id = nc.news_news_id) LEFT JOIN ".DB_PREFIX."news_description nd ON(n.news_id = nd.news_id) LEFT JOIN ".DB_PREFIX."news_to_store ns ON(n.news_id = ns.news_id) WHERE n.news_status = '1' AND nd.language_id ='".(int)$this->config->get('config_language_id')."' AND ns.store_id='".(int)$this->config->get('store_id')."' AND nc.news_comment_status = '1' AND nc.news_news_id = '".(int)$news_id."' ORDER BY nc.news_comment_date_added DESC";
		
		if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		$results = $this->db->query($sql);
		return $results->rows;
	}
	public function getGravatar($email)
	{
			return '<img src="http://www.gravatar.com/avatar.php?gravatar_id='.md5(strtolower(trim($email))).'&rating=PG" width="'.(int)$this->config->get('news_config_gravatar_w').'px" height="'.(int)$this->config->get('news_config_gravatar_h').'px" />';
	}
}
?>