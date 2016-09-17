<?php
class page_model extends CI_Model {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 6;
	public $url = '';
	public $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';
	public $style_links = 'pagination';
	public $style_results = 'results';
	public $onclick = '';
	public $showCount = true;
	public $retArr=array();
	public $short=false;
	public $click="";
	
	 
	/*
	*This Function returns An array of page numeric format + last and next page AND previou and First page 
	* if Short Is true only start and last pages will be provided. No numeric pages
	*/
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

		$num_links = 9;//$this->num_links;
		$num_pages = ceil($total / $limit);
		
		$output = '';
		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 2;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}
			if(!$this->short){
				for ($i = $start; $i <= $end; $i++) {
					if($this->onclick != ""){
							$this->click = 'onclick="' . str_replace('{page}', $i, $this->onclick) . '"';
					}
					if ($page == $i) {
						$output .= ' <a '.$this->click.' class="act" href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
						$this->retArr['page'][$i]['click']=$this->click;
						$this->retArr['page'][$i]['url']=str_replace('{page}', $i, $this->url);
					} else {
						$output .= ' <a '.$this->click.' href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
						$this->retArr['page'][$i]['click']=$this->click;
						$this->retArr['page'][$i]['url']=str_replace('{page}', $i, $this->url);
						
					}	
				}
			}				
		}
        if (ceil($this->total/$this->limit) > $page){
            $this->click = null;
            if($this->onclick != ""){
                $this->click =  str_replace('{page}', ($page + 1), $this->onclick);
            }
			$this->retArr['lPage']['click']=$this->click;
			$this->retArr['lPage']['url']=str_replace('{page}', ($num_pages), $this->url);
			$this->retArr['nextPage']['click']=$this->click;
			$this->retArr['nextPage']['url']=str_replace('{page}', ($page + 1), $this->url);
		
		}
		
        if ($page > 1){
            $this->click = null;
            if($this->onclick != ""){
                $this->click =  str_replace('{page}', ($page - 1), $this->onclick) ;
            }
			$this->retArr['sPage']['click']=$this->click;
			$this->retArr['sPage']['url']=str_replace('{page}', (1), $this->url);
			$this->retArr['prePage']['click']=$this->click;
			$this->retArr['prePage']['url']=str_replace('{page}', ($page - 1), $this->url);
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
		return ($this->retArr ? $this->retArr : array());
	}
}