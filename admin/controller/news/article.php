<?php 
class ControllerNewsArticle extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/article');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/article');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_article->addNewsArticle($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/article');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_article->editNewsarticle($this->request->get['news_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/article');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_article->deleteNewsArticle($news_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/article', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('news/article/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('news/article/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['news_articles'] = array();
		$this->load->model('tool/image');
		
		//Pagination
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$data = array(
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$results = $this->model_news_article->getNewsArticles($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/article/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'], 'SSL')
			);
			if ($result['news_image'] && file_exists(DIR_IMAGE . $result['news_image'])) {
				$image = $this->model_tool_image->resize($result['news_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}		
			$this->data['news_articles'][] = array(
				'news_id' => $result['news_id'],
				'news_titles'  => $result['news_titles'],
				'news_sort_order'  => $result['news_sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'news_image' => $image,
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_image'] = $this->language->get('comlumn_image');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		
		$article_total = $this->model_news_article->getTotalArtilce();
		$url = '';
		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'news/news_article_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_top'] = $this->language->get('entry_top');
		$this->data['entry_column'] = $this->language->get('entry_column');		
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_tag'] = $this->language->get('entry_tag');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
	
		$this->data['entry_related']         = $this->language->get('entry_related');
		$this->data['entry_related_product']  = $this->language->get('entry_related_product');
		$this->data['entry_showdate']         = $this->language->get('entry_showdate');
		$this->data['entry_showvote']         = $this->language->get('entry_showvote');
		$this->data['entry_showview']         = $this->language->get('entry_showview');
		$this->data['entry_showrelated']      = $this->language->get('entry_showrelated');
		$this->data['entry_showproduct']      = $this->language->get('entry_showproduct');
	
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		$this->data['tab_related'] = $this->language->get('tab_related');
		$this->data['tab_related_product'] = $this->language->get('tab_related_product');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/article', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('news/article/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/article/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/article', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_article_info = $this->model_news_article->getNewsArticle($this->request->get['news_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($news_article_info)) {
			$this->data['news_description'] = $this->model_news_article->getNewsArticleDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}
		$this->load->model('news/category');

		$this->data['news_categories'] = $this->model_news_category->getNewsCategories(0);;
		if (isset($this->request->post['news_caterory'])) {
					$this->data['news_caterory'] = $this->request->post['news_caterory'];
				} elseif (isset($news_article_info)) {
					$this->data['news_caterory'] = $this->model_news_article->getNewsCategories($this->request->get['news_id']);
				} else {
					$this->data['news_caterory'] = array();
				}		
		
		if (isset($this->request->post['news_id'])) {
			$this->data['news_id'] = $this->request->post['news_id'];
		} elseif (isset($new_article_info)) {
			$this->data['news_id'] = $news_article_info['news_id'];
		} else {
			$this->data['news_id'] = 0;
		}
						
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_store'])) {
			$this->data['news_store'] = $this->request->post['news_store'];
		} elseif (isset($news_article_info)) {
			$this->data['news_store'] = $this->model_news_article->getNewsArticleStores($this->request->get['news_id']);
		} else {
			$this->data['news_store'] = array(0);
		}			
		
		if (isset($this->request->post['news_meta_keyword'])) {
			$this->data['news_meta_keyword'] = $this->request->post['news_meta_keyword'];
		} elseif (isset($news_article_info)) {
			$this->data['news_meta_keyword'] = $news_article_info['news_meta_keyword'];
		} else {
			$this->data['news_meta_keyword'] = '';
		}

		if (isset($this->request->post['news_image'])) {
			$this->data['news_image'] = $this->request->post['news_image'];
		} elseif (isset($news_article_info)) {
			$this->data['news_image'] = $news_article_info['news_image'];
		} else {
			$this->data['news_image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($news_article_info) && $news_article_info['news_image'] && file_exists(DIR_IMAGE . $news_article_info['news_image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_article_info['news_image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		if (isset($this->request->post['news_comment'])) {
			$this->data['news_comment'] = $this->request->post['news_comment'];
		} elseif (isset($news_article_info)) {
			$this->data['news_comment'] = $news_article_info['news_comment'];
		} else {
			$this->data['news_comment'] = 1;
		}
		//top in menu
		
		if (isset($this->request->post['news_top'])) {
			$this->data['news_top'] = $this->request->post['news_top'];
		} elseif (isset($news_article_info)) {
			$this->data['news_top'] = $news_article_info['news_top'];
		} else {
			$this->data['news_top'] = 0;
		}
		//
		if (isset($this->request->post['news_showdate'])) {
			$this->data['news_showdate'] = $this->request->post['news_showdate'];
		} elseif (isset($news_article_info)) {
			$this->data['news_showdate'] = $news_article_info['news_showdate'];
		} else {
			$this->data['news_showdate'] = 1;
		}
		if (isset($this->request->post['news_showvote'])) {
			$this->data['news_showvote'] = $this->request->post['news_showvote'];
		} elseif (isset($news_article_info)) {
			$this->data['news_showvote'] = $news_article_info['news_showvote'];
		} else {
			$this->data['news_showvote'] = 1;
		}
		if (isset($this->request->post['news_showview'])) {
			$this->data['news_showview'] = $this->request->post['news_showview'];
		} elseif (isset($news_article_info)) {
			$this->data['news_showview'] = $news_article_info['news_showview'];
		} else {
			$this->data['news_showview'] = 1;
		}
		if (isset($this->request->post['news_showrelated'])) {
			$this->data['news_showrelated'] = $this->request->post['news_showrelated'];
		} elseif (isset($news_article_info)) {
			$this->data['news_showrelated'] = $news_article_info['news_showrelated'];
		} else {
			$this->data['news_showrelated'] = 1;
		}
		if (isset($this->request->post['news_showproduct'])) {
			$this->data['news_showproduct'] = $this->request->post['news_showproduct'];
		} elseif (isset($news_article_info)) {
			$this->data['news_showproduct'] = $news_article_info['news_showproduct'];
		} else {
			$this->data['news_showproduct'] = 1;
		}
		//
		if (isset($this->request->post['news_tags'])) {
			$this->data['news_tags'] = $this->request->post['news_tags'];
		} elseif (isset($news_article_info)) {
			$this->data['news_tags'] = $this->model_news_article->getNewsTags($this->request->get['news_id']);
		} else {
			$this->data['product_tag'] = array();
		}	
		if (isset($this->request->post['news_sort_order'])) {
			$this->data['news_sort_order'] = $this->request->post['news_sort_order'];
		} elseif (isset($news_article_info)) {
			$this->data['news_sort_order'] = $news_article_info['news_sort_order'];
		} else {
			$this->data['news_sort_order'] = 0;
		}
		
		if (isset($this->request->post['news_status'])) {
			$this->data['news_status'] = $this->request->post['news_status'];
		} elseif (isset($news_article_info)) {
			$this->data['news_status'] = $news_article_info['news_status'];
		} else {
			$this->data['news_status'] = 1;
		}
				
		if (isset($this->request->post['news_layout'])) {
			$this->data['news_layout'] = $this->request->post['news_layout'];
		} elseif (isset($news_article_info)) {
			$this->data['news_layout'] = $this->model_news_article->getNewsArticleLayouts($this->request->get['news_id']);
		} else {
			$this->data['news_layout'] = array();
		}
		//
		if (isset($this->request->post['article_related'])) {
			$articles = $this->request->post['article_related'];
		} elseif (isset($news_article_info)) {		
			$articles = $this->model_news_article->getArticleRelated($this->request->get['news_id']);
		} else {
			$articles = array();
		}
	
		$this->data['articles_related'] = array();
		
		foreach ($articles as $article) {
			$related_info = $this->model_news_article->getNewsArticle($article);
			
			if ($related_info) {
				$this->data['articles_related'][] = array(
					'news_id' => $related_info['news_id'],
					'news_titles'       => $related_info['news_titles']
				);
			}
		}
		//related product
		
		if (isset($this->request->post['article_product'])) {
			$products = $this->request->post['article_product'];
		} elseif (isset($news_article_info)) {		
			$products = $this->model_news_article->getArticleRelatedProduct($this->request->get['news_id']);
		} else {
			$products = array();
		}
	
		$this->data['articles_products'] = array();
		$this->load->model('catalog/product');
		foreach ($products as $product) {
			$product_info = $this->model_catalog_product->getProduct($product);
			
			if ($product_info) {
				$this->data['articles_products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
						
		$this->template = 'news/news_article_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['news_titles'])) < 2) || (strlen(utf8_decode($value['news_titles'])) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->post['filter_name'])) {
			$this->load->model('news/article');
			
			$data = array(
				'filter_name' => $this->request->post['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_news_article->AjaxAutocomplete($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'article_id' => $result['news_id'],
					'article_name'       => html_entity_decode($result['news_titles'], ENT_QUOTES, 'UTF-8'),	
				);	
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>