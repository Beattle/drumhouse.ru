<?php
class ControllerNewsImages extends Controller{
	private $error = array();
	public function index() {
		$this->load->language('news/images');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/images');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('news/images');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/images');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_images->addNewsImages($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/images', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('news/images');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/images');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_images->editNewsImages($this->request->get['image_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/images', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('news/images');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/images');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $image_id) {
				$this->model_news_images->deleteNewsImages($image_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('news/images', 'token=' . $this->session->data['token'], 'SSL'));
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
			'href'      => $this->url->link('news/images', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('news/images/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('news/images/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['news_images'] = array();
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
		
		$results = $this->model_news_images->getNewsimages($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/images/update', 'token=' . $this->session->data['token'] . '&image_id=' . $result['news_gallery_id'], 'SSL')
			);
			if ($result['news_gallery_image'] && file_exists(DIR_IMAGE . $result['news_gallery_image'])) {
				$image = $this->model_tool_image->resize($result['news_gallery_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}		
			$this->data['news_images'][] = array(
				'images_id' => $result['news_gallery_id'],
				'images_titles'  => $result['news_gallery_titles'],
				'images_sort_order'  => $result['news_gallery_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['image_id'], $this->request->post['selected']),
				'images_image' => $image,
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
		
		
		$images_total = $this->model_news_images->getTotalImages();
		$url = '';
		$pagination = new Pagination();
		$pagination->total = $images_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/images', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'news/gallery_image_list.tpl';
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
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
	
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_image'] = $this->language->get('entry_image');
	
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_albums'] = $this->language->get('entry_albums');
		
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
	
		
		$this->data['entry_showdate']         = $this->language->get('entry_showdate');
		$this->data['entry_showvote']         = $this->language->get('entry_showvote');
		$this->data['entry_showview']         = $this->language->get('entry_showview');
	
	
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
			'href'      => $this->url->link('news/images', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['image_id'])) {
			$this->data['action'] = $this->url->link('news/images/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/images/update', 'token=' . $this->session->data['token'] . '&image_id=' . $this->request->get['image_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/images', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['image_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_images_info = $this->model_news_images->getNewsImage($this->request->get['image_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['news_images_description'])) {
			$this->data['news_images_description'] = $this->request->post['news_image_description'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_description'] = $this->model_news_images->getNewsImagesDescriptions($this->request->get['image_id']);
		} else {
			$this->data['news_images_description'] = array();
		}
		$this->load->model('news/albums');

		$this->data['news_albums'] = $this->model_news_albums->getNewsAlbums(0);;
		if (isset($this->request->post['news_image_album'])) {
					$this->data['news_image_album'] = $this->request->post['news_image_album'];
				} elseif (isset($news_images_info)) {
					$this->data['news_image_album'] = $this->model_news_images->getNewsAlbums($this->request->get['image_id']);
				} else {
					$this->data['news_image_album'] = array();
				}		
		
		if (isset($this->request->post['image_id'])) {
			$this->data['news_image_id'] = $this->request->post['news_image_id'];
		} elseif (isset($new_images_info)) {
			$this->data['news_image_id'] = $news_images_info['news_gallery_id'];
		} else {
			$this->data['news_image_id'] = 0;
		}
						
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_images_store'])) {
			$this->data['news_images_store'] = $this->request->post['news_images_store'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_store'] = $this->model_news_images->getNewsImagesStores($this->request->get['image_id']);
		} else {
			$this->data['news_images_store'] = array(0);
		}			

		if (isset($this->request->post['news_images_image'])) {
			$this->data['news_images_image'] = $this->request->post['news_images_image'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_image'] = $news_images_info['news_gallery_image'];
		} else {
			$this->data['news_images_image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($news_images_info) && $news_images_info['news_gallery_image'] && file_exists(DIR_IMAGE . $news_images_info['news_gallery_image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_images_info['news_gallery_image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['news_images_showdate'])) {
			$this->data['news_images_showdate'] = $this->request->post['news_images_showdate'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_showdate'] = $news_images_info['news_gallery_showdate'];
		} else {
			$this->data['news_images_showdate'] = 1;
		}
		if (isset($this->request->post['news_images_showvote'])) {
			$this->data['news_images_showvote'] = $this->request->post['news_images_showvote'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_showvote'] = $news_images_info['news_gallery_showvote'];
		} else {
			$this->data['news_images_showvote'] = 1;
		}
		if (isset($this->request->post['news_images_showview'])) {
			$this->data['news_images_showview'] = $this->request->post['news_images_showview'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_showview'] = $news_images_info['news_gallery_showviewed'];
		} else {
			$this->data['news_images_showview'] = 1;
		}
		if (isset($this->request->post['news_images_sort_order'])) {
			$this->data['news_images_sort_order'] = $this->request->post['news_images_sort_order'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_sort_order'] = $news_images_info['news_gallery_order'];
		} else {
			$this->data['news_images_sort_order'] = 0;
		}
		
		if (isset($this->request->post['news_images_status'])) {
			$this->data['news_images_status'] = $this->request->post['news_images_status'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_status'] = $news_images_info['news_gallery_status'];
		} else {
			$this->data['news_images_status'] = 1;
		}
				
		if (isset($this->request->post['news_images_layout'])) {
			$this->data['news_images_layout'] = $this->request->post['news_images_layout'];
		} elseif (isset($news_images_info)) {
			$this->data['news_images_layout'] = $this->model_news_images->getNewsImagesLayouts($this->request->get['image_id']);
		} else {
			$this->data['news_images_layout'] = array();
		}
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
						
		$this->template = 'news/gallery_image_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/images')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_images_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['news_images_images_titles'])) < 2) || (strlen(utf8_decode($value['news_images_images_titles'])) > 255)) {
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
		if (!$this->user->hasPermission('modify', 'news/images')) {
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