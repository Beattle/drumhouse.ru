<?php
class ControllerPaymentPaymentSchet extends Controller {
	protected function index() {
		$this->language->load('payment/payment_schet');

		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_instruction_2'] = str_replace('{server}', HTTPS_SERVER, $this->language->get('text_instruction_2'));
		$this->data['text_instruction_3'] = $this->language->get('text_instruction_3');
		$this->data['text_payment'] = $this->language->get('text_payment');
         $this->data['text_printpay'] = $this->language->get('text_printpay');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['bank'] = nl2br($this->config->get('payment_schet_bank_' . $this->config->get('config_language_id')));

		$this->data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payment_schet.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/payment_schet.tpl';
		} else {
			$this->template = 'default/template/payment/payment_schet.tpl';
		}

		$this->render();
		
		
	}


    public function printpay() {

	$this->load->model('checkout/order');

		$this->language->load('payment/payment_schet');

		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_payment'] = $this->language->get('text_payment');

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['bank'] = nl2br($this->config->get('payment_schet_bank_' . $this->config->get('config_language_id')));
		$this->data['faktadres'] = nl2br($this->config->get('payment_schet_faktadres_' . $this->config->get('config_language_id')));
		$this->data['uradres'] = nl2br($this->config->get('payment_schet_uradres_' . $this->config->get('config_language_id')));
		$this->data['kpp'] = nl2br($this->config->get('payment_schet_kpp_' . $this->config->get('config_language_id')));
		$this->data['inn'] = nl2br($this->config->get('payment_schet_inn_' . $this->config->get('config_language_id')));
		$this->data['rs'] = nl2br($this->config->get('payment_schet_rs_' . $this->config->get('config_language_id')));
		$this->data['bankuser'] = nl2br($this->config->get('payment_schet_bankuser_' . $this->config->get('config_language_id')));
		$this->data['bik'] = nl2br($this->config->get('payment_schet_bik_' . $this->config->get('config_language_id')));
		$this->data['ks'] = nl2br($this->config->get('payment_schet_ks_' . $this->config->get('config_language_id')));
		$this->data['tel'] = nl2br($this->config->get('payment_schet_tel_' . $this->config->get('config_language_id')));
		$this->data['mobtel'] = nl2br($this->config->get('payment_schet_mobtel_' . $this->config->get('config_language_id')));
		$this->data['punkt'] = nl2br($this->config->get('payment_schet_punkt_' . $this->config->get('config_language_id')));
		$this->data['images'] = nl2br($this->config->get('payment_schet_image' . $this->config->get('config_language_id')));
		$this->data['podpis'] = nl2br($this->config->get('payment_schet_podpis' . $this->config->get('config_language_id')));



		$this->load->model('account/order');
		$this->load->model('tool/suminwords');

		if (isset($this->request->get['order_id'])) {

		$this->document->breadcrumbs = array();
		$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=payment/payment_schet/printpay&order_id=' . $this->request->get['order_id'],
        	'text'      => $this->language->get('text_invoice'),
        	'separator' => $this->language->get('text_separator')
      										);

			$order_id = $this->request->get['order_id'];

		} else {

			$order_id = '';

		}

		if ($order_id == ''){
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		}else{
		$order_info = $this->model_account_order->getOrder($order_id);
		}

		$rur_code = 'RUB';
		$rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $rur_code);
		$this->data['amount'] = $this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE);
		$this->data['price'] = $this->model_tool_suminwords->num2str($this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE));
		$this->data['order_id'] = $order_info['order_id'];
		$this->data['name'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
		$this->data['dates'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

		if (!$order_info['payment_address_2']) {
			$this->data['address'] = $order_info['payment_zone'] . ', ' . $order_info['payment_city'] . ', ' .$order_info['payment_address_1'] ;
		} else {
			$this->data['address'] = $order_info['payment_zone'] . ', ' . $order_info['payment_address_2'] . ', ' . $order_info['payment_city'] . ', ' .$order_info['payment_address_1'] ;
		}

		$this->data['postcode'] = $order_info['payment_postcode'];
		
		
		if ($this->config->get('config_punkton')) {
				$this->data['punkt'] = $this->data['punkt'];
			} else {
				$this->data['punkt'] = false;
			}		
		if ($this->config->get('config_punkton')) {
				$this->data['schet'] = 'Счет-Договор';
			} else {
				$this->data['schet'] = 'Счет';
			}	
		
			$this->data['column_name'] = $this->language->get('column_name');
			$this->data['column_model'] = $this->language->get('column_model');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_price'] = $this->language->get('column_price');
			$this->data['column_total'] = $this->language->get('column_total');
	
			$this->data['products'] = array();
	
			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();
	
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($option['option_value']) > 20 ? substr($option['option_value'], 0, 20) . '..' : $option['option_value'])
						);
					} else {
						$this->load->library('encryption');
						
						$encryption = new Encryption($this->config->get('config_encryption'));
						
						$file = substr($encryption->decrypt($option['option_value']), 0, strrpos($encryption->decrypt($option['option_value']), '.'));
						
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (strlen($file) > 20 ? substr($file, 0, 20) . '..' : $file)
						);												
					}
				}  
	 
				$this->data['products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'tax'        => $this->tax->getTax($product['total'], $product['tax_class_id']),
					'price'      => $this->currency->format($product['price']),
					'total'      => $this->currency->format($product['total']),
					'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
					
				); 
			}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payment_schet.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/payment_schet_printpay.tpl';
		} else {
			$this->template = 'default/template/payment/payment_schet_printpay.tpl';
		}

	$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));

	
	
	}


	public function confirm() {
		$this->language->load('payment/payment_schet');

        $this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$comment  = $this->language->get('text_instruction') . "\n\n";

		/*$comment .= $this->config->get('fl_sberbank_bank_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_sberbank_inn_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_sberbank_rs_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_sberbank_bankuser_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_sberbank_bik_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= $this->config->get('fl_sberbank_ks_' . $this->config->get('config_language_id')) . "\n\n";*/
		$comment .= str_replace('{server}', HTTPS_SERVER, $this->language->get('text_instruction_2')) . $this->data['order_id'] = $order_info['order_id'] .  $this->language->get('text_instruction_3') . "\n\n";
		$comment .= $this->language->get('text_payment');





		$comment  = $this->language->get('text_instruction') . "\n\n";

		$comment .= str_replace('{server}', HTTPS_SERVER, $this->language->get('text_instruction_2')) . $this->data['order_id'] = $order_info['order_id'] .  $this->language->get('text_instruction_3') . "\n\n";
		$comment .= $this->language->get('text_payment_coment');

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('payment_schet_order_status_id'), $comment);
	}
	
	
}


?>