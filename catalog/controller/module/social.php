<?php
class ControllerModuleSocial extends Controller {

	private $_name = 'social';
	
	protected function index() {
		$this->load->language('module/' . $this->_name);

		$this->load->model('localisation/language');

		$this->data['social_vk']        = $this->config->get($this->_name . '_vk');
		$this->data['social_fb']        = $this->config->get($this->_name . '_fb');
		$this->data['social_mr']        = $this->config->get($this->_name . '_mr');
		$this->data['social_tw']        = $this->config->get($this->_name . '_tw');
		$this->data['social_lj']        = $this->config->get($this->_name . '_lj');
		$this->data['social_widget']    = html_entity_decode($this->config->get($this->_name . '_widget'), ENT_QUOTES, 'UTF-8');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
		    $this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
		    $this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
?>
