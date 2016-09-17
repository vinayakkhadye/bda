<?php

if (!defined('BASEPATH'))
    exit('No direct access allowed');

class adminappointments_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admindoctor_model');
    }

    function get_appointments($a = array()) {
        $this->db->start_cache();

        $res = false;
        $whereArray = array();

        $this->filterData_active($a);
        $this->db->select('appointment.*, clinic.contact_number as clinic_contact_number,  city.name as city_name, doctor.name as doctor_name, doctor.contact_number as doc_contact_number');
        $this->db->from('appointment');

        if (!empty($a['id'])) {
            $whereArray['appointment.id'] = $a['id'];
        }
        if (!empty($a['name'])) {
            $whereArray["appointment.patient_name"] = $a['patient_name'];
        }
        if (!empty($a['city'])) {
            $whereArray["appointment.city_id"] = $a['city'];
        }
        if (!empty($a['doctor_name'])) {
            $this->db->like("doctor.name", $a['doctor_name'], 'both');
        }
        if (!empty($a['patient_name'])) {
            $this->db->like("patient.name", $a['patient_name'], 'both');
        }

        if (isset($a['status']) && strlen($a['status']) > 0) {
            $whereArray['appointment.status'] = $a['status'];
        }
        if (isset($a['confirmation']) && strlen($a['confirmation']) > 0) {
            $whereArray['appointment.confirmation'] = $a['confirmation'];
        }

        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('city', 'appointment.city_id = city.id');
        $this->db->join('clinic', 'appointment.clinic_id = clinic.id');
        $this->db->where($whereArray);
        $query = $this->db->get();
//	echo $this->db->last_query();
        $this->row_count = $this->db->count_all_results();
        $this->db->stop_cache();
        $this->db->flush_cache();

        if ($query->num_rows() >= 1) {
            $res = $query->result();
        }
        return $res;
    }

    function get_all_details_appointment($appointment_id) {
        $this->db->select('appointment.*, city.name as city_name, doctor.name as doctor_name, speciality.name as speciality_name, clinic.name as clinic_name, clinic.address as clinic_address, clinic.contact_number as clinic_number, doctor.speciality as doctorspeciality, doctor.other_speciality as doctor_other_speciality');
        $this->db->from('appointment');
        $this->db->join('city', 'appointment.city_id = city.id');
        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('speciality', 'doctor.speciality = speciality.id', 'left');
        $this->db->join('clinic', 'appointment.clinic_id = clinic.id');
        $this->db->where('appointment.id', $appointment_id);

        $query = $this->db->get();
        #echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $rs = $query->row_array();
            if ($rs['doctorspeciality']) {
                $rs['allspeciality'] = $this->admindoctor_model->get_speciality($rs['doctorspeciality']);
            }
            //print_r($rs);
            return $rs;
        } else {
            return FALSE;
        }
    }

    function get_speciality_ofdoctors($speciality) {
        $speciality = trim($speciality, ',');
        $where = "id in ($speciality)";
//		$this->db->_protect_identifiers = FALSE;
        $this->db->select('name as speciality_name');
        $this->db->from('speciality');
        $this->db->where($where);
        $query = $this->db->get();
        return $query = $query->result_array();
    }

    function update_appointment_status($status, $ids) {
//		print_r($ids);
//		echo $status;exit;
        if (is_array($ids)) {
            $this->db->where_in('id', $ids); //$ids should be an array
            $update['status'] = $status;
            if ($status == 0) {
                $update['confirmation'] = 0;
            }
            $this->db->update('appointment', $update);
            return $this->db->affected_rows();
        }
        return false;
    }

    function update_appointment_confirmation($confirmation, $ids) {
		#print_r($ids);
		#echo $confirmation;exit;
        if (is_array($ids)) {
//                    echo $app_id = $this->post['app_id'];
//                    echo $confrm_date = $this->post['confrm_date'];

            $confrm_date = date('Y-m-d H:i:s');

            $this->db->where_in('id', $ids); //$ids should be an array
            $update = array('confirmation' => $confirmation, 'confirmation_date' => $confrm_date,'status'=>1);
						$update['status'] = 1;
						if($confirmation == 0 || $confirmation == 2)
						{
							$update['confirmation_date'] =  NULL;
            }

            $this->db->update('appointment', $update);
						#echo $this->db->last_query();exit;
            return $this->db->affected_rows();
        }
        return false;
    }

    function edit_appointment_details($postdata, $appointment_id, $a = array()) {

        $datetime = date('Y-m-d', strtotime($postdata['scheduled_date'])) . ' ' . date('H:i:s', strtotime($postdata['scheduled_time']));

        if (isset($postdata['clinicid']) && !empty($postdata['clinicid'])) {
            $data = array(
                'patient_name' => $postdata['patient_name'],
                'patient_email' => $postdata['patient_email'],
                'patient_gender' => $postdata['patient_gender'],
                'reason_for_visit' => $postdata['reason_for_visit'],
                'date' => date('Y-m-d', strtotime($postdata['scheduled_date'])),
                'time' => date('H:i:s', strtotime($postdata['scheduled_time'])),
                'scheduled_time' => date('Y-m-d H:i:s', strtotime($datetime)),
                'mobile_number' => $postdata['mobile_number'],
                'consultation_type' => $postdata['consultation_type'],
                'status' => $postdata['status'],
                'confirmation' => $postdata['confirmation'],
                'doctor_id' => $postdata['doctorid'],
                'clinic_id' => $postdata['clinicid'],
                'updated_on' => date('Y-m-d H:i:s')
            );
        } else {
            $data = array(
                'patient_name' => $postdata['patient_name'],
                'patient_email' => $postdata['patient_email'],
                'patient_gender' => $postdata['patient_gender'],
                'reason_for_visit' => $postdata['reason_for_visit'],
                'date' => date('Y-m-d', strtotime($postdata['scheduled_date'])),
                'time' => date('H:i:s', strtotime($postdata['scheduled_time'])),
                'scheduled_time' => date('Y-m-d H:i:s', strtotime($datetime)),
                'mobile_number' => $postdata['mobile_number'],
                'consultation_type' => $postdata['consultation_type'],
                'status' => $postdata['status'],
                'confirmation' => $postdata['confirmation'],
                'doctor_id' => $postdata['doctorid'],
                'updated_on' => date('Y-m-d H:i:s')
            );
        }

        $this->db->where('id', $appointment_id);
        $this->db->update('appointment', $data);
        //exit;
    }

    function add_appointment($postdata) {
        //print_r($postdata);
        $datetime = date('Y-m-d', strtotime($postdata['scheduled_date'])) . ' ' . date('h:i:s', strtotime($postdata['scheduled_time']));
        if (isset($postdata['clinicid']) && !empty($postdata['clinicid'])) {
            $data = array(
                'patient_name' => $postdata['patient_name'],
                'patient_email' => $postdata['patient_email'],
                'patient_gender' => $postdata['patient_gender'],
                'reason_for_visit' => $postdata['reason_for_visit'],
                'date' => date('Y-m-d', strtotime($postdata['scheduled_date'])),
                'time' => date('h:i:s', strtotime($postdata['scheduled_time'])),
                'scheduled_time' => date('Y-m-d h:i:s', strtotime($datetime)),
                'mobile_number' => $postdata['mobile_number'],
                'consultation_type' => $postdata['consultation_type'],
                'status' => $postdata['status'],
                'confirmation' => $postdata['confirmation'],
                'doctor_id' => $postdata['doctorid'],
                'clinic_id' => $postdata['clinicid'],
                'updated_on' => date('Y-m-d h:i:s')
            );
        } else {
            $data = array(
                'patient_name' => $postdata['patient_name'],
                'patient_email' => $postdata['patient_email'],
                'patient_gender' => $postdata['patient_gender'],
                'reason_for_visit' => $postdata['reason_for_visit'],
                'date' => date('Y-m-d', strtotime($postdata['scheduled_date'])),
                'time' => date('h:i:s', strtotime($postdata['scheduled_time'])),
                'scheduled_time' => date('Y-m-d h:i:s', strtotime($datetime)),
                'mobile_number' => $postdata['mobile_number'],
                'consultation_type' => $postdata['consultation_type'],
                'status' => $postdata['status'],
                'confirmation' => $postdata['confirmation'],
                'doctor_id' => $postdata['doctorid'],
                'updated_on' => date('Y-m-d h:i:s')
            );
        }

        $this->db->insert('appointment', $data);
        return $this->db->insert_id();
    }

    function __tostring() {
        return $this->db->last_query();
    }

    /*********************************************************************************************************** */
    /**
     * get_latest_appointment
     */
    function get_latest_appointment(){
        $this->db->select('appointment.*, city.name as city_name, doctor.name as doctor_name');
        $this->db->from("appointment");
        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('city', 'appointment.city_id = city.id');
        $this->db->join('clinic', 'appointment.clinic_id = clinic.id');
        $this->db->order_by('added_on', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $latest_res = $query->row();
        if(!empty($latest_res)){
            return $latest_res->id;
        }
    }
    
    /**
     * get_all_scheduled_appointments
     * @return type
     */
    function get_all_scheduled_appointments($a=array()) {
				$new_appt_data	= false;
        $this->db->select('appointment.*, clinic.contact_number as clinic_contact_number,  city.name as city_name, doctor.name as doctor_name, doctor.contact_number as doc_contact_number');
        $this->db->from("appointment");
        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('city', 'appointment.city_id = city.id');
        $this->db->join('clinic', 'appointment.clinic_id = clinic.id');
				$whereArray = array('appointment.status' => 1, 'appointment.confirmation' => 0);
				
				if(isset($a['doctor_name']) && !empty($a['doctor_name']))
				{
					$this->db->like("doctor.name", $a['doctor_name'], 'both');
				}

				if(isset($a['doctor_id']) && !empty($a['doctor_id']))
				{
					$whereArray['doctor.id']	=	$a['doctor_id'];
				}
				if(isset($a['patient_name']) && !empty($a['patient_name']))
				{
					$this->db->like("appointment.patient_name", $a['patient_name'], 'both');
				}        
				if(isset($a['order_by']) && !empty($a['order_by']))
				{
					$this->db->order_by($a['order_by']);
				}
				else
				{
					$this->db->order_by("appointment.id desc");
				}
        $this->db->where($whereArray);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $new_appt_data = $query->result();
        }
        return $new_appt_data;
    }

    /**
     * 
     * @param type $datetime
     * @return type
     */
    function get_all_inprocess_appointments() {
				$new_appt_data	= false;
        $this->db->select('appointment.*, clinic.contact_number as clinic_contact_number,  city.name as city_name, doctor.name as doctor_name, doctor.contact_number as doc_contact_number');
        $this->db->from("appointment");
        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('city', 'appointment.city_id = city.id');
        $this->db->join('clinic', 'appointment.clinic_id = clinic.id');
        $whereArray = array('appointment.status' => 1, 'appointment.confirmation' => 2);
				$this->db->order_by("appointment.id desc");
        $this->db->where($whereArray);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $new_appt_data = $query->result();
        }
        return $new_appt_data;
    }

//    function getNewAppointments($cur_date) {
//        $new_appt = '';
//        $this->db->select('appointment.*, city.name as city_name, doctor.name as doctor_name');
//        $this->db->from("appointment");
//        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
//        $this->db->join('city', 'appointment.city_id = city.id');
//        $this->db->where('appointment.added_on >', $cur_date);
//        $query = $this->db->get();
//        echo $this->db->last_query();
//        if ($query) {
//            if ($query->num_rows() > 0) {
//                $new_appt = $query->result();
//            } else {
//                echo "no result found";
//            }
//        } else {
//            echo "No Query";
//        }
//           return $new_appt;
//    }

    /**
     * 
     * @param type $appt_notes
     * @param type $id_detls
     * @return string
     */
    function save_extra_appt_details($appt_notes, $id_detls) {
        if (isset($appt_notes)) {
            $this->db->where('id', $id_detls);
            $update_notes = $this->db->update('appointment', array('notes' => $appt_notes));

            if ($update_notes) {
                return "notes added successfully";
            } else {
                return "no data";
            }
        }
    }
    
    function save_revisited_date($revisited_full_date, $id_detls) {
        if (isset($revisited_full_date)) {
            $this->db->where('id', $id_detls);
            $save_rev_date = $this->db->update('appointment', array('revisited_date' => $revisited_full_date));
            if ($save_rev_date) {
                return true;
            }
        }
    }


    function max_appointement_id(){
            
            $this->db->select_max('id'); 
            $query = $this->db->get('appointment');
            
             //$query = $this->db->get();
            if ($query->num_rows() > 0) {
                    return   $query->row();
             } 
             else
             {
                    return  FALSE;
             }
        }


        function getNewPosts($max_id){
            
            $this->db->select('appointment.*, clinic.contact_number as clinic_contact_number, doctor.contact_number as doc_contact_number, city.name as city_name, doctor.name as doctor_name');
            $this->db->from("appointment");
            $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
            $this->db->join('city', 'appointment.city_id = city.id');
             $this->db->join('clinic', 'appointment.clinic_id = clinic.id');
            $this->db->where('appointment.id >', $max_id);
                        $this->db->order_by('appointment.id DESC');
            $query = $this->db->get();
                        #echo $this->db->last_query();
            if ($query->num_rows() > 0) {
                    $rs = $query->result();
                    return $rs;
                } 
                else
                {

                    return  FALSE;
                }
            
        }

}
