<?php
class ModelShippingCourierUaAutolux extends Model {
	function getQuote($address) {
		if(version_compare(VERSION, '1.5.5', '>='))
		{
			$this->language->load('shipping/courier_ua_autolux');
		} else {
			$this->load->language('shipping/courier_ua_autolux');
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('courier_ua_autolux_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('courier_ua_autolux_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

      		$quote_data['courier_ua_autolux'] = array(
        		'code'         => 'courier_ua_autolux.courier_ua_autolux',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => 0.00,
        		'tax_class_id' => 0,
				'text'         => $this->language->get('text_price')
      		);

      		$method_data = array(
        		'code'       => 'courier_ua_autolux',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('courier_ua_autolux_sort_order'),
        		'error'      => false
      		);
		}

		return $method_data;
	}
}
?>