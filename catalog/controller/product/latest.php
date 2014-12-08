<?php
class ControllerProductLatest extends Controller {
	public function index() {
		$this->language->load('product/latest');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = $this->config->get('config_catalog_limit');
        //$limit = $this->config->get('module_limit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('product/latest', $url),
      		'separator' => $this->language->get('text_separator')
   		);

		$this->data['products'] = array();

		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);

		$product_total = $this->model_catalog_product->getTotalProducts($data);

		$results = $this->model_catalog_product->getProducts($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

				$cut_descr_symbols = 120;
				$descr_plaintext = strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'));
				if( mb_strlen($descr_plaintext, 'UTF-8') > $cut_descr_symbols )
				{
					$descr_plaintext = mb_substr($descr_plaintext, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
				}

                $cut_descr_symbols = 50;
                $name_plaintext    = $result['name'];
          		if( mb_strlen($name_plaintext, 'UTF-8') > $cut_descr_symbols )
          		{
          			$name_plaintext = mb_substr($name_plaintext, 0, $cut_descr_symbols, 'UTF-8') . '&nbsp;&hellip;';
          		}

    			$sales_count = $result['sales_count'];
    			$status_hit = $result['status_hit'];
	    		$status_new = $result['status_new'];

                if ($sales_count >= (int)$this->config->get('config_hit_status_limit')) {
                    $status_new = 0;
                    $status_hit = 1;
                }
                if ($status_new) {
                    $status_hit = 0;
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
    			'status_hit'  => $status_hit,
    			'status_new'  => $status_new,
				'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	  => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}

    	$url = '';

    	if (isset($this->request->get['sort'])) {
    		$url .= '&sort=' . $this->request->get['sort'];
    	}

    	if (isset($this->request->get['order'])) {
    		$url .= '&order=' . $this->request->get['order'];
    	}

    	if (isset($this->request->get['limit'])) {
    		$url .= '&limit=' . $this->request->get['limit'];
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

    	$pagination->url = $this->url->link('product/latest', $url . '&page={page}');

    	$this->data['pagination'] = $pagination->render();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/latest.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/latest.tpl';
		} else {
			$this->template = 'default/template/product/latest.tpl';
		}

      	$this->children = array(
      		'common/column_left',
      		'common/column_right',
			'common/column_center',
      		'common/content_top',
      		'common/content_bottom',
      		'common/footer',
      		'common/header'
      	);

      	$this->response->setOutput($this->render());
	}
}
?>