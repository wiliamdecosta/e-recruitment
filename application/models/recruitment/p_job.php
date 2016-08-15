<?php
/**
* Model for manage P_job Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_job extends Abstract_model {

	public $table			= "recruitment.p_job";
	public $pkey			= "job_id";
	public $alias			= "job";

	public $fields 			= array(
								'job_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_job'),
								'job_code'	        => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Kode Lamaran'),
								'job_name'	        => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nama Lamaran'),
								'description'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
								
								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "job.*";
	public $fromClause 		= "recruitment.p_job as job";

	public $refs			= array('recruitment.p_job_posting' => 'job_id');

	public $comboDisplay	= array();

	function __construct() {
		parent::__construct();
	}

	function validate() {
	    $ci =& get_instance();
	    $user_name = $ci->session->userdata('user_name');
	    
		if($this->actionType == 'CREATE') {
			//do something
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_job','job_id');
			
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

	public function getListJob(){
		//$q = $this->db->get('recruitment.p_job');
		$sql = "select a.*,b.job_code,b.job_name from recruitment.p_job_posting AS a
			  inner join recruitment.p_job AS b ON a.job_id = b.job_id
			  WHERE a.is_active = 'Y' and publish_status = 'Y'
			 ";

		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getListPengumuman(){
		if($this->input->post('id')){
			$this->db->where('announcement_id',$this->input->post('id'));
		}
		$this->db->where('publish_status','Y');
		$q = $this->db->get('recruitment.p_announcement');
		return $q->result();
	}



}

/* End of file p_job.php */
/* Location: ./application/models/recruitment/p_job.php */