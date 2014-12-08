<?php
class ControllerModuleTrinityLinks extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/trinity_links');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('trinity_links', $this->request->post);

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

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['entry_href_1'] = $this->language->get('entry_href_1');
		$this->data['entry_href_2'] = $this->language->get('entry_href_2');
		$this->data['entry_href_3'] = $this->language->get('entry_href_3');

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
			'href'      => $this->url->link('module/trinity_links', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/trinity_links', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['trinity_links_module'])) {
			$this->data['modules'] = $this->request->post['trinity_links_module'];
		} elseif ($this->config->get('trinity_links_module')) {
			$this->data['modules'] = $this->config->get('trinity_links_module');
		}

        if (isset($this->request->post['trinity_links_href_1'])) {
			$this->data['trinity_links_href_1'] = $this->request->post['trinity_links_href_1'];
		} else {
		    $this->data['trinity_links_href_1'] = $this->config->get('trinity_links_href_1');
            if (empty($this->data['trinity_links_href_1']))
    		    $this->data['trinity_links_href_1'] = "index.php?route=product/latest";
		}

        if (isset($this->request->post['trinity_links_href_2'])) {
			$this->data['trinity_links_href_2'] = $this->request->post['trinity_links_href_2'];
		} else {
		    $this->data['trinity_links_href_2'] = $this->config->get('trinity_links_href_2');
            if (empty($this->data['trinity_links_href_2']))
    		    $this->data['trinity_links_href_2'] = "index.php?route=product/bestseller";
		}

        if (isset($this->request->post['trinity_links_href_3'])) {
			$this->data['trinity_links_href_3'] = $this->request->post['trinity_links_href_3'];
		} else {
		    $this->data['trinity_links_href_3'] = $this->config->get('trinity_links_href_3');
            if (empty($this->data['trinity_links_href_3']))
    		    $this->data['trinity_links_href_3'] = "index.php?route=product/special";
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/trinity_links.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/trinity_links')) {
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