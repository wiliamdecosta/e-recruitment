<?php
/**
* Model for manage P_applicant_status Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_applicant_status extends Abstract_model {

	public $table			= "recruitment.p_applicant_status";
	public $pkey			= "applicant_status_id";
	public $alias			= "applicant_status";

	public $fields 			= array(
								'applicant_status_id' 	=> array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_applicant_status'),
								'code'	                => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Status Pelamar'),
								'description'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "applicant_status.*";
	public $fromClause 		= "recruitment.p_applicant_status as applicant_status";

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
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_applicant_status','applicant_status_id');
			
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

/* End of file P_applicant_status.php */
/* Location: ./application/models/recruitment/P_applicant_status.php */