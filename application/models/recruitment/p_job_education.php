<?php
/**
* Model for manage P_job_education Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_job_education extends Abstract_model {

	public $table			= "recruitment.p_job_education";
	public $pkey			= "job_edu_id";
	public $alias			= "job_edu";

	public $fields 			= array(
								'job_edu_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Job Education'),
								'job_posting_id'	    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Job Posting'),
								'education_id'          => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Education'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "job_edu.job_edu_id, job_edu.job_posting_id, job_edu.education_id, job_edu.created_date, job_edu.created_by, job_edu.updated_date, job_edu.updated_by,
	                                job_posting.posting_no,
	                                education.education_code";
	public $fromClause 		= "recruitment.p_job_education as job_edu
	                            LEFT JOIN recruitment.p_job_posting as job_posting ON job_edu.job_posting_id = job_posting.job_posting_id
	                            LEFT JOIN recruitment.p_education as education ON job_edu.education_id = education.education_id";

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
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_job_education','job_edu_id');
			
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

}

/* End of file P_job_education.php */
/* Location: ./application/models/recruitment/P_job_education.php */