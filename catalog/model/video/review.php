<?php
class ModelVideoReview extends Model {		
	public function addReview($video_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ocart_video_review SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', video_id = '" . (int)$video_id . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', date_added = NOW()");
	}
		
	public function getReviewsByVideoId($video_id, $start = 0, $limit = 20) {
		$query = $this->db->query("SELECT r.review_id, r.author, r.rating, r.text, v.video_id, v.name, v.image, r.date_added FROM " . DB_PREFIX . "ocart_video_review r LEFT JOIN " . DB_PREFIX . "ocart_video v ON (r.video_id = v.video_id) WHERE v.video_id = '" . (int)$video_id . "' AND v.status = '1' AND r.status = '1' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	
	public function getAverageRating($product_id) {
		$query = $this->db->query("SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review WHERE status = '1' AND product_id = '" . (int)$product_id . "' GROUP BY product_id");
		
		if (isset($query->row['total'])) {
			return (int)$query->row['total'];
		} else {
			return 0;
		}
	}	
	
	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ocart_video_review r LEFT JOIN " . DB_PREFIX . "ocart_video v ON (r.video_id = v.video_id) WHERE v.date_available <= NOW() AND v.status = '1' AND r.status = '1'");
		
		return $query->row['total'];
	}

	public function getTotalReviewsByVideoId($video_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ocart_video_review r LEFT JOIN " . DB_PREFIX . "ocart_video v ON (r.video_id = v.video_id) WHERE v.video_id = '" . (int)$video_id . "' AND v.status = '1' AND r.status = '1'");
		
		return $query->row['total'];
	}
}
?>