<?php
class ControllerModuleTrinityLinks extends Controller {

	private $_name = 'trinity_links';
	
	protected function index() {
		$this->load->language('module/' . $this->_name);

		$this->load->model('localisation/language');

		$this->data['title_1']  = $this->language->get('title_1');
		$this->data['title_2']  = $this->language->get('title_2');
		$this->data['title_3']  = $this->language->get('title_3');

		$this->data['href_1']   = $this->config->get($this->_name . '_href_1');
		$this->data['href_2']   = $this->config->get($this->_name . '_href_2');
		$this->data['href_3']   = $this->config->get($this->_name . '_href_3');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
		    $this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
		    $this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
?>
