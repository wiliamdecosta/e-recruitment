<?php
/**
* Model for manage P_user Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:09:29
*
*/

class P_user extends Abstract_model {
	
	public $table			= "recruitment.p_user";
	public $pkey			= "p_user_id";
	public $alias			= "p_user";

	public $fields 			= array(
								'p_user_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID User'),
								'user_name'	            => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'User Name'),
								'user_pwd'	            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Password'),
								'full_name'	            => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Full Name'),
								'email_address'	        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Email Address'),
								'user_status'	        => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Status'),
								'description'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
								'expired_user'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Expired Date'),
								'expired_pwd'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Password Expired'),
                                'last_login_time'	    => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Last Login Time'),
								'fail_pwd'	            => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Fail Password'),
								'is_employee'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Is Employee'),
								'employee_no'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Employee No'),
								'ip_address'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'IP Address'),
								'is_new_user'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Is New User'),
								'creation_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							 );

	public $selectClause 	= "p_user.p_user_id,
                                p_user.user_name,
                                p_user.user_pwd,
                                p_user.full_name,
                                p_user.email_address,
                                p_user.user_status,
                                p_user.description,
                                p_user.expired_user,
                                p_user.expired_pwd,
                                p_user.last_login_time,
                                p_user.fail_pwd,
                                p_user.is_employee,
                                p_user.employee_no,
                                p_user.ip_address,
                                p_user.is_new_user,
                                to_char(p_user.creation_date, 'yyyy-mm-dd') as creation_date, 
                                to_char(p_user.updated_date, 'yyyy-mm-dd') as updated_date,
                                p_user.created_by,
                                p_user.updated_by";
	public $fromClause 		= "recruitment.p_user as p_user";
	public $joinClause 		= array();
	public $refs			= array('recruitment.p_user_role' => 'p_user_id');
	
	public $comboDisplay	= array();

	function __construct() {
		parent::__construct();
	}

	function validate() {
	    $ci =& get_instance();
	    $user_name = $ci->session->userdata('user_name');
	                                    
		if($this->actionType == 'CREATE') {
		    
			$this->record['user_name'] = trim($this->record['user_name']);
            $this->record['full_name'] = trim($this->record['full_name']);
            $this->record['user_pwd'] = md5($this->record['user_name']);
            
            if (isset($this->record['email_address'])){
                if(!isValidEmail( $this->record['email_address'] )) {
                    throw new Exception("Your email address format is incorrect");
                }
            }
            
            $this->record['p_user_id'] = $this->generate_id('recruitment','p_user','p_user_id');
            $this->record['creation_date'] = date('Y-m-d');
            $this->record['created_by'] = $user_name;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
            		
		}else {
			//do something
			if (isset($this->record['user_name'])){
                $this->record['user_name'] = trim($this->record['user_name']);
                if (empty($this->record['user_name'])) throw new Exception('Username Field is Empty');
            }
            
            if (isset($this->record['full_name'])){
                $this->record['full_name'] = trim($this->record['full_name']);
                if (empty($this->record['full_name'])) throw new Exception('Fullname Field is Empty');
            }

            if (isset($this->record['user_pwd'])){
                if (trim($this->record['user_pwd']) == '') throw new Exception('Password Field is Empty');
                if (strlen($this->record['user_pwd']) < 5) throw new Exception('Mininum password length is 5 characters');
                
                $this->record['user_pwd'] = md5($this->record['user_pwd']);
            }
            
            if (isset($this->record['email_address'])){
                if(!isValidEmail( $this->record['email_address'] )) {
                    throw new Exception("Email Format is Not Valid");
                }
            }
            
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
		}
		return true;
	}
	
}

/* End of file user.php */
/* Location: ./application/models/base/user.php */