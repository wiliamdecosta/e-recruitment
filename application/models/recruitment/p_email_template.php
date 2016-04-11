<?php
/**
* Model for manage P_email_template Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_email_template extends Abstract_model {

	public $table			= "recruitment.p_email_template";
	public $pkey			= "email_tpl_id";
	public $alias			= "email_template";

	public $fields 			= array(
								'email_tpl_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Email Template'),
								'job_posting_id'	    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Job Posting'),
								'email_tpl_subject'	    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Judul Email'),
								'email_tpl_content'	    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Isi Email'),
								'email_tpl_description'	=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Deskripsi'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "email_template.*";
	public $fromClause 		= "recruitment.p_email_template as email_template";

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
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_email_template','email_tpl_id');
			
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

/* End of file P_email_template.php */
/* Location: ./application/models/recruitment/P_email_template.php */