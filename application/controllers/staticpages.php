<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staticpages extends CI_Controller {
	private $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->model(array('common_model','user_model'));
		$this->data = $this->common_model->getAllData();
		$city_detail = $this->common_model->setCurrentCity();
		$this->data['cityId'] = $city_detail[1];
		$this->data['cityName'] = $city_detail[0];
		
		$this->data['class_name'] = $this->router->fetch_class(); 
	}
	public function about_us(){
		$this->data['method_name'] = $this->router->fetch_method();
		$this->data['metadata']['title'] = "Book Dr Appointment - About Us";
		$this->data['metadata']['description'] = "Summary of what we are into and how we provide this service";

		$this->load->view('aboutus',$this->data);
	}
	public function add_on(){	
		$this->data['method_name'] = $this->router->fetch_method();
		$this->data['metadata']['title'] = "Book Dr Appointment - Add on Services";
		$this->data['metadata']['description'] = "Add on services provided by Book Dr Appointment Service.";

		$this->load->view('addon.tpl.php',$this->data);
	}
	public function contact_us(){	
		$this->data['metadata']['title'] = "Book Dr Appointment - Contact us";
		$this->data['metadata']['description'] = "Contact us for any query or suggestion regarding Book Dr Appointment";
		$this->data['method_name'] = $this->router->fetch_method();

		$this->load->view('contact_us',$this->data);
	}
	public function terms_and_conditions(){	
		$this->data['metadata']['title'] = "Book Dr Appointment - Terms and Conditions";
		$this->data['metadata']['description'] = "List of Terms and conditions you have to abide by while using Book Dr Appointment Service.";

		$this->data['method_name'] = $this->router->fetch_method();
		$this->load->view('terms_conditions',$this->data);
	}
	public function privacy_policy(){	
		$this->data['metadata']['title'] = "Book Dr Appointment - Privacy Policy";
		$this->data['metadata']['description'] = "Privacy policy of Book Dr Appointment";
		$this->data['method_name'] = $this->router->fetch_method();

		$this->load->view('privacy_policy.php',$this->data);
	}
	public function patient(){	
		$this->data['method_name'] = $this->router->fetch_method();
		$this->data['metadata']['title'] = "Find Doctors and Clinics in ".ucwords($this->data['cityName'])." Online| Doctor Finder - Book Doctor Appointment";
		$this->data['metadata']['description'] = "Book dr appointment allows Patients to find a doctor in nearby location, search the nearby trusted specialists or doctors and book appointments online instantly";
		$this->data['metadata']['keywords'] = "doctor finder, doctor finder in ".ucwords($this->data['cityName']).", doctor finder ".ucwords($this->data['cityName']).", find a doctor, find a doctor in ".ucwords($this->data['cityName']).", find a doctor ".ucwords($this->data['cityName']).", find a doctor instantly, find clinics in ".ucwords($this->data['cityName']).", find doctor and clinics, find doctors and clinics in ".ucwords($this->data['cityName']).", find doctor online in ".ucwords($this->data['cityName']).", find doctor online";
		$this->load->view('patient_marketing',$this->data);
	}
	public function patient_faq(){
		$this->data['metadata']['title'] = "Book Dr Appointment - Patient Frequently Asked Questions";
		$this->data['metadata']['description'] = "Frequently Asked Questions by patient on Book Dr Appointment";
		$this->data['method_name'] = $this->router->fetch_method();

		$this->load->view('patient_faq',$this->data);
	}
	public function marketing(){## Doctor page 	
		$this->data['method_name'] = $this->router->fetch_method();
		$this->data['metadata']['title'] = "Book Doctor Appointment for Doctors | Doctor Reviews - Ratings, Facilities, Services, Records ";
		$this->data['metadata']['description'] = "Let patients find you by your reviews, services, facilities, name, your availability etc and book appointment online. Best way to keep.......";
		$this->data['metadata']['keywords'] = "Doctor Login, doctor reviews, doctors digital records, doctors online availability";

		$this->load->view('doctor_marketing',$this->data);
	}
	public function doctor_faq(){
		$this->data['metadata']['title'] = "Book Dr Appointment - Doctor Frequently Asked Questions";
		$this->data['metadata']['description'] = "Frequently Asked Questions by doctor on Book Dr Appointment";
		$this->data['method_name'] = $this->router->fetch_method();

		$this->load->view('doctor_faq',$this->data);
	}
	public function forgor_password_mail(){
		$this->data['method_name'] = $this->router->fetch_method();
		$this->load->view('mailers/reset_password_code',array());
	}
	public function js_java_bridge(){
		$this->data['method_name'] = $this->router->fetch_method();
		$this->load->view('js_java_bridge',array());
	}
	

}
/* End of file aboutus.php */
/* Location: ./application/controllers/aboutus.php */