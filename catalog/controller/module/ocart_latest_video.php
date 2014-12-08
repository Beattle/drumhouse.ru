<?php
class ControllerModuleOcartlatestvideo extends Controller {
	protected function index($setting) {
		$this->language->load('module/ocart_latest_video');
		
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/ocart_video_gallery.css');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['youtube_extension'] = $this->language->get('youtube_extension');

		$this->load->model('video/video');
		$this->load->model('tool/image');

        $this->data['videos_href'] = $this->url->link('video/category');

		$this->data['videos'] = array();

		$limit = $setting['limit'];
		
		$results = $this->model_video_video->getLatestVideos($limit);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 176 , 100 );
			} else {
				$image = false;
			}
			
			$this->data['videos'][] = array(
				'product_id' => $result['video_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'link'    	 => $result['link'],
				'vcat_name'  => $result['vcat_name'],
				'vcat_href'  => $this->url->link('video/category', 'vcatid=' . $result['vcat_id']),
				'href'    	 => $this->url->link('video/video', 'vcatid=' . $result['vcat_id'] . '&video_id=' . $result['video_id']),
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ocart_latest_video.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ocart_latest_video.tpl';
		} else {
			$this->template = 'default/template/module/ocart_latest_video.tpl';
		}

		$this->render();
	}
}
?>