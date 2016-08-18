<?php

/**
 * Model for manage P_job_posting Data
 * @author wiliamdecosta@gmail.com
 * @version 07/05/2015 12:14:29
 *
 */
class P_job_posting extends Abstract_model
{

    public $table = "recruitment.p_job_posting";
    public $pkey = "job_posting_id";
    public $alias = "job_posting";

    public $fields = array(
					        'job_posting_id' => array('pkey' => true, 'type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 'ID P_job_posting'),
					        'job_id' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'ID Job'),
					        'posting_date' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tgl Posting'),
					        'posting_no' => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Nomor Lowongan'),
					        'posting_short_desc' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Deskripsi'),
					        'posting_min_ipk' => array('nullable' => false, 'type' => 'float', 'unique' => false, 'display' => 'Min.IPK'),
					        'is_active' => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Is Active'),
					        'description' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Vacancy Letter'),
					        'publish_status' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status Publish'),
					        'gender'	    		=> array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Gender'),

					        /* khusus untuk created_date, created_by, updated_date, updated_by --> nullable : true */
					        'created_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
					        'created_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
					        'updated_date' => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
					        'updated_by' => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By')
    				);

    public $selectClause = "job_posting.job_posting_id, job_posting.job_id, job_posting.posting_date, job_posting.posting_short_desc, job_posting.posting_min_ipk, job_posting.posting_no, job_posting.is_active, job_posting.publish_status, job_posting.description,
	                                job_posting.created_date, job_posting.created_by, job_posting.updated_date, job_posting.updated_by,
	                                job.job_code,job_posting.gender
	                            ";
    public $fromClause = "recruitment.p_job_posting as job_posting
	                            LEFT JOIN recruitment.p_job AS job ON job_posting.job_id = job.job_id";

    public $refs = array('recruitment.p_job_education' => 'job_posting_id',
        					'recruitment.p_job_major' => 'job_posting_id');

    public $comboDisplay = array();

    function __construct()
    {
        parent::__construct();
    }

    function validate()
    {
        $ci =& get_instance();
        $user_name = $ci->session->userdata('user_name');

        if ($this->actionType == 'CREATE') {
            //do something
            $this->record[$this->pkey] = $this->generate_id('recruitment', 'p_job_posting', 'job_posting_id');

            $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $user_name;
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;

        } else {
            //do something
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $user_name;
        }
        return true;
    }

    public function submitJob()
    {
        $job_posting_id = $this->input->post('job_post');

        //0.Cek Gender
        $applicant_detail = $this->m_applicant->getApplicantDetail();
        $app_gender = $applicant_detail->gender;

        $job_gender = $this->getJobIPK($job_posting_id)->gender;
        if ($job_gender != "") {
            if ($job_gender !== $app_gender) {
                $out['success'] = false;
                $out['message'] = "Maaf anda tidak memenuhi syarat kualifikasi. Ref : Gender";
                echo json_encode($out);
                exit;
            }
        }


        //1.Cek sudah apply
        if ($this->checkJobSubmit($job_posting_id) > 0) {
            $out['success'] = false;
            $out['message'] = 'Anda telah memasukan lamaran untuk lowongan ini !';
            echo json_encode($out);
            exit;
        }

        //2.Cek Kelengkapan
        /*$dok = $this->checkDok();
        if(count($dok) > 0){
            $out['success'] = false;
            $out['message'] = "Dokumen  <b>".implode(" , ",$dok) . "</b> harus dilengkapi!!!" ;
            echo json_encode($out);
            exit;
        }*/

        //3.Cek Syarat


        //3.a Cek education
        $edu = $this->getJobEducation($job_posting_id, $app_edu_id = null)->num_rows();
        if ($edu > 0) { // Ada syarat education
            // Cek syarat edu
            $applicant_detail = $this->m_applicant->getApplicantDetail();
            $app_edu_id = $applicant_detail->education_id;
            $app_major_id = $applicant_detail->major_id;

            $edu_syarat = $this->getJobEducation($job_posting_id, $app_edu_id)->num_rows();
            if ($edu_syarat > 0) {

            } else {
                $out['success'] = false;
                $out['message'] = "Maaf anda tidak memenuhi syarat kualifikasi. Ref : Education";
                echo json_encode($out);
                exit;
            }

        }
        //3.b Cek major
        $major = $this->getJobMajor($job_posting_id, $app_major_id = null)->num_rows();
        if ($major > 0) { // Ada syarat major
            // Cek syarat major
            $applicant_detail = $this->m_applicant->getApplicantDetail();
            $app_major_id = $applicant_detail->major_id;

            $major_syarat = $this->getJobEducation($job_posting_id, $app_major_id)->num_rows();
            if ($major_syarat > 0) {

            } else {
                $out['success'] = false;
                $out['message'] = "Maaf anda tidak memenuhi syarat kualifikasi. Ref : Major";
                echo json_encode($out);
                exit;
            }

        }

        //4.cek IPK
        $ipk_job = $this->getJobIPK($job_posting_id)->posting_min_ipk;
        $applicant_detail = $this->m_applicant->getApplicantDetail();
        $app_ipk = $applicant_detail->applicant_ipk;

        if ($app_ipk < $ipk_job) {
            $out['success'] = false;
            $out['message'] = "Maaf anda tidak memenuhi syarat kualifikasi. Ref : IPK";
            echo json_encode($out);
            exit;
        }

        // Insert Data Job Applicant
        try {
            $this->db->trans_begin();
            $insert = $this->insertSubmitApplicant($job_posting_id);
            if ($insert['status'] > 0) {
                // Send Mail
                $this->send_email_job_submit($applicant_detail->applicant_email, $insert['noreg']);
                $this->db->trans_commit(); //Commit Trans

                $out['success'] = true;
                $out['message'] = "Lamaran berhasil disubmit ! Silahkan cek email Anda untuk informasi nomor registrasi.";
                echo json_encode($out);
            } else {
                $out['success'] = false;
                $out['message'] = "Tidak dapat submit lamaran";
            }

        } catch (Exception $e) {
            $this->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
        }


    }

    public function getJobIPK($job_posting_id)
    {
        $this->db->where('job_posting_id', $job_posting_id);
        return $this->db->get('recruitment.p_job_posting')->row();

    }

    public function checkJobSubmit($job_posting_id)
    {
        $this->db->where(array(
            'job_posting_id' => $job_posting_id,
            'applicant_id' => $this->session->userdata('applicant_id')
        ));
        return $this->db->get('recruitment.t_applicant_job')->num_rows();
    }

    public function getJobEducation($job_posting_id, $app_edu_id)
    {
        $sql = "select a.*,b.education_code from recruitment.p_job_education AS a
			  inner join recruitment.p_education AS b ON a.education_id = b.education_id
			  WHERE a.job_posting_id = " . $job_posting_id;

        if ($app_edu_id) {
            $sql .= "AND a.education_id = " . $app_edu_id;
        }

        $q = $this->db->query($sql);
        return $q;
    }

    public function getJobMajor($job_posting_id, $app_major_id)
    {
        $sql = "select a.*,b.major_code from recruitment.p_job_major AS a
			  inner join recruitment.p_college_major AS b ON a.job_major_id = b.major_id
			  WHERE a.job_posting_id = " . $job_posting_id;

        if ($app_major_id) {
            $sql .= "AND a.major_id = " . $app_major_id;
        }
        $q = $this->db->query($sql);
        return $q;
    }

    public function insertSubmitApplicant($job_posting_id)
    {
        $id = $this->generate_id('recruitment', 't_applicant_job', 'applicant_job_id');
        $noreg = $this->genNoReg();

        $data = array(
            "applicant_job_id" => $id,
            "job_posting_id" => $job_posting_id,
            "applicant_id" => $this->session->userdata('applicant_id'),
            "applicant_no_reg" => $noreg,
            "is_approve" => 'N',
			"is_send_email" => 'N'

        );
        $this->db->set('created_date', 'NOW()', FALSE);
        $this->db->set('created_by', $this->session->userdata('applicant_fullname'));
        $this->db->set('updated_date', 'NOW()', FALSE);
        $this->db->set('updated_by', $this->session->userdata('applicant_fullname'));


        $this->db->insert('recruitment.t_applicant_job', $data);
        $data['status'] = $this->db->affected_rows();
        $data['noreg'] = $noreg;

        return $data;
    }

    private function genNoReg()
    {
        $sql = "SELECT COALESCE(MAX(applicant_no_reg)+1,2000001) AS noreg from recruitment.t_applicant_job";
        $q = $this->db->query($sql);
        return $q->row()->noreg;

    }

    function send_email_job_submit($email, $noreg)
    {
        $this->load->model('email_sender');
        $this->email_sender->email()->clear();
        $this->email_sender->email()->set_newline("\r\n");
        $this->email_sender->email()->from($this->email_sender->get_config('smtp_user'), 'PDAM Tirtawening');
        $this->email_sender->email()->to($email);
        $this->email_sender->email()->subject('Job Submited');
        $this->email_sender->email()->message(html_entity_decode("Dear " . $this->session->userdata('applicant_fullname') . " , <br><br> " .
                                                                " Lamaran berhasil disubmit .
                                                                 <br> Nomor Registrasi anda adalah
                                                                 <br>
                                                                 <h4> " . $noreg . " </h4>
                                                                 <br>
                                                                 <br>
                                                                Silahkan cek website resmi kami untuk informasi selanjutnya"));

        if (!$this->email_sender->email()->send()) {
            throw new Exception($this->email_sender->email()->print_debugger());
        }

        $data['success'] = true;
        return $data;

    }

    public function checkDok()
    {
        $list_dok = $this->m_user->getListDokumen();
        $arr_0 = array();
        foreach ($list_dok as $dok) {
            if ($dok->doc_count == 0) {
                $arr_0[] = $dok->description;
            }
        }
        return $arr_0;
    }


}

/* End of file p_job_posting.php */
/* Location: ./application/models/recruitment/p_job_posting.php */