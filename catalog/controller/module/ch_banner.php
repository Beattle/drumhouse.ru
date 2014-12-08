<?php
class ControllerModuleCHBanner extends Controller {

	private $_name = 'ch_banner';
	
	protected function index() {
		$this->load->language('module/' . $this->_name);
		
		$this->load->model('localisation/language');

		$category_id = 0;
		if (isset($this->request->get['path'])) {
			$path  = '';
			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = array_pop($parts);
		}

        $html = $this->config->get($this->_name . '_html' . $this->config->get('config_language_id'));


		$this->data['heading_title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));
		$this->data['box']           = $this->config->get($this->_name . '_box');
        $this->data['visible']       = 1;

		$html_text  = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
        $parts      = mb_split('<!--more-->', $html_text);
        //debug(count($parts));

        if (count($parts) > 0) {
			$this->data['begin_description'] = $parts[0];
			$this->data['end_description']   = false;
        } else {
			$this->data['begin_description'] = false;
			$this->data['end_description']   = false;
        }

        if (count($parts) > 1) {
			$this->data['end_description']   = $parts[1];
        }

		$show_in_root = $this->config->get($this->_name . '_root');

        $categories = $this->config->get($this->_name . '_category');
        if ($categories && (in_array($category_id, $categories) || $show_in_root)) {
            $this->data['visible']  = 1;
        }

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
			} else {
				$this->template = 'default/template/module/' . $this->_name . '.tpl';
			}
			
		$this->render();
	}
}
?>
