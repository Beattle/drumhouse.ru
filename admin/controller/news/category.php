<?php 
class ControllerNewsCategory extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_category->addNewsCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_category->editNewsCategory($this->request->get['news_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('news/category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/category');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_category_id) {
				$this->model_news_category->deleteNewsCategory($news_category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'));
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
			'href'      => $this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('news/category/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('news/category/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['news_categories'] = array();
		
		$results = $this->model_news_category->getNewsCategories(0);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/category/update', 'token=' . $this->session->data['token'] . '&news_category_id=' . $result['news_category_id'], 'SSL')
			);
					
			$this->data['news_categories'][] = array(
				'news_category_id' => $result['news_category_id'],
				'news_category_name'  => $result['news_category_name'],
				'news_category_sort_order'  => $result['news_category_sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['news_category_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

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
		
		$this->template = 'news/news_category_list.tpl';
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
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		
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
			'href'      => $this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['news_category_id'])) {
			$this->data['action'] = $this->url->link('news/category/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/category/update', 'token=' . $this->session->data['token'] . '&news_category_id=' . $this->request->get['news_category_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/category', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['news_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_category_info = $this->model_news_category->getNewsCategory($this->request->get['news_category_id']);
    	}
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['news_category_description'])) {
			$this->data['news_category_description'] = $this->request->post['news_category_description'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_description'] = $this->model_news_category->getNewsCategoryDescriptions($this->request->get['news_category_id']);
		} else {
			$this->data['news_category_description'] = array();
		}

		$news_categories = $this->model_news_category->getNewsCategories(0);

		// Remove own id from list
		if (isset($news_category_info)) {
			foreach ($news_categories as $key => $news_category) {
				if ($news_category['news_category_id'] == $news_category_info['news_category_id']) {
					unset($news_categories[$key]);
				}
			}
		}

		$this->data['news_categories'] = $news_categories;

		if (isset($this->request->post['news_category_parent_id'])) {
			$this->data['news_category_parent_id'] = $this->request->post['news_category_parent_id'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_parent_id'] = $news_category_info['news_category_parent_id'];
		} else {
			$this->data['news_category_parent_id'] = 0;
		}
						
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_category_store'])) {
			$this->data['news_category_store'] = $this->request->post['news_category_store'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_store'] = $this->model_news_category->getNewsCategoryStores($this->request->get['news_category_id']);
		} else {
			$this->data['news_category_store'] = array(0);
		}			
		
		if (isset($this->request->post['news_category_meta_keyword'])) {
			$this->data['news_category_meta_keyword'] = $this->request->post['news_category_meta_keyword'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_meta_keyword'] = $news_category_info['news_category_meta_keyword'];
		} else {
			$this->data['news_category_meta_keyword'] = '';
		}

		if (isset($this->request->post['news_category_image'])) {
			$this->data['news_category_image'] = $this->request->post['news_category_image'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_image'] = $news_category_info['news_category_image'];
		} else {
			$this->data['news_category_image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($news_category_info) && $news_category_info['news_category_image'] && file_exists(DIR_IMAGE . $news_category_info['news_category_image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_category_info['news_category_image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['news_category_top'])) {
			$this->data['news_category_top'] = $this->request->post['news_category_top'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_top'] = $news_category_info['news_category_top'];
		} else {
			$this->data['news_category_top'] = 0;
		}
		
		if (isset($this->request->post['news_category_column'])) {
			$this->data['news_category_column'] = $this->request->post['news_category_column'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_column'] = $news_category_info['news_category_column'];
		} else {
			$this->data['news_category_column'] = 1;
		}
				
		if (isset($this->request->post['news_category_sort_order'])) {
			$this->data['news_category_sort_order'] = $this->request->post['news_category_sort_order'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_sort_order'] = $news_category_info['news_category_sort_order'];
		} else {
			$this->data['news_category_sort_order'] = 0;
		}
		
		if (isset($this->request->post['news_category_status'])) {
			$this->data['news_category_status'] = $this->request->post['news_category_status'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_status'] = $news_category_info['news_category_status'];
		} else {
			$this->data['news_category_status'] = 1;
		}
				
		if (isset($this->request->post['news_category_layout'])) {
			$this->data['news_category_layout'] = $this->request->post['news_category_layout'];
		} elseif (isset($news_category_info)) {
			$this->data['news_category_layout'] = $this->model_news_category->getNewsCategoryLayouts($this->request->get['news_category_id']);
		} else {
			$this->data['news_category_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
						
		$this->template = 'news/news_category_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_category_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['news_category_name'])) < 2) || (strlen(utf8_decode($value['news_category_name'])) > 255)) {
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
		if (!$this->user->hasPermission('modify', 'news/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}
?>