<?php
/**
* Model for manage P_job_posting Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_job_posting extends Abstract_model {

	public $table			= "recruitment.p_job_posting";
	public $pkey			= "job_posting_id";
	public $alias			= "job_posting";

	public $fields 			= array(
								'job_posting_id'        => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_job_posting'),
								'job_id'	            => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ID Job'),
								'posting_date'	        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Posting Date'),
								'posting_no'	        => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'No Posting'),
								'posting_short_desc'	=> array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Deskripsi'),
								'posting_min_ipk'	    => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Minimum IPK'),
								'is_active'	            => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Is Active'),
								'description'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Vacancy Letter'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "job_posting.job_posting_id, job_posting.job_id, job_posting.posting_date, job_posting.posting_short_desc, job_posting.posting_min_ipk, job_posting.posting_no, job_posting.is_active, job_posting.description,
	                                job_posting.created_date, job_posting.created_by, job_posting.updated_date, job_posting.updated_by,
	                                job.job_code
	                            ";
	public $fromClause 		= "recruitment.p_job_posting as job_posting
	                            LEFT JOIN recruitment.p_job AS job ON job_posting.job_id = job.job_id";

	public $refs			= array('recruitment.p_job_education' => 'job_posting_id',
	                                'recruitment.p_job_major' => 'job_posting_id');

	public $comboDisplay	= array();

	function __construct() {
		parent::__construct();
	}

	function validate() {
	    $ci =& get_instance();
	    $user_name = $ci->session->userdata('user_name');
	    
		if($this->actionType == 'CREATE') {
			//do something
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_job_posting','job_posting_id');
			
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

/* End of file p_job_posting.php */
/* Location: ./application/models/recruitment/p_job_posting.php */