<?php
class ControllerNewsGallery extends Controller{

	public function index(){
		$this->language->load('news/gallery');
		$this->load->model('news/gallery');
		$this->load->model('tool/image');
		
		
		if(isset($this->request->get['album_id'])){
			$album_id = $this->request->get['album_id'];
		}else{
			$album_id = false;
		}
								
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);
		
		if($album_id){
			$this->GetAlbum($album_id);
		}
		else{
			$this->Getallalbum();
		}
		
	}
	private function iserror(){
		$url = '';
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('news/gallery', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');
			$this->data['continue'] = $this->url->link('common/home');
			$this->data['text_error'] = $this->language->get('text_error');
			$this->data['button_continue'] = $this->language->get('button_continue');
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
			$this->response->setOutput($this->render());
	}
	private function Getallalbum(){
		//get page
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
		//get limit
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('news_config_albumsperpage');
		}
		$data = array(
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit,
			'sort'               => 'ga.news_gallery_album_date_added',
			'order'              => 'DESC'
		);
		$results = $this->model_news_gallery->getAllAlbum($data);
		if($results){
			$this->data['albums'] = array();
			$total_album = $this->model_news_gallery->getTotalAlbums();
			
			$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_gallery'),
			'href'      => $this->url->link('news/gallery'),
       		'separator' => $this->language->get('text_separator')
   			);	
			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->document->setTitle($this->language->get('heading_title'));
			foreach($results as $result){
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('news_config_albumsthumb_w'), $this->config->get('news_config_albumsthumb_h'));
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('news_config_albumsthumb_w'), $this->config->get('news_config_albumsthumb_h'));;
				}
				$this->data['albums'][] = array(
					'album_id' => $result['albums_id'],
					'thumb'    => $image,
					'href'     => $this->url->link('news/gallery','album_id='.$result['albums_id']),
					'album_name' => html_entity_decode($result['albums_name']),
					'album_desc' => html_entity_decode($result['albums_desc']),
					'album_date' => $this->language->get('text_created').date($this->config->get('news_config_datetime'), strtotime($result['albums_adddate'])),
					'album_imgcount' => sprintf($this->language->get('text_countimg'),$result['albums_imgcount']),
					'album_numvote' => (int)$result['albums_vote'],
					'album_vote' =>sprintf($this->language->get('text_total_vote'),$result['albums_vote'])
				);
			}
			
			$pagination = new Pagination();
			$pagination->total = (int)$total_album;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/gallery','&page={page}');
		
			$this->data['pagination'] = $pagination->render();
			
			
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/gallery.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/gallery.tpl';
			} else {
				$this->template = 'default/template/news/gallery.tpl';
			}
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
				
			$this->response->setOutput($this->render());
		}
		else{
			$this->iserror();
		}
	}

	private function GetAlbum($album_id){
		//get page
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
		//get limit
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('news_config_imagesperpage');
		}
		
		
		$album_info	= $this->model_news_gallery->getAlbumsinfo($album_id);
		if($album_info){
			$this->data['heading_title'] = $album_info['news_gallery_album_name'];
			$this->document->setTitle($album_info['news_gallery_album_name']);
			$this->document->setDescription($album_info['news_gallery_album_meta_description']);
			$this->document->setKeywords($album_info['news_gallery_album_meta_keyword']);
			$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_gallery'),
			'href'      => $this->url->link('news/gallery'),
       		'separator' => $this->language->get('text_separator')
   			);	
	       	$this->data['breadcrumbs'][] = array(
   	    		'text'      => $album_info['news_gallery_album_name'],
				'href'      => $this->url->link('news/gallery', 'album_id=' . $album_id),
        		'separator' => $this->language->get('text_separator')
        	);
			$total_image = $this->model_news_gallery->countImages($album_info['news_gallery_album_id']);
			$data = array(
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit,
			'sort'               => 'ga.news_gallery_added',
			'order'              => 'DESC'
		);
			
			$results = $this->model_news_gallery->getImageAlbum($data,$album_info['news_gallery_album_id']);
			
			if($results){
			
				foreach($results as $result){
					if ($result['news_gallery_image']) {
					$image = $this->model_tool_image->resize($result['news_gallery_image'], $this->config->get('news_config_imagesthumb_w'), $this->config->get('news_config_imagesthumb_h'));
					$popup = HTTP_IMAGE.$result['news_gallery_image'];
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('news_config_imagesthumb_w'), $this->config->get('news_config_imagesthumb_h'));
					$popup = $image;
				}
				
					$this->data['images'][] = array(
						'thumb' => $image,
						'popup' => $popup,
						'image_id' => $result['news_gallery_id'],
						'image_name' => html_entity_decode($result['news_gallery_titles']),
						'image_desc' => html_entity_decode($result['news_gallery_description']),
						'image_view' => sprintf($this->language->get('text_viewed'),$result['news_gallery_viewed']),
						'image_date' => $this->language->get('text_created').date($this->config->get('news_config_datetime'), strtotime($result['news_gallery_added'])),
						'image_numvote' => (int)$result['news_gallery_vote'],
						'image_vote' => sprintf($this->language->get('text_vote'),$result['news_gallery_vote']),
						'image_showdate' => $result['news_gallery_showdate'],
						'image_showvote' => $result['news_gallery_showvote'],
						'image_showview' => $result['news_gallery_showviewed']
					);
				}
				
			$pagination = new Pagination();
			$pagination->total = (int)$total_image['total'];
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/gallery','&album_id='.(int)$album_id.'&page={page}');
		
			$this->data['pagination'] = $pagination->render();
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/album.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/album.tpl';
			} else {
				$this->template = 'default/template/news/album.tpl';
			}
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
				
			$this->response->setOutput($this->render());
			}else{
				$this->iserror();
			}
			
		}else{
			$this->iserror();
		}
	}

	public function vote(){
		$this->language->load('news/gallery');
		$this->load->model('news/gallery');
		$json = array();
		if(!(int)$this->request->post['image_id'])
		{
			$json['error'] = $this->language->get('text_voteerror');
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$this->model_news_gallery->updateVote($this->request->get['image_id']);
			
			$json['success'] = $this->language->get('text_success');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	public function view(){
		$this->load->model('news/gallery');
		if(!(int)$this->request->post['image_id'])
		{
			$json['error'] = $this->language->get('text_voteerror');
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$this->model_news_gallery->updateView($this->request->get['image_id']);
			
			$json['success'] = $this->language->get('text_success');
		}
	}
}
?>