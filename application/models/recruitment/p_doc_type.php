<?php
/**
* Model for manage P_doc_type Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_doc_type extends Abstract_model {

	public $table			= "recruitment.p_doc_type";
	public $pkey			= "p_doc_type_id";
	public $alias			= "doc_type";

	public $fields 			= array(
								'p_doc_type_id' 		=> array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_doc_type'),
								'code'	                => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Jenis Dokumen'),
								'description'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "doc_type.*";
	public $fromClause 		= "recruitment.p_doc_type as doc_type";

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
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_doc_type','p_doc_type_id');
			
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

/* End of file P_doc_type.php */
/* Location: ./application/models/recruitment/P_doc_type.php */