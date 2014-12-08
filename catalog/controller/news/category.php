<?php
class ControllerNewsCategory extends Controller {  
	public function index() { 
		$this->language->load('news/category');
		
		$this->load->model('news/category');
		
		$this->load->model('news/article');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		}
		else
		{
			$filter_tag = '';
		}
		//get page
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
		//get limit
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('news_config_item');
		}
		
								
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

			$news_category_id = array_pop($parts);
		} else {
			$news_category_id = 0;
		}
		//get category info
		$news_category_info = $this->model_news_category->getNewsCategory($news_category_id);
	
		if ($news_category_info) {
	  		$this->document->setTitle($news_category_info['news_category_name']);
			$this->document->setDescription($news_category_info['news_category_meta_description']);
			$this->document->setKeywords($news_category_info['news_category_meta_keyword']);
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['heading_title'] = $news_category_info['news_category_name'];
			$this->data['text_empty'] = $this->language->get('text_empty');			
			$this->data['text_nocomment'] = $this->language->get('text_nocomment');	
			$this->data['text_readmore'] = $this->language->get('text_readmore');
			$this->data['text_refine'] = $this->language->get('text_refine');
			if ($news_category_info['news_category_image']) {
					$this->data['cat_thumb'] = $this->model_tool_image->resize($news_category_info['news_category_image'], $this->config->get('news_config_catthumb_w'), $this->config->get('news_config_catthumb_h'));
				} else {
					$this->data['cat_thumb'] = '';
				}	
				
			$this->data['cat_desc'] = html_entity_decode($news_category_info['news_category_description'], ENT_QUOTES, 'UTF-8');
			$url = '';
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			//Refine Search
			
			$this->data['categories'] = array();
			
			$results = $this->model_news_category->getNewsCategories($news_category_id);
			
			foreach ($results as $result) {
				$article_total = $this->model_news_article->getNewsTotalArticle(array('filter_category_id' => $result['news_category_id']));
				
				$this->data['categories'][] = array(
					'name'  => $result['news_category_name'] . ' (' . $article_total . ')',
					'href'  => $this->url->link('news/category', 'catid=' . $this->request->get['catid'] . '_' . $result['news_category_id'] . $url)
				);
			}					
			//get article
			
			$this->data['news_articles'] = array();
			
			$data = array(
				'filter_tag' => $filter_tag,
				'filter_category_id' => $news_category_id,
				'filter_sub_category'=> ($this->config->get('news_config_subcategory')== 0) ? false : true, 
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit,
				'sort'               => 'n.news_date_added',
				'order'              => 'DESC'
			);
			//get total article
			$article_total = $this->model_news_article->getNewsTotalArticle($data); 
			//load article by category
			$results = $this->model_news_article->getNewsArticleCategory($data);
			if($results)
			{
				
				foreach ($results as $result) {
				if ($result['news_image']) {
					$image = $this->model_tool_image->resize($result['news_image'], $this->config->get('news_config_catthumb_w'), $this->config->get('news_config_catthumb_h'));
				} else {
					$image = false;
				}

                $news_category_parent_id = $result['news_category_parent_id'];
                $news_category_id        = $result['news_category_id'];

                if ($result['news_category_parent_id'] && $result['news_category_parent_id'] > 0) {
                    $catid = $result['news_category_parent_id'] . '_' . $result['news_category_id'];
                } else {
                    $catid = $result['news_category_id'];
                }

                //--- split description ---
    			$html  = html_entity_decode($result['news_description'], ENT_QUOTES, 'UTF-8');
                $parts = mb_split('<!--more-->', $html);

                if (count($parts) > 0) {
        			$begin_description = mb_ereg_replace('<[img]/?[a-z][a-z0-9]*[^<>]*>', '', $parts[0]);        
        			$end_description   = false;
                } else {
        			$begin_description = false;
        			$end_description   = false;
                }

                if (count($parts) > 1) {
        			$end_description   = $parts[1];
                }
                //--- split description ---

				$this->data['news_articles'][] = array(
					'news_id'       => $result['news_id'],
					'thumb'         => $image,
					'title'         => $result['news_titles'],
                    'description'       => $html,
                    'begin_description' => $begin_description,
                    'end_description'   => $end_description,
					'create_date'   => date($this->config->get('news_config_datetime'), strtotime($result['news_date_added'])),
					'allow_comment' => (int)$result['news_comment'],
					'vote'          => sprintf($this->language->get('text_vote'),$result['news_vote']).' / '.sprintf($this->language->get('text_viewed'),$result['news_viewed']),
					'numvote'       => (int)$result['news_vote'],
					'comment'       => sprintf($this->language->get('text_comment'),(int)$result['news_total_comment']),
					'comment_href'  => $this->url->link('news/article', 'catid=' . $this->request->get['catid'] . '&news_id=' . $result['news_id']),
    				'category'      => $result['news_category_name'],
	    			'category_href' => $this->url->link('news/category', 'catid=' . $catid),
					'href'          => $this->url->link('news/article', 'catid=' . $catid . '&news_id=' . $result['news_id'])
				);
			}
			}
			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('news/article', 'catid=' . $this->request->get['catid'] . $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);
						
			$pagination = new Pagination();
			$pagination->total          = (int)$article_total;
  			$pagination->page           = $page;
			$pagination->limit          = $limit;
			$pagination->text           = ''; //$this->language->get('text_total_page');
        	$pagination->style_links    = '';
            $pagination->style_results  = '';
            $pagination->text_first     = $this->language->get('text_first');
            $pagination->text_last      = $this->language->get('text_last');
            $pagination->text_next      = $this->language->get('text_next');
            $pagination->text_prev      = $this->language->get('text_prev');

			$pagination->url = $this->url->link('news/category', 'catid=' . $this->request->get['catid'] . $url . '&page={page}');

            $this->data['total_pages'] = sprintf($this->language->get('text_total_page'),(int)$pagination->pages);
			$this->data['pagination']  = $pagination->render();

			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/category.tpl';
			} else {
				$this->template = 'default/template/news/category.tpl';
			}
			$this->children = array(
				'common/column_left',
				'common/column_right',
    			'common/column_center',
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
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
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
				'common/column_center',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
			$this->response->setOutput($this->render());
		}
  	}
}
?>