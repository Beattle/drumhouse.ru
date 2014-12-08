<?php
class ControllerModuleNewsArticle extends Controller {

	private $error = array();
	public function index()
	{
		$this->load->language('module/newsarticle');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {			
			$this->model_setting_setting->editSetting('newsarticle', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_setting'] = $this->language->get('text_enabled');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_column_setting'] = $this->language->get('text_column_setting');
		
		$this->data['text_showimg'] = $this->language->get('text_showimg');
		$this->data['text_descshow'] = $this->language->get('text_descshow');
		$this->data['text_showmore'] = $this->language->get('text_showmore');
		$this->data['text_desclimit'] = $this->language->get('text_desclimit');
		$this->data['text_showdate'] = $this->language->get('text_showdate');		
		$this->data['text_showcomment'] = $this->language->get('text_showcomment');
		$this->data['text_showvote'] = $this->language->get('text_showvote');
		$this->data['text_showview'] = $this->language->get('text_showview');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_title'] = $this->language->get('text_order_title');
		$this->data['text_order_creat'] = $this->language->get('text_order_creat');
		$this->data['text_order_modify'] = $this->language->get('text_order_modify');
		$this->data['text_order_comment'] = $this->language->get('text_order_comment');		
		$this->data['text_order_vote'] = $this->language->get('text_order_vote');
		$this->data['text_order_view'] = $this->language->get('text_order_view');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_category2'] = $this->language->get('text_category2');
		$this->data['text_article'] = $this->language->get('text_article');
		$this->data['entry_article'] = $this->language->get('entry_article');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_setting'] = $this->language->get('entry_setting');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		
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
			'href'      => $this->url->link('module/newsarticle', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/newsarticle', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('news/category');

		$cat = $this->model_news_category->getNewsCategories(0);
		
		//$autocat[] = array(
		//	'news_category_id' => 'auto',
		//	'news_category_name' => 'Auto Fill Catagory'
		//);
		//$this->data['news_categories'] = array_merge($cat,$autocat);

		$this->data['news_categories'] = $cat;

		$this->data['modules'] = array();
		
		if (isset($this->request->post['newsarticle_module'])) {
			$this->data['modules'] = $this->request->post['newsarticle_module'];
		} elseif ($this->config->get('newsarticle_module')) { 
			$this->data['modules'] = $this->config->get('newsarticle_module');
		}		
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/newsarticle.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/newsarticle')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['newsarticle_module'])) {
			foreach ($this->request->post['newsarticle_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>