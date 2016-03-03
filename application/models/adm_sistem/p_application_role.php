<?php
/**
* Model for manage P_application_role Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_application_role extends Abstract_model {

	public $table			= "recruitment.p_application_role";
	public $pkey			= "p_application_role_id";
	public $alias			= "application_role";

	public $fields 			= array(
								'p_application_role_id' 	=> array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_application_role'),
								'p_role_id'	                => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Role'),
							    'p_application_id'	        => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Module'),
							    
								'creation_date'	            => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By')
							);

	public $selectClause 	= "application_role.p_application_role_id, application_role.p_role_id, application_role.p_application_id, to_char(application_role.creation_date, 'yyyy-mm-dd') as creation_date, 
                                    application_role.created_by,
                                    application.code as application_code";
	public $fromClause 		= "recruitment.p_application_role as application_role
	                                LEFT JOIN recruitment.p_application as application ON application_role.p_application_id = application.p_application_id";

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
			if(isset($this->record['p_role_id'])) {
			    $query = "SELECT COUNT(1) AS total FROM recruitment.p_application_role
			                WHERE p_role_id = ? AND p_application_id = ?";
                
                $query = $this->db->query($query, array($this->record['p_role_id'], $this->record['p_application_id']));
		        $row = $query->row_array();
		        if($row['total'] > 0) {
		            throw new Exception("The module has been existed. Please select another module");    
		        }
			}
			
			$this->record['p_application_role_id'] = $this->generate_id('recruitment','p_application_role','p_application_role_id');
			$this->record['creation_date'] = date('Y-m-d');
            $this->record['created_by'] = $user_name;
		}else {
			//do something
			
		}
		return true;
	}

}

/* End of file P_application_role.php */
/* Location: ./application/models/P_application_role.php */