<?php
class ControllerModuleContacts extends Controller {

	private $_name = 'contacts';
	
	protected function index() {
		$this->load->language('module/' . $this->_name);

		$this->load->model('localisation/language');

		$this->data['title']        = $this->config->get($this->_name . '_title');
		$this->data['code']         = $this->config->get($this->_name . '_code');
		$this->data['phone']        = $this->config->get($this->_name . '_phone');
		$this->data['skype_name']   = $this->config->get($this->_name . '_skype_name');
		$this->data['skype_href']   = $this->config->get($this->_name . '_skype_href');
		$this->data['icq']          = $this->config->get($this->_name . '_icq');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
		    $this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
		    $this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
?>
