<?php 
class ModelPaymentQiwiSimple extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('payment/qiwi_simple');
		
		if ($total > 0) {
			$status = true;
		} else {
			$status = false;
		}
		
		$method_data = array();
			
		if ($status) {  
			$method_data = array( 
				'code'       => 'qiwi_simple',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('qiwi_simple_sort_order')
			);
		}
		
    	return $method_data;
  	}
}
?>