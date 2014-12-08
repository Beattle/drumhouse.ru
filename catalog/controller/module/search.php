<?php
class ControllerModuleSearch extends Controller {
	protected function index() {
		$this->language->load('module/search');

    	$this->data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
            $this->data['path'] = (string)$this->request->get['path'];
		} else {
            $this->data['path'] = '';
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$manufacturer_id = $this->request->get['filter_manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}
		$this->data['manufacturer_id']  = $manufacturer_id;

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}
		$this->data['filter_name'] = $filter_name;

		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_category']    = $this->language->get('text_category');

		$this->data['entry_search']     = $this->language->get('entry_search');
		$this->data['button_search']    = $this->language->get('button_search');

		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/category');

		$this->data['manufactureres'] = array();

		$manufactureres = $this->model_catalog_manufacturer->getManufacturers(0);
		foreach($manufactureres as $manufacturer)
		{
			$this->data['manufactureres'][] = array(
				'manufacturer_id' => $manufacturer['manufacturer_id'],
				'name'            => $manufacturer['name'],
			);
		}

		$this->data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {
				$children_data[] = array(
					'category_id' => $category['category_id'] . '_' . $child['category_id'],
					'name'        => '&nbsp;&nbsp;&raquo;&nbsp;' . $child['name'],
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
				);
			}

			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}
/*
		foreach($categories as $category)
		{
			$this->data['categories'][] = array(
				'category_id'   => $category['category_id'],
				'name'          => $category['name'],
			);
		}
*/

	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/search.tpl';
		} else {
			$this->template = 'default/template/module/search.tpl';
		}

		$this->render();
  	}

  	public function manufacturer() {

		$this->language->load('module/search');

        $this->load->model('module/search');
        $this->load->model('catalog/manufacturer');

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
		} else {
		    $manufacturer_id = 0;
		}
        if ($manufacturer_id == 0) {
            if (isset($this->session->data['search_manufacturer_id'])) {
                $manufacturer_id = $this->session->data['search_manufacturer_id'];
            }
        }

		if (isset($this->request->get['path'])) {
            $path = (string)$this->request->get['path'];
        } else {
            $path = '';
        }

		if ($path) {
			$parts = explode('_', $path);
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}

        //debug($path);

        if ($path && $category_id > 0) {
    	    $results = $this->model_module_search->getManufacturersByCategoryId($category_id);
        } else {
		    $results = $this->model_catalog_manufacturer->getManufacturers(0);
        }

		$output = '<option value="-1">' . $this->language->get('text_noselect') . '</option>';
      	foreach ($results as $result) {

        	$output .= '<option value="' . $result['manufacturer_id'] . '"';

	    	if ($result['manufacturer_id'] == $manufacturer_id) {
	      		$output .= ' selected="selected"';
	    	}

	    	$output .= '>' . $result['name'] . '</option>';
    	}

		if (!$results) {
		  	$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
    	}

		$this->response->setOutput($output);
  	}

  	public function category() {
		$this->language->load('module/search');

		$this->load->model('module/search');
		$this->load->model('catalog/category');

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}
        $this->session->data['search_manufacturer_id'] = $manufacturer_id;

        $flag_all = 0;
        $array_category_id = array();
        if ($manufacturer_id == '-1') {
            $flag_all = 1;
        } else {
        	$results = $this->model_module_search->getCategoriesIdByManufacturerId($manufacturer_id);
          	foreach ($results as $result) {
                $array_category_id[] = $result['category_id'];
            }
        }

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);
		foreach ($categories as $category) {

            $flag_include = 0;

            if ($flag_all || in_array($category['category_id'], $array_category_id)) {
    			$data['categories'][] = array(
    				'category_id' => $category['category_id'],
    				'name'        => $category['name'],
    				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
    			);
            }

  			$children_data = array();
  			$children = $this->model_catalog_category->getCategories($category['category_id']);

  			foreach ($children as $child) {
                if ($flag_all || in_array($child['category_id'], $array_category_id)) {
                    $flag_include = 1;
      				$children_data[] = array(
      					'category_id' => $category['category_id'] . '_' . $child['category_id'],
      					'name'        => '&nbsp;&nbsp;&raquo;&nbsp;' . $child['name'],
      					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
      				);

    			    $data['categories'][] = array(
    				    'category_id' => $category['category_id'] . '_' . $child['category_id'],
    				    'name'        => $category['name'] . '&nbsp;&nbsp;&raquo;&nbsp;' . $child['name'],
      				    'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
    			    );
                }
  			}
        }

	    if (isset($this->request->get['path'])) {
	        $path = $this->request->get['path'];
	    } else {
            $path = false;
        }

		$output = '<option value="">' . $this->language->get('text_noselect') . '</option>';
        foreach ($data['categories'] as $result) {

        	$output .= '<option value="' . $result['category_id'] . '"';
	    	if ($result['category_id'] == $path) {
	      		$output .= ' selected="selected"';
	    	}
	    	$output .= '>' . $result['name'] . '</option>';

            /*
            if ($result['children']) {
                foreach ($result['children'] as $child) {
                	$output .= '<option value="' . $child['category_id'] . '"';
        	    	if ($child['category_id'] == $path) {
        	      		$output .= ' selected="selected"';
                    }
	    	        $output .= '>' . $child['name'] . '</option>';
                }
            }
            */
    	}

		if (!$data['categories']) {
		  	$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
    	}

		$this->response->setOutput($output);
    }

}
?>