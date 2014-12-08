<?php
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_service'] = $this->language->get('text_service');
		$this->data['text_extra'] = $this->language->get('text_extra');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_return'] = $this->language->get('text_return');
    	$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		
		$this->load->model('catalog/information');
		
		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
	    		'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
      		);
    	}

		$this->data['contact'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
    	$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer', '', 'SSL');
		$this->data['voucher'] = $this->url->link('checkout/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');		

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

        //----------------------------------------------------------------------
		$this->load->model('catalog/category');

        $links_id[] = array();

        $links_id[0] = $this->config->get('href_1');
        $links_id[1] = $this->config->get('href_2');
        $links_id[2] = $this->config->get('href_3');
        $links_id[3] = $this->config->get('href_4');

        $this->data['$links'] = array();

        $m = 0;
        foreach ($links_id as $link_id) {
            $category_info = array();

            if ($link_id > 0) {
                $category_info = $this->model_catalog_category->getCategory($link_id);
            }

            $childs = array();
            if ($category_info) {

                $results = $this->model_catalog_category->getCategoriesChildByParentId($link_id);
                foreach ($results as $result) {
                    $child_info = $this->model_catalog_category->getCategory($result);
                    $childs[] = array(
                      'category_id' => $result['category_id'],
                      'name'        => $child_info['name'],
                      'href'        => str_replace('&amp;', '&', $this->url->link('product/search', 'path=' . $link_id . '_' . $result['category_id'])),
                    );
                }

                $this->data['links'][$m] = array(
                    'category_id' => $category_info['category_id'],
                    'name'        => $category_info['name'],
                    'href'        => str_replace('&amp;', '&', $this->url->link('product/search', 'path=' . $category_info['category_id'])),
                    'childs'      => $childs
                );
            } else {
                $this->data['links'][$m] = array(
                    'category_id' => '0',
                    'name'        => 'none',
                    'href'        => str_replace('&amp;', '&', $this->url->link('common/home')),
                    'childs'      => false
                );
            }
            $m++;
        }

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}

		$this->data['name'] = $this->config->get('config_name');
		$this->data['logoname'] = $this->config->get('config_logoname');

		if ($this->config->get('config_logo_footer') && file_exists(DIR_IMAGE . $this->config->get('config_logo_footer'))) {
			$this->data['logo_footer'] = $server . $this->config->get('config_logo_footer');
		} else {
			$this->data['logo_footer'] = '';
		}


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}
}
?>