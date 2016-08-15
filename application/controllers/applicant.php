<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Applicant extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('applicant_id')) {
            redirect(base_url() . "login");
        }
        $this->load->model('m_user');
        $this->load->model('recruitment/p_applicant','m_applicant');
        $this->load->model('recruitment/p_job','m_job');
        $this->load->model('recruitment/p_job_posting','m_job_posting');

    }

    function index()
    {
        $this->load->view('applicant/template/header');
        $this->load->view('applicant/index');
        $this->load->view('applicant/template/footer');
    }

    public function doc()
    {
        $data['dokumen'] = $this->m_user->getListDokumen();
        $this->load->view('applicant/document', $data);
    }

    public function lamaran()
    {
        $data['job'] = $this->m_job->getListJob();
        $this->load->view('applicant/lamaran',$data);
    }

    public function biodata()
    {

        $email = $this->session->userdata('applicant_email');
        $data['row'] = $this->m_user->getApplicantItem($email);
        $this->load->view('applicant/applicant_detail', $data);
    }

    public function updateData()
    {
        $update = $this->m_user->updateUserApplicant();
        if ($update > 0) {

            //Update session Name
            $this->session->set_userdata('applicant_fullname', strtoupper($this->input->post('inFullName')));

            $out['success'] = true;
            $out['message'] = 'Data berhasil diupdate';
            echo json_encode($out);

        } else {
            $out['success'] = false;
            $out['message'] = 'Data tidak berhasil diupdate';
            echo json_encode($out);
        }

    }

    public function uploadDokumen()
    {
        // Upload Process
        $sub_dir = md5($this->session->userdata('applicant_email'));
        $dir = base_url() . 'application/third_party/applicant_docs/' . $sub_dir;


        if (!is_dir('./application/third_party/applicant_docs/' . $sub_dir)) {
            mkdir('./application/third_party/applicant_docs/' . $sub_dir, 0777, true);
            $myfile = fopen('./application/third_party/applicant_docs/' . $sub_dir . '/index.html', 'w') or die('Unable to open file!');
            $txt = "<html>
                    <head>
                        <title>403 Forbidden</title>
                    </head>
                    <body>

                    <p>Directory access is forbidden.</p>

                    </body>
                    </html>";
            fwrite($myfile, $txt);
        }


        $config['upload_path'] = './application/third_party/applicant_docs/' . $sub_dir;
        $config['allowed_types'] = 'jpg|png|gif';
        $config['max_size'] = '3072'; //3mb
        $config['overwrite'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);


        if (!$this->upload->do_upload("filename")) {

            $error = $this->upload->display_errors();

            $dok['dokumen'] = $this->m_user->getListDokumen();
            echo $this->load->view('applicant/document', $dok);
            echo "<script> swal('','.$error.','error')</script>";

         //   echo ($error);
        } else {
            // Do Upload
            $data = $this->upload->data();

            $this->m_applicant->addDokumenApplicant($data['file_name']);
            $dok['dokumen'] = $this->m_user->getListDokumen();
            echo $this->load->view('applicant/document', $dok);

        }

    }

    public function deleteDokumen(){
        $del = $this->m_applicant->delDocApplicant();
        if($del > 0){
            $dok['dokumen'] = $this->m_user->getListDokumen();
           echo $this->load->view('applicant/document', $dok);
        }else{
            echo $this->doc();
            echo "<script> swal('','Gagal menghapus data','error')</script>";
        }
    }

    public function getJobDetail()
    {
        $job_post_id = intval($this->input->post('job_id'));
        if($job_post_id){
            $data['edu'] = $this->m_job_posting->getJobEducation($job_post_id,$app_edu_id=null);
            $data['major'] = $this->m_job_posting->getJobMajor($job_post_id,$app_major_id=null);
            $data['job_detail'] = $this->m_job_posting->getJobIPK($job_post_id);

            $this->load->view('portal/detail_job', $data);
        }


    }

    public function submitJob(){
        $this->m_job_posting->submitJob();
    }





}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */