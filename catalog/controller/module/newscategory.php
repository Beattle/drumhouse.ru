<?php
class ControllerModuleNewsCategory extends Controller {
	protected function index() {
		$this->language->load('module/newscategory');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['catid'])) {
			$parts = explode('_', (string)$this->request->get['catid']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['news_category_id'] = $parts[0];
		} else {
			$this->data['news_category_id'] = 0;
		}
        $news_category_id = $this->data['news_category_id'];
		
		if (isset($parts[1])) {
			$this->data['child_news_category_id'] = $parts[1];
		} else {
			$this->data['child_news_category_id'] = 0;
		}
							
		$this->load->model('news/category');
		
		$this->data['news_categories'] = array();

		//$news_categories = $this->model_news_category->getNewsCategories(0);
		$news_categories = $this->model_news_category->getNewsCategories($news_category_id);

		foreach ($news_categories as $news_category) {
			$children_data = array();
			
			$children_cat = $this->model_news_category->getNewsCategories($news_category['news_category_id']);
			
			foreach ($children_cat as $child) {
						
				$children_data[] = array(
					'news_category_id' => $child['news_category_id'],
					'news_category_name' => $child['news_category_name'],
					'href'        => $this->url->link('news/category', 'catid=' . $news_category['news_category_id'] . '_' . $child['news_category_id'])
				);					
			}		
			$this->data['news_categories'][] = array(
				'news_category_id' => $news_category['news_category_id'],
				'news_category_name' => $news_category['news_category_name'],
				'children'    => $children_data,
				'href'        => $this->url->link('news/category', 'catid=' . $news_category_id . '_' . $news_category['news_category_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newscategory.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/newscategory.tpl';
		} else {
			$this->template = 'default/template/module/newscategory.tpl';
		}
		
		$this->render();
  	}
}
?>