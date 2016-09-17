<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Anmol Mourya
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

class knowlarity_number_mapping extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}



	public function index()
	{ 
		a:

		$this->db->select('knowlarity_number.*');
		$this->db->from('knowlarity_number',1);
		$this->db->where('status',0);
		$query=$this->db->get();
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$data = $query->row_array();
			}
			else
			{
				echo " done";
				exit;

			}						
		} 
			 
			$from_id= $data['from_clinic_id'];
			$id= $data['id'];
			$to_id= $data['to_clinic_id'];
			$number= $data['number'];
			// $i=100;
			// print_r($data);
			 
			$i=1000;
			for($from_id; $from_id<=$to_id; $from_id++)			
			{
				//echo"Pass value for verify".$from_id ."to". $to_id;
				$clinic_id =$this->number_verified($from_id);
					//$clinic_id = number_verified($from_id);
				 echo "clininc id".$clinic_id['is_number_verified'];
				// print_r($clinic_id);

					if($i<=9999) 
					{
						if($clinic_id['is_number_verified']==1)
						{
						$updates = array(
									'knowlarity_number' => $number,
									'knowlarity_extension' => $i
									);

						$this->db->where('id',$from_id);
						$this->db->update('clinic_2', $updates);
					    }
						//$from_id=$from_id+1;

					}
					else
					{

						$updates2 = array('status' => 1 );
						$this->db->where('id', $id );
						$this->db->update('knowlarity_number', $updates2); 
						echo " done";
						exit;

					}

					$i++;

					echo 'extension = '.$i." <br>"; 
						$updates2 = array('status' => 1 );
						$this->db->where('id', $id );
						$this->db->update('knowlarity_number', $updates2); 

					echo 'id for clinic = '.$from_id." <br>";
					 //break; 
			} //for loop						
							// echo json_encode($data['from_clinic_id']);
				     		// echo json_encode($id);
						// echo "Next cycle";
			   goto a; 
	}


			function number_verified($id)
			{
				if($id)
				{
					 
					$this->db->select('is_number_verified');  
					$this->db->from('clinic_2');
					$this->db->where('id',$id);
					$query=$this->db->get();
					 
					if ($query->num_rows() > 0)
					{
					$rs = $query->row_array();
					return   $rs;
					}
					else 
					{
					return FALSE;
					}

				echo "hi 4"; 
				} 
			}// function number_verified

}