<?php
class ControllerModuleCR2HTMLModule extends Controller {

	private $_name = 'cr2htmlmodule';
	private $_version = '1.5c';

     protected function index($setting) {
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->data['heading_title'] = "CR2 HTML Module";

		$this->data['code1'] = html_entity_decode($this->config->get($this->_name . '_code1_' . $this->config->get('config_language_id')));
		$this->data['code2'] = html_entity_decode($this->config->get($this->_name . '_code2_' . $this->config->get('config_language_id')));
		$this->data['code3'] = html_entity_decode($this->config->get($this->_name . '_code3_' . $this->config->get('config_language_id')));
		$this->data['code4'] = html_entity_decode($this->config->get($this->_name . '_code4_' . $this->config->get('config_language_id')));
		$this->data['code5'] = html_entity_decode($this->config->get($this->_name . '_code5_' . $this->config->get('config_language_id')));

		$this->data['title1'] = $this->config->get($this->_name . '_title1_' . $this->config->get('config_language_id'));
		$this->data['title2'] = $this->config->get($this->_name . '_title2_' . $this->config->get('config_language_id'));
		$this->data['title3'] = $this->config->get($this->_name . '_title3_' . $this->config->get('config_language_id'));
		$this->data['title4'] = $this->config->get($this->_name . '_title4_' . $this->config->get('config_language_id'));
		$this->data['title5'] = $this->config->get($this->_name . '_title5_' . $this->config->get('config_language_id'));

		$this->data['header1'] = $this->config->get( $this->_name . '_header1');
		$this->data['header2'] = $this->config->get( $this->_name . '_header2');
		$this->data['header3'] = $this->config->get( $this->_name . '_header3');
		$this->data['header4'] = $this->config->get( $this->_name . '_header4');
		$this->data['header5'] = $this->config->get( $this->_name . '_header5');

		$this->data['borderless1'] = $this->config->get( $this->_name . '_borderless1');
		$this->data['borderless2'] = $this->config->get( $this->_name . '_borderless2');
		$this->data['borderless3'] = $this->config->get( $this->_name . '_borderless3');
		$this->data['borderless4'] = $this->config->get( $this->_name . '_borderless4');
		$this->data['borderless5'] = $this->config->get( $this->_name . '_borderless5');

		if( !$this->data['title1'] ) {
			$this->data['title1'] = $this->data['heading_title'];
		}
		if( !$this->data['title2'] ) {
			$this->data['title2'] = $this->data['heading_title'];
		}
		if( !$this->data['title3'] ) {
			$this->data['title3'] = $this->data['heading_title'];
		}
		if( !$this->data['title4'] ) {
			$this->data['title4'] = $this->data['heading_title'];
		}
		if( !$this->data['title5'] ) {
			$this->data['title5'] = $this->data['heading_title'];
		}

		if( !$this->data['header1'] ) { $this->data['title1'] = ''; }
        if( !$this->data['header2'] ) { $this->data['title2'] = ''; }
        if( !$this->data['header3'] ) { $this->data['title3'] = ''; }
        if( !$this->data['header4'] ) { $this->data['title4'] = ''; }
        if( !$this->data['header5'] ) { $this->data['title5'] = ''; }

          $position = $setting["area_id"];
          $this->data['classname'] = $setting['classname'];

		switch($position){
		     case "area1":
                         $this->data['code'] = $this->data['code1'];
                         $this->data['title'] = $this->data['title1'];
                         $this->data['borderless'] = $this->data['borderless1'];
                         break;
		     case "area2":
                         $this->data['code'] = $this->data['code2'];
                         $this->data['title'] = $this->data['title2'];
                         $this->data['borderless'] = $this->data['borderless2'];
                         break;
		     case "area3":
                         $this->data['code'] = $this->data['code3'];
                         $this->data['title'] = $this->data['title3'];
                         $this->data['borderless'] = $this->data['borderless3'];
                         break;
		     case "area4":
                         $this->data['code'] = $this->data['code4'];
                         $this->data['title'] = $this->data['title4'];
                         $this->data['borderless'] = $this->data['borderless4'];
                         break;
		     case "area5":
                         $this->data['code'] = $this->data['code5'];
                         $this->data['title'] = $this->data['title5'];
                         $this->data['borderless'] = $this->data['borderless5'];
                         break;
		     default: $this->data['code'] = ''; $this->data['title'] = ''; $this->data['borderless'] = 0;
		} // switch

		$this->id = $this->_name;


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/'.$this->_name.'.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/'.$this->_name.'.tpl';
		} else {
			$this->template = 'default/template/module/'.$this->_name.'.tpl';
		}

		$this->render();
	}
}
?>
