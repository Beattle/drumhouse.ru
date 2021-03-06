<?php
final class Pagination {
	public $total = 0;
	public $page = 1;
	public $pages = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';
	public $style_links = 'links';
	public $style_results = 'results';

	public function render() {
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}

		if (!$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);
        $pages     = $num_pages;

		$output = '';

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			if ($start > 1) {
				$output .= ' .... ';
			}

            $output .= '<ul class="page-nav">';

    		if ($page > 1) {
    			$output .= '<li class="prev"><span><a href="' . str_replace('{page}', 1, $this->url) . '&path=' .'">' . $this->text_first . '</a> <a href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></span></li>';
        	} else {
                if ($num_pages > 1) {
    			    $output .= '<li class="prev"><span>' . $this->text_first . ' ' . $this->text_prev . '</span></li>';
                }
            }

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= '<li class="active"><a href="' . str_replace('route=product/category', 'route=product/search', str_replace('{page}', $i, $this->url)) . '">' . $i . '</a></li>';
				} else {
					$output .= '<li><a href="' . str_replace('route=product/category', 'route=product/search', str_replace('{page}', $i, $this->url)) . '">' . $i . '</a></li>';
				}
			}

       		if ($page < $num_pages) {
    			$output .= '<li class="next"><a href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a> <a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a></li>';
    		} else {
    			$output .= '<li class="next">' . $this->text_next . ' ' . $this->text_last . '</li>';
            }

            $output .= '</ul>';

			if ($end < $num_pages) {
				$output .= ' .... ';
			}
		}

		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);

		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total,
			$num_pages
		);

		return ($output ? $output : '') . str_replace($find, $replace, $this->text);
		//return ($output ? '<div class="' . $this->style_links . '">' . $output . '</div>' : '') . '<div class="' . $this->style_results . '">' . str_replace($find, $replace, $this->text) . '</div>';
	}
}
?>