<?php
class ControllerModuleFooter extends Controller {
	protected function index($setting) {
		$this->language->load('module/footer');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/footer.tpl';
		} else {
			$this->template = 'default/template/module/footer.tpl';
		}

		$this->render();
	}
}
?>