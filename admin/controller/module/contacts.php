<?php
class ControllerModuleContacts extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/contacts');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('contacts', $this->request->post);

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

		$this->data['entry_title']      = $this->language->get('entry_title');
		$this->data['entry_code']       = $this->language->get('entry_code');
		$this->data['entry_phone']      = $this->language->get('entry_phone');
		$this->data['entry_skype_name'] = $this->language->get('entry_skype_name');
		$this->data['entry_skype_href'] = $this->language->get('entry_skype_href');
		$this->data['entry_icq']        = $this->language->get('entry_icq');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

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
			'href'      => $this->url->link('module/contacts', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/contacts', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['contacts_module'])) {
			$this->data['modules'] = $this->request->post['contacts_module'];
		} elseif ($this->config->get('contacts_module')) {
			$this->data['modules'] = $this->config->get('contacts_module');
		}

        if (isset($this->request->post['contacts_title'])) {
			$this->data['contacts_title'] = $this->request->post['contacts_title'];
		} else {
		    $this->data['contacts_title'] = $this->config->get('contacts_title');
		}

        if (isset($this->request->post['contacts_code'])) {
			$this->data['contacts_code'] = $this->request->post['contacts_code'];
		} else {
		    $this->data['contacts_code'] = $this->config->get('contacts_code');
		}

        if (isset($this->request->post['contacts_phone'])) {
			$this->data['contacts_phone'] = $this->request->post['contacts_phone'];
		} else {
		    $this->data['contacts_phone'] = $this->config->get('contacts_phone');
		}

        if (isset($this->request->post['contacts_skype_name'])) {
			$this->data['contacts_skype_name'] = $this->request->post['contacts_skype_name'];
		} else {
		    $this->data['contacts_skype_name'] = $this->config->get('contacts_skype_name');
		}

        if (isset($this->request->post['contacts_skype_href'])) {
			$this->data['contacts_skype_href'] = $this->request->post['contacts_skype_href'];
		} else {
		    $this->data['contacts_skype_href'] = $this->config->get('contacts_skype_href');
            if (empty($this->data['contacts_skype_href']))
    		    $this->data['contacts_skype_href'] = 'skype:your_skype_name?chat';
		}

        if (isset($this->request->post['contacts_icq'])) {
			$this->data['contacts_icq'] = $this->request->post['contacts_icq'];
		} else {
		    $this->data['contacts_icq'] = $this->config->get('contacts_icq');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/contacts.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/contacts')) {
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