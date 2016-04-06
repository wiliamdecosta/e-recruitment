<?php
/**
* Model for manage T_applicant_job Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class T_applicant_job extends Abstract_model {

	public $table			= "recruitment.t_applicant_job";
	public $pkey			= "applicant_job_id";
	public $alias			= "applicant_job";

	public $fields 			= array(
								'applicant_job_id' 		=> array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Applicant Job'),
								'applicant_id'	   		=> array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Applicant'),
								'job_posting_id'	    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Job Posting'),
								
								'applicant_no_reg'		=> array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'No Registrasi'),
								'is_approve'			=> array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Is Approve'),
								'is_send_email'			=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Is Send Email'),
								'send_email_date'		=> array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Send Email Date'),
								

								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "applicant_job.applicant_job_id, applicant_job.applicant_id, applicant_job.job_posting_id,
								applicant_job.applicant_no_reg, applicant_job.is_approve, applicant_job.is_send_email,
	                           	applicant_job.created_by,
								applicant_job.created_date,
	                           	applicant_job.updated_date,
	                           	applicant_job.updated_by,
	                           	applicant.applicant_id, applicant.major_id, applicant.education_id,  applicant.applicant_status_id,
	                            applicant.applicant_username, applicant.applicant_fullname,  applicant.applicant_ktp_no,
	                            applicant.applicant_email, applicant.applicant_telp,  applicant.applicant_hp,
	                            applicant.applicant_date_of_birth, applicant.applicant_ipk, applicant.applicant_address,  applicant.applicant_city,
	                            applicant_status.code AS status_code,
	                            education.education_code,
	                            major.major_code";
	public $fromClause 		= "recruitment.t_applicant_job AS applicant_job
								LEFT JOIN recruitment.p_applicant as applicant ON applicant_job.applicant_id = applicant.applicant_id
								LEFT JOIN recruitment.p_applicant_status as applicant_status ON applicant.applicant_status_id = applicant_status.applicant_status_id
	                            LEFT JOIN recruitment.p_education as education ON applicant.education_id = education.education_id
	                            LEFT JOIN recruitment.p_college_major as major ON applicant.major_id = major.major_id";

	public $refs			= array();

	public $comboDisplay	= array();
    
    function __construct() {
		parent::__construct();
	}

	function validate() {
	    $ci =& get_instance();
	    
	    $user_name = $ci->session->userdata('user_name');
	    
		if($this->actionType == 'CREATE') {
			//do something
			
			$this->record[$this->pkey] = $this->generate_id('recruitment','t_applicant_job','applicant_job_id');
			
			$this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $user_name;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
            
		}else {
			//do something
			
			$this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
		}
		return true;
	}
	
	
	function disapprove_applicants($items) {
	    $ci =& get_instance();
	    $user_name = $ci->session->userdata('user_name');
	    
	    $sql = "UPDATE recruitment.t_applicant_job 
	             SET is_approve = 'N',
	             updated_date = '".date('Y-m-d')."',
	             updated_by = '".$user_name."'
	             WHERE applicant_job_id IN (".$items.")";
	    $this->db->query($sql);
	}
    
    function approve_applicants($items) {
	    $ci =& get_instance();
	    $user_name = $ci->session->userdata('user_name');
	    
	    $sql = "UPDATE recruitment.t_applicant_job 
	             SET is_approve = 'Y',
	             updated_date = '".date('Y-m-d')."',
	             updated_by = '".$user_name."'
	             WHERE applicant_job_id IN (".$items.")";
	    $this->db->query($sql);
	}
}

/* End of file T_applicant_job.php */
/* Location: ./application/models/recruitment/T_applicant_job.php */