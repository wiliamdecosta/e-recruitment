<?php
/**
* Model for manage P_job_major Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_job_major extends Abstract_model {

	public $table			= "recruitment.p_job_major";
	public $pkey			= "job_major_id";
	public $alias			= "job_major";

	public $fields 			= array(
								'job_major_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Job Major'),
								'job_posting_id'	    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Job Posting'),
								'major_id'	            => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID College Major'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "job_major.job_major_id, job_major.job_posting_id, job_major.major_id, job_major.created_date, job_major.created_by, job_major.updated_date, job_major.updated_by,
	                                job_posting.posting_no,
	                                major.major_code";
	public $fromClause 		= "recruitment.p_job_major as job_major
	                            LEFT JOIN recruitment.p_job_posting as job_posting ON job_major.job_posting_id = job_posting.job_posting_id
	                            LEFT JOIN recruitment.p_college_major as major ON job_major.major_id = major.major_id";

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
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_job_major','job_major_id');
			
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

/* End of file P_job_major.php */
/* Location: ./application/models/recruitment/P_job_major.php */