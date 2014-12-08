<?php
class ControllerNewsArticle extends Controller {  
	public function index() {
		$this->language->load('news/article');
		
		$this->load->model('news/category');
		
		$this->load->model('news/article');
						
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);

		if (isset($this->request->get['catid'])) {
			$catid = '';
			$parts = explode('_', (string)$this->request->get['catid']);	
			foreach ($parts as $catid_id) {
				if (!$catid) {
					$catid = $catid_id;
				} else {
					$catid .= '_' . $catid_id;
				}
				
				$news_category_info = $this->model_news_category->getNewsCategory($catid_id);

				if ($news_category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $news_category_info['news_category_name'],
						'href'      => $this->url->link('news/category', 'catid=' . $catid),
        				'separator' => $this->language->get('text_separator')
					);
				}
			}
		}

		$url = '';
		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			$this->data['breadcrumbs'][] = array(
				'text'      => $news_article_info['news_titles'],
				'href'      => $this->url->link('news/article', $catidi. '&filter_tag=' . $this->request->get['filter_tag']),
				'separator' => $this->language->get('text_separator')
			);	
		}

		if (isset($this->request->get['news_id'])) {
			$news_id = $this->request->get['news_id'];
		} else {
			$news_id = 0;
		}
		//get category info
		$news_article_info = $this->model_news_article->getNewsArticle($news_id);
		$this->data['news_article'] = $news_article_info;
		if ($news_article_info) {
			$url = '';
			if (isset($this->request->get['catid'])) {
				$url .= '&catid=' . $this->request->get['catid'];
			}else{
				$catids = $this->model_news_article->getCatidbyArticleid($news_id);
				if(!empty($catids)){
					$url.= '&catid='.$catids['news_category_id'];
				}
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			
			//$this->data['breadcrumbs'][] = array(
			//	'text'      => $news_article_info['news_titles'],
			//	'href'      => $this->url->link('news/article', $url. '&news_id=' . $this->request->get['news_id']),
			//	'separator' => $this->language->get('text_separator')
			//);	
			
			$this->model_news_article->updateViewed($this->request->get['news_id']);
	
	  		$this->document->setTitle($news_article_info['news_titles']);
			$this->document->setDescription($news_article_info['news_meta_description']);
			$this->document->setKeywords($news_article_info['news_meta_keyword']);
			$this->document->addLink($this->url->link('news/article', 'news_id=' . $this->request->get['news_id']), 'canonical');
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['heading_title'] = $news_article_info['news_titles'];
			$this->data['text_related'] = $this->language->get('text_related');
			$this->data['text_relatedproduct'] = $this->language->get('text_relatedproduct');
			$this->data['text_empty'] = $this->language->get('text_empty');			
			$this->data['text_writecomment'] = $this->language->get('text_writecomment');
			$this->data['text_name'] = $this->language->get('text_name');
			$this->data['text_title'] = $this->language->get('text_title');
			$this->data['text_text'] = $this->language->get('text_text');
			$this->data['text_email'] = $this->language->get('text_email');
			$this->data['text_link'] = $this->language->get('text_link');
			$this->data['text_captcha'] = $this->language->get('text_captcha');
			$this->data['text_addcomment'] = $this->language->get('text_addcomment');
			$this->data['text_tags'] = $this->language->get('text_tags');
			$this->data['news_id'] = $news_article_info['news_id'];
			$this->data['titles'] = $news_article_info['news_titles'];
			$this->data['description'] = html_entity_decode($news_article_info['news_description'], ENT_QUOTES, 'UTF-8');
			$this->data['date'] = date($this->config->get('news_config_datetime'), strtotime($news_article_info['news_date_added']));
			$this->data['vote'] = sprintf($this->language->get('text_vote'),$news_article_info['news_vote']);
			$this->data['view'] = sprintf($this->language->get('text_viewed'),$news_article_info['news_viewed']);
			$this->data	['numvote'] = (int)$news_article_info['news_vote'];
			
			//get for display news
			
			$this->data['showdate'] = $news_article_info['news_showdate'];
			$this->data['showvote'] = $news_article_info['news_showvote'];
			$this->data['showview'] = $news_article_info['news_showview'];
			$this->data['related'] =  $news_article_info['news_showrelated'];
			$this->data['product'] =  $news_article_info['news_showproduct'];


            if ($news_article_info['news_category_parent_id'] && $news_article_info['news_category_parent_id'] > 0) {
                $catid = $news_article_info['news_category_parent_id'] . '_' . $news_article_info['news_category_id'];
            } else {
                $catid = $news_article_info['news_category_id'];
            }

    		$parent_info = $this->model_news_category->getNewsCategory($news_article_info['news_category_parent_id']);

    		if ($parent_info) {
                $this->data['parent']        = $this->language->get('text_cat' . $parent_info['news_category_id']);
                $this->data['parent_href']   = $this->url->link('video/category', 'catid=' . $parent_info['news_category_id']);
    		} else {
                $this->data['parent']        = $this->language->get('text_cat0');
                $this->data['parent_href']   = $this->url->link('news/category');
            }

    		$this->data['category']      = $news_article_info['news_category_name'];
	    	$this->data['category_href'] = $this->url->link('news/category', 'catid=' . $catid);

			$comment_total = $this->model_news_article->getTotalComment($this->request->get['news_id']);
            $this->data['comment_total'] = $comment_total;

			$this->data['articles'] = array();

			$results = $this->model_news_article->getArticleRelated($this->request->get['news_id']);
			
			foreach($results as $result){
				$this->data['articles'][] = array(
					'name' => $result['news_titles'],
					'href' => $this->url->link('news/article', 'news_id=' . $result['news_id'])
				);
			}
			//get related product
			$this->load->model('tool/image');
			$this->data['products'] = array();
			
			$results = $this->model_news_article->getArticleRelatedproduct($this->request->get['news_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
				}
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
							
				$this->data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}	
			
			//================//
			
			$this->data['tags'] = array();
					
			$results = $this->model_news_article->getNewsArticleTags($this->request->get['news_id']);
			
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag'  => $result['news_tag'],
					'href' => $this->url->link('news/category', $url. '&filter_tag=' . $result['news_tag'])
				);
			}
			$allow_comment = $this->model_news_article->getAllowcomment($this->request->get['news_id']);
			$this->data['allow_comment'] = $allow_comment['news_comment'];
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/article.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/article.tpl';
			} else {
				$this->template = 'default/template/news/article.tpl';
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
			
			if (isset($this->request->get['catid'])) {
				$url .= '&catid=' . $this->request->get['catid'];
			}
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('news/category', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');
			$this->data['continue'] = $this->url->link('common/home');
			$this->data['text_error'] = $this->language->get('text_error');
			$this->data['button_continue'] = $this->language->get('button_continue');

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
	
	public function vote()
	{
		$this->language->load('news/article');
		$this->load->model('news/article');
		$json = array();
		if(!(int)$this->request->post['stars'] && (int)$this->request->post['stars'] > 5)
		{
			$json['error'] = $this->language->get('text_voteerror');
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$this->model_news_article->updateVote($this->request->get['news_id']);
			
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
	public function comment() {
		$this->load->model('news/article');
		$this->language->load('news/comment');
		$allow_comment = $this->model_news_article->getAllowcomment($this->request->get['news_id']);
		
		$total_comment = $this->model_news_article->getTotalComment($this->request->get['news_id']);	
		$this->data['total_comment'] = sprintf($this->language->get('text_comment'),$total_comment);
		
		if($allow_comment)
		{
			$this->language->load('news/comment');
			$this->load->model('news/comment');
	
			$this->data['text_nocomment'] = $this->language->get('text_nocomment');	
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
			$this->data['comments'] = array();
			
			$comment_total = $this->model_news_article->getTotalComment($this->request->get['news_id']);

			$data = array(
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$results = $this->model_news_comment->getCommentbyNewsid($this->request->get['news_id'],$data);
	      		
			foreach ($results as $result) {
	        	$this->data['comments'][] = array(
	        		'news_comment_author'     => $result['news_comment_author'],
					'news_comment_text'       => strip_tags($result['news_comment_text']),
					'news_comment_email'     => $result['news_comment_email'],
					'image'                  => $this->model_news_comment->getGravatar($result['news_comment_email']),
	        		'news_comment_date_added' => date($this->config->get('news_config_datetime'), strtotime($result['news_comment_date_added']))
	        	);
	      	}

			$pagination = new Pagination();
			$pagination->total          = $comment_total;
  			$pagination->page           = $page;
			$pagination->limit          = $limit;
			$pagination->text           = ''; //$this->language->get('text_total_page');
        	$pagination->style_links    = '';
            $pagination->style_results  = '';
            $pagination->text_first     = $this->language->get('text_first');
            $pagination->text_last      = $this->language->get('text_last');
            $pagination->text_next      = $this->language->get('text_next');
            $pagination->text_prev      = $this->language->get('text_prev');

			$pagination->url = $this->url->link('news/article/comment', 'news_id=' . $this->request->get['news_id'] . '&page={page}');

			$this->data['pagination'] = $pagination->render();

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/comment.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/comment.tpl';
			} else {
				$this->template = 'default/template/news/comment.tpl';
			}
			
			$this->response->setOutput($this->render());
    	
		}
		}

	public function addcomment()
	{
		$this->language->load('news/comment');
		$this->load->model('news/comment');
		$json = array();
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
			$json['error'] = $this->language->get('error_name');
		}
		
		if ((strlen(utf8_decode($this->request->post['text'])) < 5) || (strlen(utf8_decode($this->request->post['text'])) > 1000)) {
			$json['error'] = $this->language->get('error_text');
		}

		if($this->request->post['title'] != 'undefined')
		{
			$title = $this->request->post['title'];
			if((strlen(utf8_decode($title)) < 3) || (strlen(utf8_decode($title))> 200))
			{
				$json['error'] = $this->language->get('error_title');
			}
		} else {
            $title = '';
        }
		
		//$email = $this->request->post['email'];
		//if ((strlen(utf8_decode($email)) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
      	//	$json['error'] = $this->language->get('error_email');
		//}
        $email = 'noemail@mail.ru';
		
		//if($this->request->post['website'] != 'undefined')
		//{
		//	$website = $this->request->post['website'];
		//	if ((strlen(utf8_decode($website)) > 96) || !preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $website)) {
      	//		$json['error'] = $this->language->get('error_website');
		//	}
		//}else{
		$website = '';
		//}
		
		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
			$json['error'] = $this->language->get('error_captcha');
		}
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			
			$data = array(
				'author' => $this->request->post['name'],
				'text'   => $this->request->post['text'],
				'title'  => $title,
				'email'  => $email,
				'link'   => $website,
				'status' => (int)$this->config->get('news_config_comment_autopublish')
			);
			
			$result = $this->model_news_comment->Addcomment($this->request->get['news_id'], $data);
			if($this->config->get('news_config_comment_autopublish'))
			{
				$json['publish'] = true;
				$json['name'] = $result['news_comment_author'];
				$json['date'] = date($this->config->get('news_config_datetime'), strtotime($result['news_comment_date_added']));
				$json['text'] = $result['news_comment_text'];
				$json['email']  = $result['news_comment_email'];
				$json['image'] = $this->model_news_comment->getGravatar($result['news_comment_email']);
			}
			else
			{
				$json['publish'] = false;
				$json['text_thank'] = $this->language->get('text_public');
			}
			// email admin 
			
			if($this->config->get('news_config_comment_automail')){
				$this->load->model('news/article');
				$article_info = $this->model_news_article->getNewsArticle($this->request->get['news_id']);
				$message  = '<html dir="ltr" lang="en">' . "\n";
				$message .= '<head>' . "\n";
				$message .= '<title>' . (!$title) ? $this->language->get('email_title').$article_info['news_titles']  : $title . '</title>' . "\n";
				$message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
				$message .= '</head>' . "\n";
				$message .= '<body>' ."<br />". html_entity_decode($this->request->post['text'], ENT_QUOTES, 'UTF-8') . "<br />".$this->language->get('email_view')."<a href=".$this->url->link('news/article', 'news_id=' . $this->request->get['news_id']).'#comment'.">".$this->url->link('news/article', 'news_id=' . $this->request->get['news_id']).'#comment'."</a>"."<br />".'</body>' . "\n";
				$message .= '</html>' . "\n";
				
					$mail = new Mail();	
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->hostname = $this->config->get('config_smtp_host');
					$mail->username = $this->config->get('config_smtp_username');
					$mail->password = $this->config->get('config_smtp_password');
					$mail->port = $this->config->get('config_smtp_port');
					$mail->timeout = $this->config->get('config_smtp_timeout');				
					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($email);
					$mail->setSender($this->request->post['name']);
					$mail->setSubject($this->config->get('config_name')." : ".$article_info['news_titles']);	
			
					$mail->setHtml($message);
					$mail->send();
			}
		}
		
	$this->response->setOutput(json_encode($json));
		
	}
}
?>