<?php
class ControllerModuleNewsArticle extends Controller {
	protected function index($setting) {
		$this->language->load('module/newsarticle');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('news/article');
		
		$this->load->model('tool/image');
		
		$this->data['news_articles'] = array();
		$this->data['heading_title'] = $this->language->get('heading_title');	
		$this->data['text_error']= $this->language->get('text_error');
   		$order = '';
		switch($setting['art_order'])
		{
			case 0:
			$order = 'nd.news_titles';
			break;
			case 1:
			$order = 'n.news_date_added';
			break;
			case 2:  
			$order = 'n.news_date_modified';
			break;
			case 3:
			$order = 'n.news_vote';
			break;
			case 4:
			$order = 'n.news_viewed';
			break;
			default:
			$order = 'n.news_date_added';
			break;
			
		}

		if(!isset($setting['newsmodulecategory'])) {
			$catid = NULL;
		} elseif($setting['newsmodulecategory'][0] == 'auto' && isset($this->request->get['catid'])){
			$this->load->model('news/category');

			$parts = explode('_', (string)$this->request->get['catid']);
			foreach ($parts as $catid_id) {
				$catid = $catid_id;
			}
			$catname = $this->model_news_category->getNewsCategory($catid);
			$this->data['heading_title'] = $catname['news_category_name'];
		} elseif ($setting['newsmodulecategory'][0] != 'auto') {
			$this->load->model('news/category');
			$fills = $setting['newsmodulecategory'];
			sort($fills);
			$catid = $fills[0];
			$catname = $this->model_news_category->getNewsCategory($catid);
			$this->data['heading_title'] = $catname['news_category_name'];
		} else {
			$catid = NULL;
		}

		$data = array(
			'filter_category_id' => $catid ,
			'filter_sub_category'=> ($this->config->get('news_config_subcategory')== 0) ? false : true,
			'sort'  => $order,
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_news_article->getNewsArticleCategory($data);

		$this->data['articles'] = array();
		$this->data['articles_all'] = $this->url->link('news/category', 'catid=' . $catid);
		foreach ($results as $result) {

			if (isset($setting['show_img'])) {
				$image = $this->model_tool_image->resize($result['news_image'], $setting['image_width'], $setting['image_height']);
			} else{
				$image = false;
			}

			if (isset($setting['desc_show'])) {
                $cut_descr_symbols = (int)$setting['desc_limit'];
                $description = strip_tags(html_entity_decode($result['news_description'], ENT_QUOTES, 'UTF-8'));
                if( mb_strlen($description, 'UTF-8') > $cut_descr_symbols )
                {
	                $description = mb_substr($description, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
                }
				//$description = substr(strip_tags(html_entity_decode($result['news_description'], ENT_QUOTES, 'UTF-8')), 0, (int)$setting['desc_limit']) . '..';
			} else{
				$description = '';
			}

			if(isset($setting['more_show'])){
				$readmore = sprintf($this->language->get('text_readmore'));
			}else{
				$readmore = false;
			}

			if(isset($setting['date_show'])){
				$dateshow = date($this->config->get('news_config_datetime'), strtotime($result['news_date_added']));
			}else{
				$dateshow = false;
			}

			if(isset($setting['comment_show'])){
				$comment_show = sprintf($this->language->get('text_comment'),(int)$result['news_total_comment']);
			}else{
				$comment_show = false;
			}

			if(isset($setting['vote_show'])){
				$showvote = sprintf($this->language->get('text_vote'),$result['news_vote']);
			}else{
				$showvote = false;
			}

			if(isset($setting['view_show'])){
				$view_show = sprintf($this->language->get('text_viewed'),$result['news_viewed']);
			}else{
				$view_show = false;
			}

            if ($result['news_category_parent_id'] && $result['news_category_parent_id'] > 0) {
                $catid = $result['news_category_parent_id'] . '_' . $result['news_category_id'];
            } else {
                $catid = $result['news_category_id'];
            }

			$this->data['articles'][] = array(
				'news_id'       => $result['news_id'],
				'thumb'         => $image,
				'title'         => $result['news_titles'],
				'description'   => $description,
				'create_date'   => $dateshow,
				'vote'          => $showvote,
				'numvote'       => (int)$result['news_vote'],
				'comment'       => $comment_show,
				'comment_href'  => $this->url->link('news/article', 'news_id=' . $result['news_id']),
				'readmore'      => $readmore,
				'views_show'    => $view_show,
				'category'      => $result['news_category_name'],
				'category_href' => $this->url->link('news/category', 'catid=' . $catid),
				'href'          => $this->url->link('news/article', 'catid=' . $catid . '&news_id=' . $result['news_id'])
			);
		}

		if(!isset($setting['newsmodulecategory2'])) {
			$catid = NULL;
		} elseif($setting['newsmodulecategory2'][0] == 'auto' && isset($this->request->get['catid'])){
			$this->load->model('news/category');

			$parts = explode('_', (string)$this->request->get['catid']);
			foreach ($parts as $catid_id) {
				$catid = $catid_id;
			}
			$catname = $this->model_news_category->getNewsCategory($catid);
			$this->data['heading_title'] = $catname['news_category_name'];
		} elseif ($setting['newsmodulecategory2'][0] != 'auto') {
			$this->load->model('news/category');
			$fills = $setting['newsmodulecategory2'];
			sort($fills);
			$catid = $fills[0];
			$catname = $this->model_news_category->getNewsCategory($catid);
			$this->data['heading_title'] = $catname['news_category_name'];
		} else {
			$catid = NULL;
		}

		$data = array(
			'filter_category_id' => $catid ,
			'filter_sub_category'=> ($this->config->get('news_config_subcategory')== 0) ? false : true,
			'sort'  => $order,
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_news_article->getNewsArticleCategory($data);

		$this->data['articles2'] = array();
		$this->data['articles_all2'] = $this->url->link('news/category', 'catid=' . $catid);
		foreach ($results as $result) {

			if (isset($setting['show_img'])) {
				$image = $this->model_tool_image->resize($result['news_image'], $setting['image_width'], $setting['image_height']);
			} else{
				$image = false;
			}

			if (isset($setting['desc_show'])) {
                $cut_descr_symbols = (int)$setting['desc_limit'];
                $description = strip_tags(html_entity_decode($result['news_description'], ENT_QUOTES, 'UTF-8'));
                if( mb_strlen($description, 'UTF-8') > $cut_descr_symbols )
                {
	                $description = mb_substr($description, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
                }
				//$description = substr(strip_tags(html_entity_decode($result['news_description'], ENT_QUOTES, 'UTF-8')), 0, (int)$setting['desc_limit']) . '..';
			} else{
				$description = '';
			}

			if(isset($setting['more_show'])){
				$readmore = sprintf($this->language->get('text_readmore'));
			}else{
				$readmore = false;
			}

			if(isset($setting['date_show'])){
				$dateshow = date($this->config->get('news_config_datetime'), strtotime($result['news_date_added']));
			}else{
				$dateshow = false;
			}

			if(isset($setting['comment_show'])){
				$comment_show = sprintf($this->language->get('text_comment'),(int)$result['news_total_comment']);
			}else{
				$comment_show = false;
			}

			if(isset($setting['vote_show'])){
				$showvote = sprintf($this->language->get('text_vote'),$result['news_vote']);
			}else{
				$showvote = false;
			}

			if(isset($setting['view_show'])){
				$view_show = sprintf($this->language->get('text_viewed'),$result['news_viewed']);
			}else{
				$view_show = false;
			}

            if ($result['news_category_parent_id'] && $result['news_category_parent_id'] > 0) {
                $catid = $result['news_category_parent_id'] . '_' . $result['news_category_id'];
            } else {
                $catid = $result['news_category_id'];
            }

			$this->data['articles2'][] = array(
				'news_id'       => $result['news_id'],
				'thumb'         => $image,
				'title'         => $result['news_titles'],
				'description'   => $description,
				'create_date'   => $dateshow,
				'vote'          => $showvote,
				'numvote'       => (int)$result['news_vote'],
				'comment'       => $comment_show,
				'comment_href'  => $this->url->link('news/article', 'news_id=' . $result['news_id']),
				'readmore'      => $readmore,
				'views_show'    => $view_show,
				'category'      => $result['news_category_name'],
				'category_href' => $this->url->link('news/category', 'catid=' . $catid),
				'href'          => $this->url->link('news/article', 'catid=' . $catid . '&news_id=' . $result['news_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newsarticle.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/newsarticle.tpl';
		} else {
			$this->template = 'default/template/module/newsarticle.tpl';
		}

		$this->render();
	}
}
?>