<?php
class ControllerNewsAlbums extends Controller{
	private $error = array();
	public function index(){
		$this->load->language('news/albums');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/albums');
		 
		$this->getList();
	}
	public function insert() {
		$this->load->language('news/albums');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/albums');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_albums->addNewsalbums($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/albums', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('news/albums');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/albums');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_albums->editNewsalbums($this->request->get['news_albums_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/albums', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('news/albums');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/albums');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_albums_id) {
				$this->model_news_albums->deleteNewsalbums($news_albums_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('news/albums', 'token=' . $this->session->data['token'], 'SSL'));
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
			'href'      => $this->url->link('news/albums', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('news/albums/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('news/albums/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['news_galleryalbums'] = array();
		
		$results = $this->model_news_albums->getNewsAlbums(0);
		$this->load->model('tool/image');
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/albums/update', 'token=' . $this->session->data['token'] . '&news_albums_id=' . $result['news_gallery_album_id'], 'SSL')
			);
			if ($result['news_gallery_album_image'] && file_exists(DIR_IMAGE . $result['news_gallery_album_image'])) {
				$image = $this->model_tool_image->resize($result['news_gallery_album_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}			
			$this->data['news_galleryalbums'][] = array(
				'news_albums_id' => $result['news_gallery_album_id'],
				'news_albums_name'  => $result['news_gallery_album_name'],
				'news_albums_sort_order'  => $result['news_gallery_album_sort_order'],
				'news_albums_images' => $image,
				'selected'    => isset($this->request->post['selected']) && in_array($result['news_gallery_album_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_image'] = $this->language->get('column_image');
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
		
		$this->template = 'news/gallery_album_list.tpl';
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
			'href'      => $this->url->link('news/albums', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['news_albums_id'])) {
			$this->data['action'] = $this->url->link('news/albums/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/albums/update', 'token=' . $this->session->data['token'] . '&news_albums_id=' . $this->request->get['news_albums_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/albums', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['news_albums_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_albums_info = $this->model_news_albums->getNewsAlbum($this->request->get['news_albums_id']);
    	}
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['news_albums_description'])) {
			$this->data['news_albums_description'] = $this->request->post['news_albums_description'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_description'] = $this->model_news_albums->getNewsalbumsDescriptions($this->request->get['news_albums_id']);
		} else {
			$this->data['news_albums_description'] = array();
		}

		$news_gallery_albums = $this->model_news_albums->getNewsAlbums(0);

		// Remove own id from list
		if (isset($news_albums_info)) {
			foreach ($news_gallery_albums as $key => $news_albums) {
				if ($news_albums['news_gallery_album_id'] == $news_albums_info['news_gallery_album_id']) {
					unset($news_gallery_albums[$key]);
				}
			}
		}

		$this->data['news_albums'] = $news_gallery_albums;

		if (isset($this->request->post['news_albums_parent_id'])) {
			$this->data['news_albums_parent_id'] = $this->request->post['news_albums_parent_id'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_parent_id'] = $news_albums_info['news_gallery_album_parent_id'];
		} else {
			$this->data['news_albums_parent_id'] = 0;
		}
						
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_albums_store'])) {
			$this->data['news_albums_store'] = $this->request->post['news_albums_store'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_store'] = $this->model_news_albums->getNewsAlbumsStores($this->request->get['news_albums_id']);
		} else {
			$this->data['news_albums_store'] = array(0);
		}			
		
		if (isset($this->request->post['news_albums_meta_keyword'])) {
			$this->data['news_albums_meta_keyword'] = $this->request->post['news_albums_meta_keyword'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_meta_keyword'] = $news_albums_info['news_gallery_album_meta_keyword'];
		} else {
			$this->data['news_albums_meta_keyword'] = '';
		}

		if (isset($this->request->post['news_albums_image'])) {
			$this->data['news_albums_image'] = $this->request->post['news_albums_image'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_image'] = $news_albums_info['news_gallery_album_image'];
		} else {
			$this->data['news_albums_image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($news_albums_info) && $news_albums_info['news_gallery_album_image'] && file_exists(DIR_IMAGE . $news_albums_info['news_gallery_album_image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_albums_info['news_gallery_album_image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['news_albums_sort_order'])) {
			$this->data['news_albums_sort_order'] = $this->request->post['news_albums_sort_order'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_sort_order'] = $news_albums_info['news_gallery_album_sort_order'];
		} else {
			$this->data['news_albums_sort_order'] = 0;
		}
		
		if (isset($this->request->post['news_albums_status'])) {
			$this->data['news_albums_status'] = $this->request->post['news_albums_status'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_status'] = $news_albums_info['news_gallery_album_status'];
		} else {
			$this->data['news_albums_status'] = 1;
		}
				
		if (isset($this->request->post['news_albums_layout'])) {
			$this->data['news_albums_layout'] = $this->request->post['news_albums_layout'];
		} elseif (isset($news_albums_info)) {
			$this->data['news_albums_layout'] = $this->model_news_albums->getNewsAlbumsLayouts($this->request->get['news_albums_id']);
		} else {
			$this->data['news_albums_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
						
		$this->template = 'news/gallery_album_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/albums')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_albums_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['news_albums_name'])) < 2) || (strlen(utf8_decode($value['news_albums_name'])) > 255)) {
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
		if (!$this->user->hasPermission('modify', 'news/albums')) {
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