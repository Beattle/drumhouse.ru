<?php 
class ControllerNewsSetting extends Controller { 
	private $error = array();
	private $version = '1.4';
	public function index()
	{
		$this->language->load('news/setting');
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('newssetting', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['head_news'] = $this->language->get('head_news');
		$this->data['head_category'] = $this->language->get('head_category');
		$this->data['head_article'] = $this->language->get('head_article');
		$this->data['head_comment'] = $this->language->get('head_comment');
		$this->data['head_gallery'] = $this->language->get('head_gallery');
		$this->data['entry_datetime'] = $this->language->get('entry_datetime');
		$this->data['entry_itemperpage'] = $this->language->get('entry_itemperpage');
		$this->data['entry_thumbsetting'] = $this->language->get('entry_thumbsetting');
		$this->data['entry_thumbsetting_w'] = $this->language->get('entry_thumbsetting_w');
		$this->data['entry_thumbsetting_h'] = $this->language->get('entry_thumbsetting_h');
		$this->data['entry_description_limit'] = $this->language->get('entry_description_limit');
		//gallery
		$this->data['entry_gallerytomenu'] = $this->language->get('entry_gallerytomenu');
		$this->data['entry_gallery_order'] = $this->language->get('entry_gallery_order');
		$this->data['entry_albumsperpage'] = $this->language->get('entry_albumsperpage');
		$this->data['entry_albumsthumbsetting'] = $this->language->get('entry_albumsthumbsetting');
		$this->data['entry_imagesperpage'] = $this->language->get('entry_imagesperpage');
		$this->data['entry_imagesthumbsetting'] = $this->language->get('entry_imagesthumbsetting');
		$this->data['entry_gallery_sharescript'] = $this->language->get('entry_gallery_sharescript');
		
		$this->data['entry_subcategory'] = $this->language->get('entry_subcategory');
		$this->data['entry_showcreatdate'] = $this->language->get('entry_showdate');
		$this->data['entry_showvote'] = $this->language->get('entry_showvote');
		$this->data['entry_showcommentcount'] = $this->language->get('entry_showcommentcount');
		$this->data['entry_showreadmore'] = $this->language->get('entry_showreadmore');
		$this->data['entry_news_yes'] = $this->language->get('entry_news_yes');
		$this->data['entry_news_no'] = $this->language->get('entry_news_no');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_article_subcategory'] = $this->language->get('entry_article_subcategory');
		$this->data['entry_article_showdate'] = $this->language->get('entry_article_showdate');
		$this->data['entry_article_showvote'] = $this->language->get('entry_article_showvote');
		$this->data['entry_showview'] = $this->language->get('entry_showview');
		$this->data['entry_showdesc'] = $this->language->get('entry_showdesc');
		$this->data['entry_show_gravatar']=$this->language->get('entry_show_gravatar');
		$this->data['entry_gravatar_resize']=$this->language->get('entry_gravatar_resize');
		
		$this->data['entry_gallery_theme'] = $this->language->get('entry_gallery_theme');
		$this->data['entry_gallery_albums']= $this->language->get('entry_gallery_albums');
		$this->data['entry_gallery_images']= $this->language->get('entry_gallery_images');
		$this->data['entry_gallery_sub'] = $this->language->get('entry_gallery_sub');
		$this->data['entry_showfield_title'] = $this->language->get('entry_showfield_title');
		$this->data['entry_showfield_website'] = $this->language->get('entry_showfield_website');
		$this->data['entry_gallerysub'] = $this->language->get('entry_gallerysub');
		$this->data['entry_gallery_showcount'] = $this->language->get('entry_gallery_showcount');
		$this->data['entry_gallery_showview'] = $this->language->get('entry_gallery_showview');
		$this->data['entry_gallery_showvote'] = $this->language->get('entry_gallery_showvote');
		$this->data['entry_commentperpage'] = $this->language->get('entry_commentperpage');
		$this->data['entry_gallery_showcreatdate'] = $this->language->get('entry_gallery_showcreatdate');
		$this->data['entry_article_sharescript'] = $this->language->get('entry_article_sharescript');
		$this->data['entry_autopublish'] = $this->language->get('entry_autopublish');
		$this->data['entry_automail'] = $this->language->get('entry_automail');
		if (isset($this->error['error_news_config_item'])) {
			$this->data['error_news_config_item'] = $this->error['error_news_config_item'];
		} else {
			$this->data['error_news_config_item'] = '';
		}
		if (isset($this->error['error_news_config_catthumb'])) {
			$this->data['error_news_config_catthumb'] = $this->error['error_news_config_catthumb'];
		} else {
			$this->data['error_news_config_catthumb'] = '';
		}
		
		if (isset($this->error['error_news_config_desc_limit'])) {
			$this->data['error_news_config_desc_limit'] = $this->error['error_news_config_desc_limit'];
		} else {
			$this->data['error_news_config_desc_limit'] = '';
		}
		
		if (isset($this->error['error_news_config_comment_perpage'])) {
			$this->data['error_news_config_comment_perpage'] = $this->error['error_news_config_comment_perpage'];
		} else {
			$this->data['error_news_config_comment_perpage'] = '';
		}
		if (isset($this->error['error_gravatar_thumb'])) {
			$this->data['error_gravatar_thumb'] = $this->error['error_gravatar_thumb'];
		} else {
			$this->data['error_gravatar_thumb'] = '';
		}
		//gallery
		if (isset($this->error['error_news_config_gallery_order'])) {
			$this->data['error_news_config_gallery_order'] = $this->error['error_news_config_gallery_order'];
		} else {
			$this->data['error_news_config_gallery_order'] = '';
		}
		if (isset($this->error['error_news_config_albums_perpage'])) {
			$this->data['error_news_config_albums_perpage'] = $this->error['error_news_config_albums_perpage'];
		} else {
			$this->data['error_news_config_albums_perpage'] = '';
		}
		if (isset($this->error['error_news_config_albumsthumb'])) {
			$this->data['error_news_config_albumsthumb'] = $this->error['error_news_config_albumsthumb'];
		} else {
			$this->data['error_news_config_albumsthumb'] = '';
		}
		if (isset($this->error['error_news_config_images_perpage'])) {
			$this->data['error_news_config_images_perpage'] = $this->error['error_news_config_images_perpage'];
		} else {
			$this->data['error_news_config_images_perpage'] = '';
		}
		if (isset($this->error['error_news_config_imagesthumb'])) {
			$this->data['error_news_config_imagesthumb'] = $this->error['error_news_config_imagesthumb'];
		} else {
			$this->data['error_news_config_imagesthumb'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		
		$currentversion = $this->config->get('news_version');
		$currentversion = ceil(str_replace('.','',$currentversion));
		$this->version = ceil(str_replace('.','',$this->version));
		if(!empty($currentversion) && ((int)$currentversion) < (int)$this->version){
			$this->data['update'] = $this->url->link('news/setting/update','token=' . $this->session->data['token'] . '&version=' . $this->version, 'SSL');
		}
		if (isset($this->request->post['news_config_datetime'])) {
			$this->data['news_config_datetime'] = $this->request->post['news_config_datetime'];
		} else {
			$this->data['news_config_datetime'] = $this->config->get('news_config_datetime');
		}
		if (isset($this->request->post['news_config_item'])) {
			$this->data['news_config_item'] = $this->request->post['news_config_item'];
		} else {
			$this->data['news_config_item'] = $this->config->get('news_config_item');
		}
		if (isset($this->request->post['news_config_catthumb_w'])) {
			$this->data['news_config_catthumb_w'] = $this->request->post['news_config_catthumb_w'];
		} else {
			$this->data['news_config_catthumb_w'] = $this->config->get('news_config_catthumb_w');
		}
		if (isset($this->request->post['news_config_catthumb_h'])) {
			$this->data['news_config_catthumb_h'] = $this->request->post['news_config_catthumb_h'];
		} else {
			$this->data['news_config_catthumb_h'] = $this->config->get('news_config_catthumb_h');
		}
		if (isset($this->request->post['news_config_desc_limit'])) {
			$this->data['news_config_desc_limit'] = $this->request->post['news_config_desc_limit'];
		} else {
			$this->data['news_config_desc_limit'] = $this->config->get('news_config_desc_limit');
		}
		if (isset($this->request->post['news_config_subcategory'])) {
			$this->data['news_config_subcategory'] = $this->request->post['news_config_subcategory'];
		} else {
			$this->data['news_config_subcategory'] = $this->config->get('news_config_subcategory');
		}
		if (isset($this->request->post['news_config_showdate'])) {
			$this->data['news_config_showdate'] = $this->request->post['news_config_showdate'];
		} else {
			$this->data['news_config_showdate'] = $this->config->get('news_config_showdate');
		}
		if (isset($this->request->post['news_config_showvote'])) {
			$this->data['news_config_showvote'] = $this->request->post['news_config_showvote'];
		} else {
			$this->data['news_config_showvote'] = $this->config->get('news_config_showvote');
		}
		if (isset($this->request->post['news_config_showview'])) {
			$this->data['news_config_showview'] = $this->request->post['news_config_showview'];
		} else {
			$this->data['news_config_showview'] = $this->config->get('news_config_showview');
		}
		
		if (isset($this->request->post['news_config_showcommentcount'])) {
			$this->data['news_config_showcommentcount'] = $this->request->post['news_config_showcommentcount'];
		} else {
			$this->data['news_config_showcommentcount'] = $this->config->get('news_config_showcommentcount');
		}
		if (isset($this->request->post['news_config_showreadmore'])) {
			$this->data['news_config_showreadmore'] = $this->request->post['news_config_showreadmore'];
		} else {
			$this->data['news_config_showreadmore'] = $this->config->get('news_config_showreadmore');
		}
		
		if (isset($this->request->post['news_config_showcatdesc'])) {
			$this->data['news_config_showcatdesc'] = $this->request->post['news_config_showcatdesc'];
		} else {
			$this->data['news_config_showcatdesc'] = $this->config->get('news_config_showcatdesc');
		}
		
		if (isset($this->request->post['news_config_commentperpage'])) {
			$this->data['news_config_commentperpage'] = $this->request->post['news_config_commentperpage'];
		} else {
			$this->data['news_config_commentperpage'] = $this->config->get('news_config_commentperpage');
		}
		
		if (isset($this->request->post['news_config_show_field_title'])) {
			$this->data['news_config_show_field_title'] = $this->request->post['news_config_show_field_title'];
		} else {
			$this->data['news_config_show_field_title'] = $this->config->get('news_config_show_field_title');
		}
		if (isset($this->request->post['news_config_show_field_website'])) {
			$this->data['news_config_show_field_website'] = $this->request->post['news_config_show_field_website'];
		} else {
			$this->data['news_config_show_field_website'] = $this->config->get('news_config_show_field_website');
		}
		
		if (isset($this->request->post['news_config_show_gravatar'])) {
			$this->data['news_config_show_gravatar'] = $this->request->post['news_config_show_gravatar'];
		} else {
			$this->data['news_config_show_gravatar'] = $this->config->get('news_config_show_gravatar');
		}
		
		if (isset($this->request->post['news_config_gravatar_w'])) {
			$this->data['news_config_gravatar_w'] = $this->request->post['news_config_gravatar_w'];
		} else {
			$this->data['news_config_gravatar_w'] = $this->config->get('news_config_gravatar_w');
		}
		if (isset($this->request->post['news_config_gravatar_h'])) {
			$this->data['news_config_gravatar_h'] = $this->request->post['news_config_gravatar_h'];
		} else {
			$this->data['news_config_gravatar_h'] = $this->config->get('news_config_gravatar_h');
		}
		if (isset($this->request->post['news_config_comment_autopublish'])) {
			$this->data['news_config_comment_autopublish'] = $this->request->post['news_config_comment_autopublish'];
		} else {
			$this->data['news_config_comment_autopublish'] = $this->config->get('news_config_comment_autopublish');
		}
		if (isset($this->request->post['news_config_comment_automail'])) {
			$this->data['news_config_comment_automail'] = $this->request->post['news_config_comment_automail'];
		} else {
			$this->data['news_config_comment_automail'] = $this->config->get('news_config_comment_automail');
		}
		if (isset($this->request->post['news_config_article_sharescript'])) {
			$this->data['news_config_article_sharescript'] = $this->request->post['news_config_article_sharescript'];
		} else {
			$this->data['news_config_article_sharescript'] = $this->config->get('news_config_article_sharescript');
		}
		
		//gallery
		if (isset($this->request->post['news_config_gallerytop'])) {
			$this->data['news_config_gallerytop'] = $this->request->post['news_config_gallerytop'];
		} else {
			$this->data['news_config_gallerytop'] = $this->config->get('news_config_gallerytop');
		}
		if (isset($this->request->post['news_config_gallery_order'])) {
			$this->data['news_config_gallery_order'] = $this->request->post['news_config_gallery_order'];
		} else {
			$this->data['news_config_gallery_order'] = $this->config->get('news_config_gallery_order');
		}
		if (isset($this->request->post['news_config_albumsperpage'])) {
			$this->data['news_config_albumsperpage'] = $this->request->post['news_config_albumsperpage'];
		} else {
			$this->data['news_config_albumsperpage'] = $this->config->get('news_config_albumsperpage');
		}
		if (isset($this->request->post['news_config_albumsthumb_w'])) {
			$this->data['news_config_albumsthumb_w'] = $this->request->post['news_config_albumsthumb_w'];
		} else {
			$this->data['news_config_albumsthumb_w'] = $this->config->get('news_config_albumsthumb_w');
		}
		if (isset($this->request->post['news_config_albumsthumb_h'])) {
			$this->data['news_config_albumsthumb_h'] = $this->request->post['news_config_albumsthumb_h'];
		} else {
			$this->data['news_config_albumsthumb_h'] = $this->config->get('news_config_albumsthumb_h');
		}
		if (isset($this->request->post['news_config_imagesperpage'])) {
			$this->data['news_config_imagesperpage'] = $this->request->post['news_config_imagesperpage'];
		} else {
			$this->data['news_config_imagesperpage'] = $this->config->get('news_config_imagesperpage');
		}
		if (isset($this->request->post['news_config_imagesthumb_w'])) {
			$this->data['news_config_imagesthumb_w'] = $this->request->post['news_config_imagesthumb_w'];
		} else {
			$this->data['news_config_imagesthumb_w'] = $this->config->get('news_config_imagesthumb_w');
		}
		if (isset($this->request->post['news_config_imagesthumb_h'])) {
			$this->data['news_config_imagesthumb_h'] = $this->request->post['news_config_imagesthumb_h'];
		} else {
			$this->data['news_config_imagesthumb_h'] = $this->config->get('news_config_imagesthumb_h');
		}
		//gallery theme
		$this->data['themes'] = array('pp_default','light_rounded','dark_rounded','light_square','dark_square','facebook');
		if (isset($this->request->post['news_config_gallerytheme'])) {
			$this->data['news_config_gallerytheme'] = $this->request->post['news_config_gallerytheme'];
		} else {
			$this->data['news_config_gallerytheme'] = $this->config->get('news_config_gallerytheme');
		}
		//gallery option
		if (isset($this->request->post['news_config_gallerysub'])) {
			$this->data['news_config_gallerysub'] = $this->request->post['news_config_gallerysub'];
		} else {
			$this->data['news_config_gallerysub'] = $this->config->get('news_config_gallerysub');
		}
		if (isset($this->request->post['news_config_gallery_count'])) {
			$this->data['news_config_gallery_count'] = $this->request->post['news_config_gallery_count'];
		} else {
			$this->data['news_config_gallery_count'] = $this->config->get('news_config_gallery_count');
		}
		if (isset($this->request->post['news_config_gallery_vote'])) {
			$this->data['news_config_gallery_vote'] = $this->request->post['news_config_gallery_vote'];
		} else {
			$this->data['news_config_gallery_vote'] = $this->config->get('news_config_gallery_vote');
		}
		if (isset($this->request->post['news_config_gallery_creatdate'])) {
			$this->data['news_config_gallery_creatdate'] = $this->request->post['news_config_gallery_creatdate'];
		} else {
			$this->data['news_config_gallery_creatdate'] = $this->config->get('news_config_gallery_creatdate');
		}
		$this->breadcrumbs();
		$this->template = 'news/setting.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	function validate()
	{
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['news_config_item'] || !is_numeric($this->request->post['news_config_item']) || (int)$this->request->post['news_config_item'] < 1) {
			$this->error['error_news_config_item'] = $this->language->get('error_news_config_item');
		}
		if (!$this->request->post['news_config_catthumb_w'] || !is_numeric($this->request->post['news_config_catthumb_w']) || (int)$this->request->post['news_config_catthumb_w'] < 1 || !$this->request->post['news_config_catthumb_h'] || !is_numeric($this->request->post['news_config_catthumb_h']) || (int)$this->request->post['news_config_catthumb_h'] < 1) {
			$this->error['error_news_config_catthumb'] = $this->language->get('error_ news_config_catthumb');
		}
		if (!$this->request->post['news_config_desc_limit'] || !is_numeric($this->request->post['news_config_desc_limit']) || (int)$this->request->post['news_config_desc_limit'] < 1) {
			$this->error['error_news_config_desc_limit'] = $this->language->get('error_news_config_desclimit');
		}
		if (!$this->request->post['news_config_commentperpage'] || (int)$this->request->post['news_config_commentperpage'] < 1) {
			$this->error['error_news_config_comment_perpage'] = $this->language->get('error_news_config_comment_perpage');
		}
		if(((int)$this->request->post['news_config_show_gravatar'] == 1))
		{
			if (!$this->request->post['news_config_gravatar_w'] || !is_numeric($this->request->post['news_config_gravatar_w']) || (int)$this->request->post['news_config_gravatar_w'] < 1 || !$this->request->post['news_config_gravatar_h'] || !is_numeric($this->request->post['news_config_gravatar_h']) || (int)$this->request->post['news_config_gravatar_h'] < 1) {
			$this->error['error_gravatar_thumb'] = $this->language->get('error_gravatar_thumb');
		}
		
		}
		//gallery
		if(((int)$this->request->post['news_config_gallerytop'] == 1))
		{
			if (!$this->request->post['news_config_gallery_order'] || !is_numeric($this->request->post['news_config_gallery_order']) || (int)$this->request->post['news_config_gallery_order'] < 1 ) {
			$this->error['error_news_config_gallery_order'] = $this->language->get('error_news_config_order');
		}
		
		}
		if (!$this->request->post['news_config_albumsperpage'] || (int)$this->request->post['news_config_albumsperpage'] < 1) {
			$this->error['error_news_config_albums_perpage'] = $this->language->get('error_news_config_album');
		}
		if (!$this->request->post['news_config_albumsthumb_w'] || !is_numeric($this->request->post['news_config_albumsthumb_w']) || (int)$this->request->post['news_config_albumsthumb_w'] < 1 || !$this->request->post['news_config_albumsthumb_h'] || !is_numeric($this->request->post['news_config_albumsthumb_h']) || (int)$this->request->post['news_config_albumsthumb_h'] < 1) {
			$this->error['error_news_config_albumsthumb'] = $this->language->get('error_news_config_albumsthumb');
		}
		
		if (!$this->request->post['news_config_imagesperpage'] || (int)$this->request->post['news_config_imagesperpage'] < 1) {
			$this->error['error_news_config_images_perpage'] = $this->language->get('error_news_config_image');
		}
		if (!$this->request->post['news_config_imagesthumb_w'] || !is_numeric($this->request->post['news_config_imagesthumb_w']) || (int)$this->request->post['news_config_imagesthumb_w'] < 1 || !$this->request->post['news_config_imagesthumb_h'] || !is_numeric($this->request->post['news_config_imagesthumb_h']) || (int)$this->request->post['news_config_imagesthumb_h'] < 1) {
			$this->error['error_news_config_imagesthumb'] = $this->language->get('error_news_config_imagesthumb');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function update()
	{
		$newsversion = $this->request->get['version'];
		$this->load->model('news/install');
		if ($this->validateupdate()) {
			
			$this->model_news_install->update($newsversion);
			
			$this->redirect($this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
	}
	function breadcrumbs()//breadcrumbs
	{
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	}
	function validateupdate(){
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>