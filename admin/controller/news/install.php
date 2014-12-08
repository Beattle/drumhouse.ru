<?php 
class ControllerNewsInstall extends Controller { 
	private $error = array();
 
	public function index() {
		
		$this->load->language('news/install');
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/install', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->load->model('setting/setting');
		$news_config = $this->model_setting_setting->getSetting('newssetting');
		if($news_config)
		{
			$this->uninstall();
		}else{
			$this->install();
		}
		
	}
	public function install()
	{
		$this->load->language('news/install');
			
		$this->load->model('news/install');
		 
		$this->data['heading_title'] = $this->language->get('heading_install');
		$this->data['text_information'] = $this->language->get('text_information_install');
		$this->data['button_install'] = $this->language->get('button_install');
		$this->data['action'] = $this->url->link('news/install/install', 'token=' . $this->session->data['token'], 'SSL');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateInstall()) {
			$this->model_news_install->install();

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL')); 
		}
		$this->template = 'news/news_install.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
		
	}
	public function uninstall()
	{
			
		$this->load->model('news/install');
		 
		$this->load->language('news/install');
		$this->data['heading_title'] = $this->language->get('heading_uninstall');
		$this->data['text_information'] = $this->language->get('text_information_uninstall');
		$this->data['button_install'] = $this->language->get('button_uninstall');
		$this->data['action'] = $this->url->link('news/install/uninstall', 'token=' . $this->session->data['token'], 'SSL');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateInstall()) {
			$this->model_news_install->uninstall();

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')); 
		}
		$this->template = 'news/news_install.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	private function validateInstall() {
		if (!$this->user->hasPermission('modify', 'news/install')) {
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