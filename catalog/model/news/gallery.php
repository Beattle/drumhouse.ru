<?php
class ModelNewsGallery extends Model{
	public function getAllAlbum($data){
		$data_albums = array();
		$query = ("SELECT * from ".DB_PREFIX."news_gallery_album ga LEFT JOIN ".DB_PREFIX."news_gallery_album_description gad ON(ga.news_gallery_album_id = gad.news_gallery_album_id) LEFT JOIN ".DB_PREFIX."news_gallery_album_to_store g2t ON (ga.news_gallery_album_id = g2t.news_gallery_album_id) WHERE gad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2t.store_id ='" . (int)$this->config->get('config_store_id') . "' AND ga.news_gallery_album_status = '1' ");
		
		$sort_data = array(
				'gad.news_gallery_album_name',
				'ga.news_gallery_album_date_added',
				'ga.news_gallery_album_date_modified'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'gad.news_gallery_album_name') {
					$query .= " ORDER BY LCASE(" . $data['sort'] . ")";
				}else{
					$query .= " ORDER BY " . $data['sort'];
				}
			} else {
				$query .= " ORDER BY ga.news_gallery_album_sort_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$query .= " DESC";
			} else {
				$query .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		$results = $this->db->query($query);	
		if($results->rows){
			foreach($results->rows as $result){
				$count = $this->countImages($result['news_gallery_album_id']);
				$data_albums[] = array(
					'albums_id' => $result['news_gallery_album_id'],
					'image'     => $result['news_gallery_album_image'],
					'albums_adddate' => $result['news_gallery_album_date_added'],
					'albums_name' => $result['news_gallery_album_name'],
					'albums_desc' => $result['news_gallery_album_description'],
					'albums_imgcount' => $count['total'],
					'albums_vote' => $count['vote']
				);
			}
		}else{
			$data_albums = false;
		}	
		return $data_albums;
	}
	public function countImages($album_id){
		$query = ("SELECT COUNT(DISTINCT ga.news_gallery_id) AS total,SUM(ga.news_gallery_vote) as vote FROM ".DB_PREFIX."news_gallery ga LEFT JOIN ".DB_PREFIX."news_gallery_description gad ON(ga.news_gallery_id = gad.news_gallery_id) LEFT JOIN ".DB_PREFIX."news_gallery_to_album gab ON(ga.news_gallery_id = gab.news_gallery_id) LEFT JOIN ".DB_PREFIX."news_gallery_to_store g2t ON (ga.news_gallery_id = g2t.news_gallery_id) WHERE gad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2t.store_id ='" . (int)$this->config->get('config_store_id') . "' AND ga.news_gallery_status = '1'");
		$includesub = $this->config->get('news_config_gallerysub');
		if(isset($includesub) && ($includesub == 1)){
			$subalbums = implode(',',$this->getAlbumsbyParent($album_id));
			$query .= " AND gab.news_gallery_album_id IN (".$subalbums.")";
		}else{
			$query .= " AND gab.news_gallery_album_id ='".(int)$album_id."'";
		}
		$count = $this->db->query($query);
		return $count->row;
	}
	public function getAlbumsbyParent($album_id){
		$news_album_data = array();
		
		$news_album_data[] = $album_id;
		
		$news_album_query = $this->db->query("SELECT news_gallery_album_id FROM " . DB_PREFIX . "news_gallery_album WHERE news_gallery_album_parent_id = '" . (int)$album_id . "'");
		
		foreach ($news_album_query->rows as $news_album) {
			$children = $this->getAlbumsbyParent($news_album['news_gallery_album_id']);
			
			if ($children) {
				$news_album_data = array_merge($children, $news_album_data);
			}			
		}
		
		return $news_album_data;
	}
	
	public function getTotalAlbums(){
		$sql = ("SELECT COUNT(DISTINCT ga.news_gallery_album_id) AS total FROM ".DB_PREFIX."news_gallery_album ga LEFT JOIN ".DB_PREFIX."news_gallery_album_description gad ON(ga.news_gallery_album_id = gad.news_gallery_album_id) LEFT JOIN ".DB_PREFIX."news_gallery_album_to_store g2t ON(ga.news_gallery_album_id = g2t.news_gallery_album_id) WHERE ga.news_gallery_album_status = '1' AND gad.language_id = '".(int)$this->config->get('config_language_id')."' AND g2t.store_id = '".(int)$this->config->get('config_store_id')."'");
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getAlbumsinfo($album_id){
		$query = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."news_gallery_album ga LEFT JOIN ".DB_PREFIX."news_gallery_album_description gad ON(ga.news_gallery_album_id = gad.news_gallery_album_id) LEFT JOIN ".DB_PREFIX."news_gallery_album_to_store g2t ON(ga.news_gallery_album_id = g2t.news_gallery_album_id) WHERE ga.news_gallery_album_id = '".(int)$album_id."' AND gad.language_id = '".(int)$this->config->get('config_language_id')."' AND g2t.store_id ='".(int)$this->config->get('config_store_id')."' AND ga.news_gallery_album_status = '1' ");
		return $query->row;
	}
	public function getImageAlbum($data,$album_id){
		$query = ("SELECT * FROM ".DB_PREFIX."news_gallery ga LEFT JOIN ".DB_PREFIX."news_gallery_description gad ON(ga.news_gallery_id = gad.news_gallery_id) LEFT JOIN ".DB_PREFIX."news_gallery_to_album gab ON(ga.news_gallery_id = gab.news_gallery_id) LEFT JOIN ".DB_PREFIX."news_gallery_to_store g2t ON (ga.news_gallery_id = g2t.news_gallery_id) WHERE gad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND g2t.store_id ='" . (int)$this->config->get('config_store_id') . "' AND ga.news_gallery_status = '1'");
		$includesub = $this->config->get('news_config_gallerysub');
		if(isset($includesub) && ($includesub == 1)){
			$subalbums = implode(',',$this->getAlbumsbyParent($album_id));
			$query .= " AND gab.news_gallery_album_id IN (".$subalbums.") ";
		}else{
			$query .= " AND gab.news_gallery_album_id ='".(int)$album_id."'";
		}
		$query.= " GROUP BY ga.news_gallery_id";
		$sort_data = array(
				'ga.news_gallery_titles',
				'ga.news_gallery_added',
				'ga.news_gallery_modified'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'ga.news_gallery_titles') {
					$query .= " ORDER BY LCASE(" . $data['sort'] . ")";
				}else{
					$query .= " ORDER BY " . $data['sort'];
				}
			} else {
				$query .= " ORDER BY ga.news_gallery_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$query .= " DESC";
			} else {
				$query .= " ASC";
			}
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		
		$result = $this->db->query($query);
		return $result->rows;
	}
	public function updateVote($image_id){
		$this->db->query("UPDATE " . DB_PREFIX . "news_gallery SET news_gallery_vote = (news_gallery_vote + 1) WHERE news_gallery_id = '" . (int)$image_id . "'");
	}	
	public function updateView($image_id){
		$this->db->query("UPDATE " . DB_PREFIX . "news_gallery SET news_gallery_viewed = (news_gallery_viewed + 1) WHERE news_gallery_id = '" . (int)$image_id . "'");
	}
}
?>