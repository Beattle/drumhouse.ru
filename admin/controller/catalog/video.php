<?php
class ControllerCatalogVideo extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/video');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/video');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_video->addVideo($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/video');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_video->editVideo($this->request->get['video_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/video');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/video');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $video_id) {
				$this->model_catalog_video->deleteVideo($video_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('catalog/video', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}	

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/video', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('catalog/video/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('catalog/video/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['videos'] = array();
		
		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) *  $this->config->get('config_admin_limit'),
			'limit'           =>  $this->config->get('config_admin_limit')
		);
		
		$video_total = $this->model_catalog_video->getTotalVideos($data);
		
		$results = $this->model_catalog_video->getVideos($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/video/update', 'token=' . $this->session->data['token'] . '&video_id=' . $result['video_id'], 'SSL')
			);
					
			$this->data['videos'][] = array(
				'video_id' => $result['video_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'    => isset($this->request->post['selected']) && in_array($result['video_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
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
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_name'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=v.name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=v.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . '&sort=v.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $video_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'catalog/video_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_preview'] = $this->language->get('text_preview');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');

				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_code'] = $this->language->get('entry_code');
		
		$this->data['entry_category'] = $this->language->get('entry_category');
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
		$this->data['entry_related'] = $this->language->get('entry_related');

		
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
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
					
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}


  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/video', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['video_id'])) {
			$this->data['action'] = $this->url->link('catalog/video/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/video/update', 'token=' . $this->session->data['token'] . '&video_id=' . $this->request->get['video_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/video', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['video_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$video_info = $this->model_catalog_video->getVideo($this->request->get['video_id']);
    	}
		
		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($video_info)) {
			$this->data['name'] = $video_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($video_info)) {
			$this->data['keyword'] = $video_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($video_info)) {
			$this->data['code'] = $video_info['link'];
		} else {
			$this->data['code'] = '';
		}
		
		if (isset($this->request->post['description'])) {
			$this->data['description'] = $this->request->post['description'];
		} elseif (!empty($video_info)) {
			$this->data['description'] = $video_info['description'];
		} else {
			$this->data['description'] = '';
		}

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['video_store'])) {
			$this->data['video_store'] = $this->request->post['video_store'];
		} elseif (isset($this->request->get['video_id'])) {
			$this->data['video_store'] = $this->model_catalog_video->getVideoStores($this->request->get['video_id']);
		} else {
			$this->data['video_store'] = array(0);
		}			
		
		$this->load->model('catalog/video');
		$this->load->model('catalog/product');
				
		$this->data['categories'] = $this->model_catalog_video->getCategories();
				
		if (isset($this->request->post['video_category'])) {
			$this->data['video_category'] = $this->request->post['video_category'];
		} elseif (isset($this->request->get['video_id'])) {
			$this->data['video_category'] = $this->model_catalog_video->getVideoCategories($this->request->get['video_id']);
		} else {
			$this->data['video_category'] = array();
		}		

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($video_info)) {
			$this->data['image'] = $video_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');

		if (!empty($video_info) && $video_info['image'] && file_exists(DIR_IMAGE . $video_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($video_info['image'], 160, 135);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 160, 135);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 160, 135);
				
				
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($video_info)) {
			$this->data['sort_order'] = $video_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($video_info)) {
			$this->data['status'] = $video_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		if (isset($this->request->post['video_related'])) {
			$videos = $this->request->post['video_related'];
		} elseif (isset($this->request->get['video_id'])) {		
			$videos = $this->model_catalog_video->getVideoRelated($this->request->get['video_id']);
		} else {
			$videos = array();
		}	
	
		$this->data['video_related'] = array();
		
		foreach ($videos as $video_id) {
			$related_info = $this->model_catalog_video->getVideo($video_id);
						
			if ($related_info) {
				$this->data['video_related'][] = array(
					'video_id' => $related_info['video_id'],
					'name'       => $related_info['name']
				);
			}
		}
		
		$this->template = 'catalog/video_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/video')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 2) || (strlen(utf8_decode($this->request->post['name'])) > 64)) {
      		$this->error['name'] = $this->language->get('error_name');
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
		if (!$this->user->hasPermission('modify', 'catalog/video')) {
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

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/video');

			$results = $this->model_catalog_video->getVideos();

			foreach ($results as $result) {


				$json[] = array(
					'video_id' => $result['video_id'],
					'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				);
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function upload() {

		$json = array();

		if (isset($this->request->get['code']) && isset($this->request->get['url'])) {
            $url  = $this->request->get['url'];
            $code = $this->request->get['code'];

            $subdir    = 'data/09_preview/';
		    $directory = DIR_IMAGE . $subdir;
		    if(!is_dir($directory)) {
		        mkdir($directory, 0777);
		    }

            $filename = 'preview_' . $code . '.jpg';

		    if (file_exists($directory . $filename)) {
                unlink($directory . $filename);
		    }

            if (copy($url, $directory . $filename)) {
                $json['success']   = 'success!';
                $json['image']     = $subdir . $filename;

		        $this->load->model('tool/image');
    			$image = $this->model_tool_image->resize($subdir . $filename, 160, 135);
                $json['image_url'] = $image;

            } else {
                $json['error'] = 'error';
            }

            //$json['data'] = $image;
		}

		//$this->response->setOutput(json_encode($json));

		$this->load->library('json');
		$this->response->setOutput(Json::encode($json));
	}

}
?>