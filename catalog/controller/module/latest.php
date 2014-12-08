<?php
class ControllerModuleLatest extends Controller {
	protected function index($setting) {
		$this->language->load('module/latest');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['text_prompt'] = $this->language->get('text_prompt');

		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		//$limit = $this->config->get('config_catalog_limit');
        $limit = $setting['limit'];

		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			//'start' => 0,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);

		$product_total = $this->model_catalog_product->getTotalProducts($data);

		$results = $this->model_catalog_product->getProducts($data);

		$this->data['products'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}

      		$cut_descr_symbols = 70;
      		$descr_plaintext = strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
      		if( mb_strlen($descr_plaintext, 'UTF-8') > $cut_descr_symbols )
      		{
      			$descr_plaintext = mb_substr($descr_plaintext, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
      		}

            $cut_descr_symbols = 20;
            $name_plaintext    = $result['name'];
      		if( mb_strlen($name_plaintext, 'UTF-8') > $cut_descr_symbols )
      		{
      			$name_plaintext = mb_substr($name_plaintext, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
      		}
			$this->data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'   	  => $image,
				'name'    	  => $name_plaintext,
				'title'    	  => $result['name'],
				'description' => $descr_plaintext,
				'price'   	  => $price,
				'special' 	  => $special,
				'rating'      => $rating,
				'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	  => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}

    	$pagination = new Pagination();
    	$pagination->total          = $product_total;
    	$pagination->page           = $page;
    	$pagination->limit          = $limit;
    	$pagination->text           = $this->language->get('text_total_page');
        $pagination->style_links    = '';
        $pagination->style_results  = '';
        $pagination->text_first     = $this->language->get('text_first');
        $pagination->text_last      = $this->language->get('text_last');
        $pagination->text_next      = $this->language->get('text_next');
        $pagination->text_prev      = $this->language->get('text_prev');

    	$pagination->url = $this->url->link('common/home', '&page={page}');

    	$this->data['pagination'] = $pagination->render();
	    $this->data['continue']   = $this->url->link('product/latest');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/latest.tpl';
		} else {
			$this->template = 'default/template/module/latest.tpl';
		}

		$this->render();
	}
}
?>