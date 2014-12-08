<?php
class ControllerModuleSocial extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('module/social');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('social', $this->request->post);

			$this->cache->delete('product');

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

		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');


		$this->data['entry_vk']     = $this->language->get('entry_vk');
		$this->data['entry_fb']     = $this->language->get('entry_fb');
		$this->data['entry_mr']     = $this->language->get('entry_mr');
		$this->data['entry_tw']     = $this->language->get('entry_tw');
		$this->data['entry_lj']     = $this->language->get('entry_lj');
		$this->data['entry_widget'] = $this->language->get('entry_widget');

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
		
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
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
			'href'      => $this->url->link('module/social', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/social', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['social_module'])) {
			$this->data['modules'] = $this->request->post['social_module'];
		} elseif ($this->config->get('social_module')) {
			$this->data['modules'] = $this->config->get('social_module');
		}

        if (isset($this->request->post['social_vk'])) {
			$this->data['social_vk'] = $this->request->post['social_vk'];
		} else {
		    $this->data['social_vk'] = $this->config->get('social_vk');
		}

        if (isset($this->request->post['social_fb'])) {
			$this->data['social_fb'] = $this->request->post['social_fb'];
		} else {
		    $this->data['social_fb'] = $this->config->get('social_fb');
		}

        if (isset($this->request->post['social_mr'])) {
			$this->data['social_mr'] = $this->request->post['social_mr'];
		} else {
		    $this->data['social_mr'] = $this->config->get('social_mr');
		}

        if (isset($this->request->post['social_tw'])) {
			$this->data['social_tw'] = $this->request->post['social_tw'];
		} else {
		    $this->data['social_tw'] = $this->config->get('social_tw');
		}

        if (isset($this->request->post['social_lj'])) {
			$this->data['social_lj'] = $this->request->post['social_lj'];
		} else {
		    $this->data['social_lj'] = $this->config->get('social_lj');
		}

        if (isset($this->request->post['social_widget'])) {
			$this->data['social_widget'] = $this->request->post['social_widget'];
		} else {
		    $this->data['social_widget'] = $this->config->get('social_widget');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/social.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/social')) {
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