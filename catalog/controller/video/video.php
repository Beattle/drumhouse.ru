<?php
class ControllerVideovideo extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/ocart_video_gallery.css');
		
		$this->language->load('video/video');
	
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
						
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}	
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('product/search', $url),
				'separator' => $this->language->get('text_separator')
			);	
		}
		
		if (isset($this->request->get['video_id'])) {
			$video_id = $this->request->get['video_id'];
		} else {
			$video_id = 0;
		}
		
		$this->load->model('video/video');
		
		$video_info = $this->model_video_video->getVideo($video_id);
		
		$this->data['video_info'] = $video_info;
		
		if ($video_info) {
			$url = '';

			if (isset($this->request->get['vcatid'])) {
				$url .= '&vcatid=' . $this->request->get['vcatid'];
			}
			
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}			

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}	
						
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
			
			$this->document->setTitle($video_info['name']);
			$this->document->setDescription($video_info['description']);
			$this->document->addLink($this->url->link('video/video', 'video_id=' . $this->request->get['video_id']), 'canonical');
			
			$this->data['heading_title'] = $video_info['name'];
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_gallery'),
				'href'      => $this->url->link('video/category'),
				'separator' =>  $this->language->get('text_separator')
   			);
			
			//$this->data['breadcrumbs'][] = array(
			//	'text'      => $video_info['name'],
			//	'href'      => $this->url->link('video/video', 'video_id=' . $video_info['video_id']),
			//	'separator' => $this->language->get('text_separator')
			//);
			
			
			$this->data['text_select'] = $this->language->get('text_select');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_model'] = $this->language->get('text_model');
			$this->data['text_reward'] = $this->language->get('text_reward');
			$this->data['text_points'] = $this->language->get('text_points');	
			$this->data['text_discount'] = $this->language->get('text_discount');
			$this->data['text_stock'] = $this->language->get('text_stock');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_discount'] = $this->language->get('text_discount');
			$this->data['text_option'] = $this->language->get('text_option');
			$this->data['text_qty'] = $this->language->get('text_qty');
			$this->data['text_or'] = $this->language->get('text_or');
			$this->data['text_write'] = $this->language->get('text_write');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['text_share'] = $this->language->get('text_share');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_tags'] = $this->language->get('text_tags');
			
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_review'] = $this->language->get('entry_review');
			$this->data['entry_rating'] = $this->language->get('entry_rating');
			$this->data['entry_good'] = $this->language->get('entry_good');
			$this->data['entry_bad'] = $this->language->get('entry_bad');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');
			
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');			
			$this->data['button_upload'] = $this->language->get('button_upload');
			$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->load->model('video/review');
			
			$this->data['tab_description'] = $this->language->get('tab_description');
			$this->data['tab_review'] = sprintf($this->language->get('tab_review'), $this->model_video_review->getTotalReviewsByVideoId($this->request->get['video_id']));
			$this->data['tab_related'] = $this->language->get('tab_related');
			
			$this->data['video_id'] = $this->request->get['video_id'];
			$this->data['description'] = html_entity_decode($video_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['code'] = $video_info['link'];
			//$this->data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$video_info['reviews']);
            $this->data['comment_total'] = (int)$video_info['reviews'];


            $this->data['video_href']    = $this->url->link('video/category');
            $this->data['category_href'] = $this->url->link('video/category', 'vcatid=' . $video_info['vcat_id']);
            $this->data['category']      = $video_info['vcat_name'];

			$this->load->model('tool/image');

			$this->data['videos'] = array();

			$results = $this->model_video_video->getVideoRelated($this->request->get['video_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 176 , 100 );
				} else {
					$image = false;
				}
								
				$this->data['videos'][] = array(
					'video_id'   => $result['video_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'href'    	 => $this->url->link('video/video', 'vcatid=' . $video_info['vcat_id'] . '&video_id=' . $result['video_id']),
				);
			}	
			
			/*
			$this->data['tags'] = array();
					
			$results = $this->model_catalog_product->getProductTags($this->request->get['product_id']);
			
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag'  => $result['tag'],
					'href' => $this->url->link('product/search', 'filter_tag=' . $result['tag'])
				);
			}
			*/
			
			//$this->model_catalog_product->updateViewed($this->request->get['product_id']);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/video/video.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/video/video.tpl';
			} else {
				$this->template = 'default/template/video/video.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
			$this->response->setOutput($this->render());
		} else {
			$url = '';
			
			if (isset($this->request->get['vcatid'])) {
				$url .= '&vcatid=' . $this->request->get['vcatid'];
			}

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}	
							
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
					
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
								
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('video/video', $url . '&video_id=' . $video_id),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('video/category');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
			$this->response->setOutput($this->render());
    	}
  	}
	
	public function review() {
    	$this->language->load('video/video');
		
		$this->load->model('video/review');

		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		//get limit
		if (isset($this->request->get['limit'])) {
		    $limit = $this->request->get['limit'];
		} else {
		    $limit = $this->config->get('news_config_commentperpage');
		}
		$this->data['reviews'] = array();
		
		$review_total = $this->model_video_review->getTotalReviewsByVideoId($this->request->get['video_id']);
		$this->data['total_comment'] = sprintf($this->language->get('text_reviews'), $review_total);

		$results = $this->model_video_review->getReviewsByVideoId($this->request->get['video_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$this->data['reviews'][] = array(
        		'author'     => $result['author'],
				'text'       => strip_tags($result['text']),
				'rating'     => (int)$result['rating'],
        		'reviews'    => sprintf($this->language->get('text_reviews'), (int)$review_total),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}

        $pagination = new Pagination();
        $pagination->total          = $review_total;
        $pagination->page           = $page;
        $pagination->limit          = $limit;
        $pagination->text           = ''; //$this->language->get('text_total_page');
        $pagination->style_links    = '';
        $pagination->style_results  = '';
        $pagination->text_first     = $this->language->get('text_first');
        $pagination->text_last      = $this->language->get('text_last');
        $pagination->text_next      = $this->language->get('text_next');
        $pagination->text_prev      = $this->language->get('text_prev');

		$pagination->url = $this->url->link('video/video/review', 'video_id=' . $this->request->get['video_id'] . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/video/review.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/video/review.tpl';
		} else {
			$this->template = 'default/template/video/review.tpl';
		}
		
		$this->response->setOutput($this->render());
	}
	
	
	public function write() {
		$this->language->load('video/video');
		
		$this->load->model('video/review');
		
		$json = array();
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
			$json['error'] = $this->language->get('error_name');
		}

		if ((strlen(utf8_decode($this->request->post['text'])) < 5) || (strlen(utf8_decode($this->request->post['text'])) > 1000)) {
			$json['error'] = $this->language->get('error_text');
		}

		//if (!$this->request->post['rating']) {
		//	$json['error'] = $this->language->get('error_rating');
		//}

		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
			$json['error'] = $this->language->get('error_captcha');
		}
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$this->model_video_review->addReview($this->request->get['video_id'], $this->request->post);
			
			$json['success'] = $this->language->get('text_success');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
	public function upload() {
		$this->language->load('product/product');
		
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			
			if ((strlen($filename) < 3) || (strlen($filename) > 128)) {
        		$json['error'] = $this->language->get('error_filename');
	  		}	  	
			
			$allowed = array();
			
			$filetypes = explode(',', $this->config->get('config_upload_allowed'));
			
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}	
						
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$file = basename($filename) . '.' . md5(rand());
				
				// Hide the uploaded file name sop people can not link to it directly.
				$this->load->library('encryption');
				
				$encryption = new Encryption($this->config->get('config_encryption'));
				
				$json['file'] = $encryption->encrypt($file);
				
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
			}
						
			$json['success'] = $this->language->get('text_upload');
		}	
		
		$this->response->setOutput(json_encode($json));		
	}
}
?>