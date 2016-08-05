<?php
/**
* Model for manage P_announcement Data
* @author wiliamdecosta@gmail.com
* @version 07/05/2015 12:14:29
*
*/

class P_announcement extends Abstract_model {

	public $table			= "recruitment.p_announcement";
	public $pkey			= "announcement_id";
	public $alias			= "announcement";

	public $fields 			= array(
								'announcement_id' 		    => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID Announcement'),
								'job_posting_id'	    	=> array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'ID Job Posting'),
								'announcement_title'	    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Judul Pengumuman'),
								'announcement_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Tanggal Pengumuman'),
								'announcement_letter'		=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Isi Pengumuman'),
								'publish_status'			=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status Publish'),
								'file_upload'				=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'File Upload'),
								'description'				=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),
								'send_mail_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Tanggal Pengiriman Email'),

								/* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
								'created_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
								'created_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
								'updated_date'	        => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
								'updated_by'	        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
							);

	public $selectClause 	= "announcement.*, job_posting.posting_no";
	public $fromClause 		= "recruitment.p_announcement as announcement
								LEFT JOIN recruitment.p_job_posting job_posting ON announcement.job_posting_id = job_posting.job_posting_id";

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
			$this->record[$this->pkey] = $this->generate_id('recruitment','p_announcement','announcement_id');

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

	function setEmailStatus($announcement_id) {
	    $sql = "UPDATE recruitment.p_announcement
	            SET send_mail_date = '".date('Y-m-d')."'
	            WHERE announcement_id = ".$announcement_id;
	    $this->db->query($sql);
	}

}

/* End of file P_email_template.php */
/* Location: ./application/models/recruitment/P_email_template.php */