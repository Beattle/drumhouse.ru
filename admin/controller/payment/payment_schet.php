<?php
class ControllerPaymentPaymentSchet extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/payment_schet');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_schet', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['token'] = $this->session->data['token'];
		
        $this->data['entry_inn'] = $this->language->get('entry_inn');
		$this->data['entry_kpp'] = $this->language->get('entry_kpp');
        $this->data['entry_rs'] = $this->language->get('entry_rs');
		$this->data['entry_bankuser'] = $this->language->get('entry_bankuser');
		$this->data['entry_bik'] = $this->language->get('entry_bik');
		$this->data['entry_ks'] = $this->language->get('entry_ks');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_podpis'] = $this->language->get('entry_podpis');		

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_bank'] = $this->language->get('entry_bank');
		$this->data['entry_uradres'] = $this->language->get('entry_uradres');
		$this->data['entry_faktadres'] = $this->language->get('entry_faktadres');	
		$this->data['entry_tel'] = $this->language->get('entry_tel');
		$this->data['entry_mobtel'] = $this->language->get('entry_mobtel');
		$this->data['entry_punkt'] = $this->language->get('entry_punkt');
		$this->data['entry_punkton'] = $this->language->get('entry_punkton');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		


		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->error['bank_' . $language['language_id']])) {
				$this->data['error_bank_' . $language['language_id']] = $this->error['bank_' . $language['language_id']];
			} else {
				$this->data['error_bank_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['uradres_' . $language['language_id']])) {
				$this->data['error_uradres_' . $language['language_id']] = $this->error['uradres_' . $language['language_id']];
			} else {
				$this->data['error_uradres_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['faktadres_' . $language['language_id']])) {
				$this->data['error_faktadres_' . $language['language_id']] = $this->error['faktadres_' . $language['language_id']];
			} else {
				$this->data['error_faktadres_' . $language['language_id']] = '';
			}

			if (isset($this->error['inn_' . $language['language_id']])) {
				$this->data['error_inn_' . $language['language_id']] = $this->error['inn_' . $language['language_id']];
			} else {
				$this->data['error_inn_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['kpp_' . $language['language_id']])) {
				$this->data['error_kpp_' . $language['language_id']] = $this->error['kpp_' . $language['language_id']];
			} else {
				$this->data['error_kpp_' . $language['language_id']] = '';
			}

			if (isset($this->error['rs_' . $language['language_id']])) {
				$this->data['error_rs_' . $language['language_id']] = $this->error['rs_' . $language['language_id']];
			} else {
				$this->data['error_rs_' . $language['language_id']] = '';
			}

			if (isset($this->error['bankuser_' . $language['language_id']])) {
				$this->data['error_bankuser_' . $language['language_id']] = $this->error['bankuser_' . $language['language_id']];
			} else {
				$this->data['error_bankuser_' . $language['language_id']] = '';
			}

			if (isset($this->error['bik_' . $language['language_id']])) {
				$this->data['error_bik_' . $language['language_id']] = $this->error['bik_' . $language['language_id']];
			} else {
				$this->data['error_bik_' . $language['language_id']] = '';
			}

			if (isset($this->error['ks_' . $language['language_id']])) {
				$this->data['error_ks_' . $language['language_id']] = $this->error['ks_' . $language['language_id']];
			} else {
				$this->data['error_ks_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['tel_' . $language['language_id']])) {
				$this->data['error_tel_' . $language['language_id']] = $this->error['tel_' . $language['language_id']];
			} else {
				$this->data['error_tel_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['mobtel_' . $language['language_id']])) {
				$this->data['error_mobtel_' . $language['language_id']] = $this->error['mobtel_' . $language['language_id']];
			} else {
				$this->data['error_mobtel_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['punkt_' . $language['language_id']])) {
				$this->data['error_punkt_' . $language['language_id']] = $this->error['punkt_' . $language['language_id']];
			} else {
				$this->data['error_punkt_' . $language['language_id']] = '';
			}
			
			if (isset($this->error['punkton_' . $language['language_id']])) {
				$this->data['error_punkton_' . $language['language_id']] = $this->error['punkton_' . $language['language_id']];
			} else {
				$this->data['error_punkton_' . $language['language_id']] = '';
			}
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/payment_schet', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/payment_schet', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		
		

         foreach ($languages as $language) {

			//Наименование поставщика
			if (isset($this->request->post['payment_schet_bank_' . $language['language_id']])) {
				$this->data['payment_schet_bank_' . $language['language_id']] = $this->request->post['payment_schet_bank_' . $language['language_id']];
			} else {
				$this->data['payment_schet_bank_' . $language['language_id']] = $this->config->get('payment_schet_bank_' . $language['language_id']);
				}
			//Юридический адрес поставщика
			if (isset($this->request->post['payment_schet_uradres_' . $language['language_id']])) {
				$this->data['payment_schet_uradres_' . $language['language_id']] = $this->request->post['payment_schet_uradres_' . $language['language_id']];
			} else {
				$this->data['payment_schet_uradres_' . $language['language_id']] = $this->config->get('payment_schet_uradres_' . $language['language_id']);
				}
			//Фактический адрес поставщика
			if (isset($this->request->post['payment_schet_faktadres_' . $language['language_id']])) {
				$this->data['payment_schet_faktadres_' . $language['language_id']] = $this->request->post['payment_schet_faktadres_' . $language['language_id']];
			} else {
				$this->data['payment_schet_faktadres_' . $language['language_id']] = $this->config->get('payment_schet_faktadres_' . $language['language_id']);
				}
			//ИНН
			if (isset($this->request->post['payment_schet_inn_' . $language['language_id']])) {
				$this->data['payment_schet_inn_' . $language['language_id']] = $this->request->post['payment_schet_inn_' . $language['language_id']];
			} else {
				$this->data['payment_schet_inn_' . $language['language_id']] = $this->config->get('payment_schet_inn_' . $language['language_id']);
			}
			//КПП
			if (isset($this->request->post['payment_schet_kpp_' . $language['language_id']])) {
				$this->data['payment_schet_kpp_' . $language['language_id']] = $this->request->post['payment_schet_kpp_' . $language['language_id']];
			} else {
				$this->data['payment_schet_kpp_' . $language['language_id']] = $this->config->get('payment_schet_kpp_' . $language['language_id']);
			}
			//Расчетный счет
			if (isset($this->request->post['payment_schet_rs_' . $language['language_id']])) {
				$this->data['payment_schet_rs_' . $language['language_id']] = $this->request->post['payment_schet_rs_' . $language['language_id']];
			} else {
				$this->data['payment_schet_rs_' . $language['language_id']] = $this->config->get('payment_schet_rs_' . $language['language_id']);
			}
			//Наименование банка получателя платежа
			if (isset($this->request->post['payment_schet_bankuser_' . $language['language_id']])) {
				$this->data['payment_schet_bankuser_' . $language['language_id']] = $this->request->post['payment_schet_bankuser_' . $language['language_id']];
			} else {
				$this->data['payment_schet_bankuser_' . $language['language_id']] = $this->config->get('payment_schet_bankuser_' . $language['language_id']);
			}
			//БИК
			if (isset($this->request->post['payment_schet_bik_' . $language['language_id']])) {
				$this->data['payment_schet_bik_' . $language['language_id']] = $this->request->post['payment_schet_bik_' . $language['language_id']];
			} else {
				$this->data['payment_schet_bik_' . $language['language_id']] = $this->config->get('payment_schet_bik_' . $language['language_id']);
			}
			//Номер кор./сч. банка получателя платежа
			if (isset($this->request->post['payment_schet_ks_' . $language['language_id']])) {
				$this->data['payment_schet_ks_' . $language['language_id']] = $this->request->post['payment_schet_ks_' . $language['language_id']];
			} else {
				$this->data['payment_schet_ks_' . $language['language_id']] = $this->config->get('payment_schet_ks_' . $language['language_id']);
			}
			//Телефон / факс поставщика
			if (isset($this->request->post['payment_schet_tel_' . $language['language_id']])) {
				$this->data['payment_schet_tel_' . $language['language_id']] = $this->request->post['payment_schet_tel_' . $language['language_id']];
			} else {
				$this->data['payment_schet_tel_' . $language['language_id']] = $this->config->get('payment_schet_tel_' . $language['language_id']);
			}
			//Мобильный телефон поставщика
			if (isset($this->request->post['payment_schet_mobtel_' . $language['language_id']])) {
				$this->data['payment_schet_mobtel_' . $language['language_id']] = $this->request->post['payment_schet_mobtel_' . $language['language_id']];
			} else {
				$this->data['payment_schet_mobtel_' . $language['language_id']] = $this->config->get('payment_schet_mobtel_' . $language['language_id']);
			}
			//Пункты договора
			if (isset($this->request->post['payment_schet_punkt_' . $language['language_id']])) {
				$this->data['payment_schet_punkt_' . $language['language_id']] = $this->request->post['payment_schet_punkt_' . $language['language_id']];
			} else {
				$this->data['payment_schet_punkt_' . $language['language_id']] = $this->config->get('payment_schet_punkt_' . $language['language_id']);
			}
			
			if (isset($this->request->post['config_punkton'])) {
			$this->data['config_punkton'] = $this->request->post['config_punkton'];
			} else {
				$this->data['config_punkton'] = $this->config->get('config_punkton');
			}	

			if (isset($this->request->post['payment_schet_image' . $language['language_id']])) {
				$this->data['payment_schet_image' . $language['language_id']] = $this->request->post['payment_schet_image' . $language['language_id']];
			} else {
				$this->data['payment_schet_image' . $language['language_id']] = $this->config->get('payment_schet_image' . $language['language_id']);
			}
						
			if (isset($this->request->post['payment_schet_podpis' . $language['language_id']])) {
				$this->data['payment_schet_podpis' . $language['language_id']] = $this->request->post['payment_schet_podpis' . $language['language_id']];
			} else {
				$this->data['payment_schet_podpis' . $language['language_id']] = $this->config->get('payment_schet_podpis' . $language['language_id']);
			}
			
			}
		

		$this->load->model('localisation/language');

		foreach ($languages as $language) {
			if (isset($this->request->post['payment_schet_bank_' . $language['language_id']])) {
				$this->data['payment_schet_bank_' . $language['language_id']] = $this->request->post['payment_schet_bank_' . $language['language_id']];
			} else {
				$this->data['payment_schet_bank_' . $language['language_id']] = $this->config->get('payment_schet_bank_' . $language['language_id']);
			}
		}

		$this->data['languages'] = $languages;

		if (isset($this->request->post['payment_schet_total'])) {
			$this->data['payment_schet_total'] = $this->request->post['payment_schet_total'];
		} else {
			$this->data['payment_schet_total'] = $this->config->get('payment_schet_total');
		}

		if (isset($this->request->post['payment_schet_order_status_id'])) {
			$this->data['payment_schet_order_status_id'] = $this->request->post['payment_schet_order_status_id'];
		} else {
			$this->data['payment_schet_order_status_id'] = $this->config->get('payment_schet_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payment_schet_geo_zone_id'])) {
			$this->data['payment_schet_geo_zone_id'] = $this->request->post['payment_schet_geo_zone_id'];
		} else {
			$this->data['payment_schet_geo_zone_id'] = $this->config->get('payment_schet_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payment_schet_status'])) {
			$this->data['payment_schet_status'] = $this->request->post['payment_schet_status'];
		} else {
			$this->data['payment_schet_status'] = $this->config->get('payment_schet_status');
		}

		if (isset($this->request->post['payment_schet_sort_order'])) {
			$this->data['payment_schet_sort_order'] = $this->request->post['payment_schet_sort_order'];
		} else {
			$this->data['payment_schet_sort_order'] = $this->config->get('payment_schet_sort_order');
		}


		$this->template = 'payment/payment_schet.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/payment_schet')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (!$this->request->post['payment_schet_bank_' . $language['language_id']]) {
				$this->error['bank_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_faktadres_' . $language['language_id']]) {
				$this->error['faktadres_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_uradres_' . $language['language_id']]) {
				$this->error['uradres_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_inn_' . $language['language_id']]) {
				$this->error['inn_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_rs_' . $language['language_id']]) {
				$this->error['rs_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_bankuser_' . $language['language_id']]) {
				$this->error['bankuser_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_bik_' . $language['language_id']]) {
				$this->error['bik_' .  $language['language_id']] = $this->language->get('error_bank');
			}
			if (!$this->request->post['payment_schet_ks_' . $language['language_id']]) {
				$this->error['ks_' .  $language['language_id']] = $this->language->get('error_bank');
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>