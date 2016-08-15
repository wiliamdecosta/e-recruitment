<?php
/**
* Model for manage P_applicant Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_applicant extends Abstract_model {

	public $table			= "recruitment.p_applicant";
	public $pkey			= "applicant_id";
	public $alias			= "applicant";

	public $fields 			= array(
								'applicant_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Applicant'),
								'major_id'	            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Jurusan'),
								'education_id'	        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Pendidikan Terakhir'),
								'applicant_status_id'	=> array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Status Pelamar'),
								
								'applicant_username'	=> array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Username'),
								'applicant_password'	=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Password'),
								'applicant_fullname'	=> array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Nama Lengkap'),
								'applicant_ktp_no'	    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'No.KTP'),
								'applicant_email'	    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Email'),
								'applicant_telp'	    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'No.Telp'),
								'applicant_hp'	        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'No.HP'),
								'applicant_date_of_birth' => array('nullable' => false, 'type' => 'date', 'unique' => false, 'display' => 'Tgl.Lahir'),
								'applicant_ipk'         => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'IPK'),
								'applicant_address'     => array('nullable' =>  false, 'type' => 'str', 'unique' => false, 'display' => 'Alamat'),
								'applicant_city'        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Kota'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "applicant.applicant_id, applicant.major_id, applicant.education_id,  applicant.applicant_status_id,
	                           applicant.applicant_username, applicant.applicant_fullname,  applicant.applicant_ktp_no,
	                           applicant.applicant_email, applicant.applicant_telp,  applicant.applicant_hp,
	                           applicant.applicant_date_of_birth, applicant.applicant_ipk, applicant.applicant_address,  applicant.applicant_city,
	                                applicant_status.code AS status_code,
	                                education.education_code,
	                                major.major_code,
	                           applicant.created_date,
	                           applicant.created_by,
	                           applicant.updated_date,
	                           applicant.updated_by
	                           ";
	public $fromClause 		= "recruitment.p_applicant as applicant
	                                LEFT JOIN recruitment.p_applicant_status as applicant_status ON applicant.applicant_status_id = applicant_status.applicant_status_id
	                                LEFT JOIN recruitment.p_education as education ON applicant.education_id = education.education_id
	                                LEFT JOIN recruitment.p_college_major as major ON applicant.major_id = major.major_id";

	public $refs			= array();

	public $comboDisplay	= array();
    
    public $fromFrontPage = false;
	function __construct() {
		parent::__construct();
	}

	function validate() {
	    $ci =& get_instance();
	    
	    if(!$this->fromFrontPage)
	        $user_name = $ci->session->userdata('user_name');
	    else
	        $user_name = 'applicant';
	    
		if($this->actionType == 'CREATE') {
			//do something
			$this->record['applicant_fullname'] = strtoupper(trim($this->record['applicant_fullname']));
            $this->record['applicant_city'] = strtoupper(trim($this->record['applicant_city']));
            
            if (isset($this->record['applicant_username'])){
                if (strlen($this->record['applicant_username']) < 8) throw new Exception('Mininum Username 8 Karakter');
                
                $this->record['applicant_username'] = strtolower(trim($this->record['applicant_username']));
            }
            
            if (isset($this->record['applicant_password'])){
                if (strlen($this->record['applicant_password']) < 8) throw new Exception('Mininum password 8 Karakter');
                
                $this->record['applicant_password'] = md5($this->record['applicant_password']);
            }
            
            
            if (isset($this->record['applicant_email'])){
                if(!isValidEmail( $this->record['applicant_email'] )) {
                    throw new Exception("Your email address format is incorrect");
                }
            }
            
            
            if (isset($this->record['applicant_ktp_no'])){
                if (strlen($this->record['applicant_ktp_no']) < 16) throw new Exception('No.KTP harus 16 Karakter');
            }
            
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_applicant','applicant_id');
			
			$this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $user_name;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
            
		}else {
			//do something
			
			$this->record['applicant_fullname'] = strtoupper(trim($this->record['applicant_fullname']));
            $this->record['applicant_city'] = strtoupper(trim($this->record['applicant_city']));
            
            unset($this->record['applicant_username']); /* asumsi : username tidak boleh diupdate */
                
                
            if(isset($this->record['applicant_password']) and empty($this->record['applicant_password'])) {
                unset($this->record['applicant_password']);
            }
            
            if (isset($this->record['applicant_email'])){
                if(!isValidEmail( $this->record['applicant_email'] )) {
                    throw new Exception("Your email address format is incorrect");
                }
            }
            
            if (isset($this->record['applicant_ktp_no'])){
                if (strlen($this->record['applicant_ktp_no']) < 16) throw new Exception('No.KTP harus 16 Karakter');
            }
            
			$this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
		}
		return true;
	}

	public function createUserRegister($email,$password,$ktp_number,$full_name,$activation){
		$id = $this->generate_id('recruitment','p_applicant','applicant_id');
		$data = array('applicant_id' => $id,
			'applicant_status_id' => 3,
			'applicant_username' => $email,
			'applicant_password' => md5($password),
			'applicant_fullname' => $full_name,
			'applicant_ktp_no' => $ktp_number,
			'applicant_email' => $email,
			'activation' => $activation
		);

		$this->db->insert('recruitment.p_applicant', $data);
		return $this->db->affected_rows();

	}

	public function updateUserActivation($email, $token){
		$ip = $this->input->ip_address();
		$data = array(
			'activation'=>$token,
			'activation_ip'=>$ip
		);
		$this->db->set('applicant_status_id',1);
		$this->db->set('activation_date',"NOW()",FALSE);
		$this->db->where(array('applicant_email' => $email,'activation' => $token, 'applicant_status_id' => 3 ));
		$this->db->update('recruitment.p_applicant',$data);

		return $this->db->affected_rows();
	}

	public function addDokumenApplicant($filename){
		$id = $this->generate_id('recruitment','p_applicant_doc','p_applicant_doc_id');
		$data = array(
			"p_applicant_doc_id" => $id,
			"p_doc_type_id" => $this->input->post('doc_type_id'),
			"applicant_id" => $this->session->userdata('applicant_id'),
			"applicant_doc_file" => $filename
		);

		$this->db->insert('recruitment.p_applicant_doc', $data);
		return $this->db->affected_rows();

	}

	public function delDocApplicant(){
		$doc_type_id = $this->input->post('doc_type');

		$this->db->where(array(
			'p_doc_type_id' => $doc_type_id,
			'applicant_id' => $this->session->userdata('applicant_id')
		));

		$this->db->delete('recruitment.p_applicant_doc');
		return $this->db->affected_rows();
	}

	public function getApplicantDetail(){
		$this->db->where('applicant_id', $this->session->userdata('applicant_id'));
		$q = $this->db->get('recruitment.p_applicant');
		return $q->row();
	}



}

/* End of file P_applicant.php */
/* Location: ./application/models/recruitment/P_applicant.php */