<?php
class ControllerModuleCart extends Controller {
	protected function index() {
		$this->language->load('module/cart');
				
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_subtotal'] = $this->language->get('text_subtotal');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_remove'] = $this->language->get('text_remove');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		$this->data['button_checkout'] = $this->language->get('button_checkout');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->data['cart'] = $this->url->link('checkout/cart');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		
		// Get Cart Products
		$this->data['products'] = array();
		
		foreach ($this->cart->getProducts() as $result) {

			$option_data = array();

			foreach ($result['option'] as $option) {
				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (strlen($option['option_value']) > 20 ? substr($option['option_value'], 0, 20) . '..' : $option['option_value'])
				);
			}
				
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$total = false;
			}
				
			$this->data['products'][] = array(
				'key'      => $result['key'],
				'thumb'    => false,
				'name'     => mb_strtoupper($result['name'], 'UTF-8'), //$result['name'],
				'model'    => $result['model'],
				'option'   => $option_data,
				'quantity' => $result['quantity'],
				'stock'    => $result['stock'],
				'price'    => $price,
				'total'    => $total,
				'href'     => $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
		}
		
		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}
		
		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
		
    	// Calculate Totals
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$this->load->model('setting/extension');
			
			$sort_order = array();
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
		}
		
		$sort_order = array();
	  
		foreach ($total_data as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
			// removing total then loading module
			if($value['code'] !== 'sub_total')
				unset($total_data[$key]);
    	}

    	array_multisort($sort_order, SORT_ASC, $total_data);
		
    	$this->data['totals'] = $total_data;
		
		$this->data['ajax'] = $this->config->get('cart_ajax');
		
		$this->id = 'cart';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart.tpl';
		} else {
			$this->template = 'default/template/module/cart.tpl';
		}
		
		$this->render();
	}
		
	public function callback() {
		$this->language->load('module/cart');

		$this->load->model('tool/seo_url');
		
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['shipping_method']);
		unset($this->session->data['payment_methods']);
		unset($this->session->data['payment_method']);
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			if (isset($this->request->post['remove'])) {
	    		$result = explode('_', $this->request->post['remove']);
          		$this->cart->remove(trim($result[1]));
      		} else {
				if (isset($this->request->post['option'])) {
					$option = $this->request->post['option'];
				} else {
					$option = array();
				}
				
      			$this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
			}
		}
				
		$output = '';
		
		if ($this->cart->getProducts()) {

    		foreach ($this->cart->getProducts() as $product) {
          	    $output .= '<table class="t-basket">';
      			$output .= '<tr>';
				$output .= '<td widht="20px"><i class="del" onclick="removeCart(\'' . $product['key'] . '\');"></i></td>';
				$output .= '<td widht="20px">x&nbsp;' . $product['quantity'] . '</td>';
        		$output .= '<td><a href="' . $product['href'] . '">' . $product['name'] . ' </a>';
		        $output .= '<div>';
		        foreach ($product['option'] as $option) {
		            $output .= '- <small style="color: #999;">' . $option['name'] . ' ' . $option['value'] . '</small><br />';
		        }
		        $output .= '</div>';
                $output .= '</td>';
        		$output .= '<td class="td1">' . $product['total'] . '</td>';
				$output .= '</tr>';
			    $output .= '</table>';


        		$output .= '<td width="1" valign="top" align="left"><span class="cart_remove" id="remove_ ' . $product['key'] . '" />&nbsp;</span></td>';
                $output .= '<td width="1" valign="top" align="right">' . $product['quantity'] . '&nbsp;x&nbsp;</td>';
        		$output .= '<td align="left" valign="top"><a href="' . $this->url->link('product/product', 'product_id=' . $result['product_id']) . '">' . $product['name'] . '</a>';
          		$output .= '<div>';
      		}

    		$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('checkout/extension');
			
			$sort_order = array(); 
			
			$view = HTTP_SERVER . 'index.php?route=checkout/cart';
			$checkout = HTTPS_SERVER . 'index.php?route=checkout/shipping';
			
			$results = $this->model_checkout_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				$this->load->model('total/' . $result['key']);

				$this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
			}
			
			$sort_order = array(); 
		  
			foreach ($total_data as $key => $value) {
      			$sort_order[$key] = $value['sort_order'];
    		}

    		array_multisort($sort_order, SORT_ASC, $total_data);
    	    		
    		$output .= '<div class="linebreak"></div>';
    		$output .= '<table cellpadding="0" cellspacing="0" class="price_tab">';
      		foreach ($total_data as $total) {				
      			$output .= '<tr>';
		        $output .= '<td align="right"><span class="cart_module_total"><b>' . $total['title'] . '</b></span></td>';
		        $output .= '<td align="right"><span class="cart_module_total">' . $total['text'] . '</span></td>';
      			$output .= '</tr>';
      		}
      		$output .= '</table>';
		} else {
			$output .= '<div style="text-align: center;">' . $this->language->get('text_empty') . '</div>';
		}
		
		$this->response->setOutput($output, $this->config->get('config_compression'));
	} 	
}
?>