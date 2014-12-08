<?php
class ControllerVideocategory extends Controller {  
	public function index() {
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/ocart_video_gallery.css');
	
		$this->language->load('video/category');
		
		$this->load->model('video/video');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
					
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);
		
		if (isset($this->request->get['vcatid'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['vcatid']);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
									
				$category_info = $this->model_video_video->getCategory($path_id);
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		$category_info = $this->model_video_video->getCategory($category_id);
		
		if ($category_info) {
			$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->data['heading_title'] = $category_info['name'];

            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_category'),
                'href'      => $this->url->link('video/category'),
                'separator' => $this->language->get('text_separator')
            );

        } else {
			$this->document->setTitle($this->language->get('text_category'));
			$this->data['heading_title'] = false;
        }

/*
			$this->data['breadcrumbs'][] = array(
   	    		'text'      => $category_info['name'],
				'href'      => $this->url->link('video/video', 'vcatid=' . $path),
        		'separator' => $this->language->get('text_separator')
        	);
*/

			$this->data['text_empty'] = $this->language->get('text_empty');			
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');
			
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
			
			$this->data['videos'] = array();

            if ($category_id) {
			    $data = array(
				    'filter_category_id' => $category_id,
				    'sort'               => $sort,
				    'order'              => $order,
				    'start'              => ($page - 1) * $limit,
				    'limit'              => $limit
			    );
            } else {
			    $data = array(
				    'sort'               => $sort,
				    'order'              => $order,
				    'start'              => ($page - 1) * $limit,
				    'limit'              => $limit
			    );
            }
					
			$this->load->model('tool/image');
		
			$video_total = $this->model_video_video->getTotalVideos($data);
			
			$results = $this->model_video_video->getVideos($data);
			
			foreach ($results as $result) {
				
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 120, 90);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 120, 90);
				}

                //--- split description ---
    			$html  = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
                $parts = mb_split('<!--more-->', $html);

                if (count($parts) > 0) {
        			$begin_description = $parts[0];
        			$end_description   = false;
                } else {
        			$begin_description = false;
        			$end_description   = false;
                }

                if (count($parts) > 1) {
        			$end_description   = $parts[1];
                }
                //--- split description ---

				$this->data['videos'][] = array(
					'video_id'  => $result['video_id'],
					'thumb'     => $image,
					'name'      => $result['name'],
					'title'     => $result['name'],
                    'description'       => $html,
                    'begin_description' => $begin_description,
                    'end_description'   => $end_description,
                    'create_date' => date($this->config->get('news_config_datetime'), strtotime($result['date_added'])),
					'comment'       => (int)$result['reviews'],
					'comment_href'  => $this->url->link('video/video', 'vcatid=' . $result['vcat_id'] . '&video_id=' . $result['video_id']),
    				'vcat_name' => $result['vcat_name'],
	    			'vcat_href' => $this->url->link('video/category', 'vcatid=' . $result['vcat_id']),
					'href'      => $this->url->link('video/video', 'vcatid=' . $result['vcat_id'] . '&video_id=' . $result['video_id'])
				);
			}
			
			$url = '';

			if (isset($this->request->get['vcatid'])) {
				$url .= '&vcatid=' . $this->request->get['vcatid'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('video/category', '&sort=v.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('video/category', '&sort=v.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('video/category', '&sort=v.name&order=DESC' . $url)
			);
		
			$url = '';

			if (isset($this->request->get['vcatid'])) {
				$url .= '&vcatid=' . $this->request->get['vcatid'];
			}

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
			$pagination->total          = (int)$video_total;
  			$pagination->page           = $page;
			$pagination->limit          = $limit;
			$pagination->text           = '';
        	$pagination->style_links    = '';
            $pagination->style_results  = '';
            $pagination->text_first     = $this->language->get('text_first');
            $pagination->text_last      = $this->language->get('text_last');
            $pagination->text_next      = $this->language->get('text_next');
            $pagination->text_prev      = $this->language->get('text_prev');

			$pagination->url = $this->url->link('video/category', $url . '&page={page}');

            $this->data['total_pages'] = sprintf($this->language->get('text_total_page'),(int)$pagination->pages);
			$this->data['pagination'] = $pagination->render();
		
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;
		
			$this->data['continue'] = $this->url->link('common/home');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/video/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/video/category.tpl';
			} else {
				$this->template = 'default/template/video/category.tpl';
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