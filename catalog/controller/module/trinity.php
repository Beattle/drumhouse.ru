<?php
class ControllerModuleTrinity extends Controller {
	protected function index($setting) {
		$this->language->load('module/trinity');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_cart']   = $this->language->get('button_cart');
		$this->data['text_prompt_1'] = $this->language->get('text_prompt_1');
		$this->data['text_prompt_2'] = $this->language->get('text_prompt_2');
		$this->data['text_prompt_3'] = $this->language->get('text_prompt_3');
		$this->data['text_empty']    = $this->language->get('text_empty');

        $this->data['tab_title_1']   = $this->config->get('trinity_tab_title_1');
        $this->data['tab_title_2']   = $this->config->get('trinity_tab_title_2');
        $this->data['tab_title_3']   = $this->config->get('trinity_tab_title_3');

	    $this->data['continue_1']    = $this->url->link('product/bestseller');
	    $this->data['continue_2']    = $this->url->link('product/latest');
	    $this->data['continue_3']    = $this->url->link('product/special');

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

        //----------------------------------------------------------------------
		$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);
		$this->data['products_bestseller'] = array();
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);

                // check existing file
                if (!file_exists(DIR_IMAGE . $result['image'])) {
   			        $image = $this->model_tool_image->resize('not_found.jpg', $setting['image_width'], $setting['image_height']);
                }

  			} else {
   		        $image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
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



            if ($result['quantity'] <= 0) {
                $stock = $result['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $stock = $result['quantity'];
            } else {
                $stock = $this->language->get('text_instock');
            }
			$this->data['products_bestseller'][] = array(
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
                'stock'       => $stock
			);
		}
        //----------------------------------------------------------------------
        //----------------------------------------------------------------------
		//$data = array(
		//	'sort'  => 'p.date_added',
		//	'order' => 'DESC',
		//	'start' => 0,
		//	'limit' => $setting['limit']
		//);

		$results = $this->model_catalog_product->getLatestProducts($setting['limit']);
		$this->data['products_latest'] = array();
        if ($results) {
    		foreach ($results as $result) {
    			if ($result['image']) {
    				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);

                    // check existing file
                    if (!file_exists(DIR_IMAGE . $result['image'])) {
	    			    $image = $this->model_tool_image->resize('not_found.jpg', $setting['image_width'], $setting['image_height']);
                    }

    			} else {
	    		    $image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
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

                if ($result['quantity'] <= 0) {
                    $stock = $result['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $stock = $result['quantity'];
                } else {
                    $stock = $this->language->get('text_instock');
                }

    			$this->data['products_latest'][] = array(
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
                    'stock'       => $stock
    			);
    		}
        }
        //----------------------------------------------------------------------
        //----------------------------------------------------------------------
		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProductSpecials($data);
		$this->data['products_special'] = array();
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);

                // check existing file
                if (!file_exists(DIR_IMAGE . $result['image'])) {
   			        $image = $this->model_tool_image->resize('not_found.jpg', $setting['image_width'], $setting['image_height']);
                }

  			} else {
   		        $image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
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
            if ($result['quantity'] <= 0) {
                $stock = $result['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $stock = $result['quantity'];
            } else {
                $stock = $this->language->get('text_instock');
            }
			$this->data['products_special'][] = array(
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
                'stock'       => $stock
			);
		}
        //----------------------------------------------------------------------


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/trinity.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/trinity.tpl';
		} else {
			$this->template = 'default/template/module/trinity.tpl';
		}

		$this->render();
	}
}
?>