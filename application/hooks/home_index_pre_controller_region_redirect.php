<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region extends CI_Controller{

function getCurrentCity(){
		if(sizeof($params)==0 && $this->get==false &&  $this->post==false){
			$this->data['city_detail'] = $this->common->getCurrentCity(array('cityName'=>''));
			$this->data['cityName'] = $this->data['city_detail']['cityName'];
			$this->data['cityId'] = $this->data['city_detail']['cityId'];
			$this->data['city'] = $this->data['city_detail']['city'];
			unset($this->data['city_detail']);
			redirect(BASE_URL.$this->data['cityName'],'location');
		}else{
			#echo $method;print_r($params);
			$this->$method($params);
		}
}

}
?>