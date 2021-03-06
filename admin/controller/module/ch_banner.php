<?php
class ControllerModuleCHBanner extends Controller {
	private $error = array();
	private $_name = 'ch_banner';
	private $_version = '1.5.1';

	public function index() {
		$this->load->language('module/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data[$this->_name . '_version'] = $this->_version;
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_column_center'] = $this->language->get('text_column_center');
		
		$this->data['text_module_settings'] = $this->language->get('text_module_settings');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_box'] = $this->language->get('entry_box');
		$this->data['entry_yes'] = $this->language->get('entry_yes');
		$this->data['entry_no']	= $this->language->get('entry_no');
		$this->data['entry_html']   = $this->language->get('entry_html');
		$this->data['entry_root'] = $this->language->get('entry_root');

    	$this->data['entry_category'] = $this->language->get('entry_category');

		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

        $this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['error_limit'])) {
			$this->data['error_limit'] = $this->error['error_limit'];
		} else {
			$this->data['error_limit'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->request->post[$this->_name . '_title' . $language['language_id']])) {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->request->post[$this->_name . '_title' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->config->get($this->_name . '_title' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_html' . $language['language_id']])) {
				$this->data[$this->_name . '_html' . $language['language_id']] = $this->request->post[$this->_name . '_html' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_html' . $language['language_id']] = $this->config->get($this->_name . '_html' . $language['language_id']);
			}
		}
		$this->data['languages'] = $languages;


		$this->load->model('module/ch_banner');

		//$categories = $this->model_catalog_category->getAllCategories();
		$categories = $this->model_module_ch_banner->getAllCategories();


		$this->data['categories'] = $this->getAllCategories($categories);

		if (isset($this->request->post[$this->_name . 'ch_banner_category'])) {
			$this->data[$this->_name . '_category'] = $this->request->post[$this->_name . '_category'];
		} else {
		    $this->data[$this->_name . '_category'] = $this->config->get($this->_name . '_category');
		}

		if (isset($this->request->post[$this->_name . '_header'])) {
			$this->data[$this->_name . '_header'] = $this->request->post[$this->_name . '_header'];
		} else { 
			$this->data[$this->_name . '_header'] = $this->config->get($this->_name . '_header' ); 
		}

		//if (isset($this->request->post[$this->_name . '_title'])) {
		//	$this->data[$this->_name . '_title'] = $this->request->post[$this->_name . '_title'];
		//} else {
		//	$this->data[$this->_name . '_title'] = $this->config->get($this->_name . '_title' );
		//}
		
		if (isset($this->request->post[$this->_name . '_box'])) {
			$this->data[$this->_name . '_box'] = $this->request->post[$this->_name . '_box'];
		} else {
			$this->data[$this->_name . '_box'] = $this->config->get($this->_name . '_box' );
		}

		if (isset($this->request->post[$this->_name . '_root'])) {
			$this->data[$this->_name . '_root'] = $this->request->post[$this->_name . '_root'];
		} else {
			$this->data[$this->_name . '_root'] = $this->config->get($this->_name . '_root' );
		}

		//if (isset($this->request->post[$this->_name . '_html'])) {
		//	$this->data[$this->_name . '_html'] = $this->request->post[$this->_name . '_html'];
		//} else {
		//	$this->data[$this->_name . '_html'] = $this->config->get($this->_name . '_html');
		//}

		$this->data['modules'] = array();

		if (isset($this->request->post[$this->_name . '_module'])) {
			$this->data['modules'] = $this->request->post[$this->_name . '_module'];
		} elseif ($this->config->get($this->_name . '_module')) { 
			$this->data['modules'] = $this->config->get($this->_name . '_module');
		}
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
	
		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
		$output = array();

		if (array_key_exists($parent_id, $categories)) {
			if ($parent_name != '') {
				$parent_name .= ' &raquo; '; //$this->language->get('text_separator');
			}

			foreach ($categories[$parent_id] as $category) {
				$output[$category['category_id']] = array(
					'category_id' => $category['category_id'],
					'name'        => $parent_name . $category['name']
				);

				$output += $this->getAllCategories($categories, $category['category_id'], $parent_name . $category['name']);
			}
		}

		return $output;
	}

}
?>
