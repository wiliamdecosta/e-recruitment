<?php
/**
* Model for manage P_applicant_doc Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_applicant_doc extends Abstract_model {

	public $table			= "recruitment.p_applicant_doc";
	public $pkey			= "p_applicant_doc_id";
	public $alias			= "applicant_doc";

	public $fields 			= array(
								'p_applicant_doc_id'    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_applicant_doc'),
								'applicant_id'	        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Applicant'),
								'p_doc_type_id'	        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Doc Type'),
								'applicant_doc_file'	=> array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'File Name'),
								'description'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Deskripsi'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "applicant_doc.*, applicant_doc.applicant_doc_file as link_file,
	                               doc_type.code as doc_type_code";
	public $fromClause 		= "recruitment.p_applicant_doc as applicant_doc
	                            LEFT JOIN recruitment.p_doc_type as doc_type ON applicant_doc.p_doc_type_id = doc_type.p_doc_type_id";

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
			
			//chek duplicate
			if($this->isDuplicate()) {
			    throw new Exception('Duplikasi data : Jenis dokumen yang bersangkutan sudah ada.');    
			}
			
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_applicant_doc','p_applicant_doc_id');
			
			$this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $user_name;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;

		}else {
			//do something
			
			if($this->isDuplicate($this->record[$this->pkey])) {
			    throw new Exception('Duplikasi data : Jenis dokumen yang bersangkutan sudah ada.');    
			}
			
			$this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
		}
		return true;
	}
    
    public function isDuplicate($id = "") {
		
		$query = "SELECT COUNT(1) AS isduplicate FROM ".$this->table. " WHERE applicant_id = ".$this->record['applicant_id']." AND p_doc_type_id = ".$this->record['p_doc_type_id'];
		if($id != "") {
			$query .= " AND ".$this->pkey." != ".$this->db->escape($id);
		}

		$query = $this->db->query($query);
		$row = $query->row_array();

		$countitems = $row['isduplicate'];
		$query->free_result();
		
		if($countitems > 0) return true;

		return false;
	}
}

/* End of file P_applicant_doc.php */
/* Location: ./application/models/recruitment/P_applicant_doc.php */