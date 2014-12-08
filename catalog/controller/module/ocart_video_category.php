<?php
class ControllerModuleOcartvideocategory extends Controller {
	protected function index() {
		$this->language->load('module/ocart_video_category');

    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['vcatid'])) {
			$parts = explode('_', (string)$this->request->get['vcatid']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['category_id'] = $parts[0];
		} else {
			$this->data['category_id'] = 0;
		}
		
		$this->load->model('video/ocart_video_category');
		
		$this->data['categories'] = array();
		
		$categories = $this->model_video_ocart_video_category->getCategories();

		foreach ($categories as $category) {
			
			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'href'        => $this->url->link('video/category', 'vcatid=' . $category['category_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ocart_video_category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ocart_video_category.tpl';
		} else {
			$this->template = 'default/template/module/ocart_video_category.tpl';
		}
		
		$this->render();
  	}
}
?>