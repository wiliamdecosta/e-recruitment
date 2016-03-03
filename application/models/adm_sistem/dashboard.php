<?php
/**
* Model for manage P_icon Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class Dashboard extends Abstract_model {

	public $table			= "";
	public $pkey			= "";
	public $alias			= "";

	public $fields 			= array();

	public $selectClause 	= "";
	public $fromClause 		= "";

	public $refs			= array();

	public $comboDisplay	= array();

	function __construct() {
		parent::__construct();
	}

	function validate() {
	    
		if($this->actionType == 'CREATE') {
			//do something

		}else {
			//do something
		}
		return true;
	}
	
	function getTotalUser() {
	    $sql = "SELECT COUNT(1) AS totalcount FROM recruitment.p_user";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		
		$query->free_result();
		
		return $row['totalcount'];
	}
    
    function getTotalRole() {
	    $sql = "SELECT COUNT(1) AS totalcount FROM recruitment.p_role";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		
		$query->free_result();
		
		return $row['totalcount'];
	}
}

/* End of file P_icon.php */
/* Location: ./application/models/P_icon.php */