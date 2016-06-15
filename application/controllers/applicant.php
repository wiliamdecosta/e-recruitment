<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Applicant extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if(!$this->session->userdata('applicant_id')){
            redirect(base_url() . "login");
        }

    }
    function index()
    {
        $this->load->view('applicant/template/header');
        $this->load->view('applicant/index');
        $this->load->view('applicant/template/footer');
    }

    public function doc(){
        $this->load->view('applicant/document');
    }

    public function lamaran(){
        $this->load->view('applicant/lamaran');
    }

    public function biodata(){
        $this->load->model('m_user');
        $email = $this->session->userdata('applicant_email');
        $data['row'] = $this->m_user->getApplicantItem($email);
        $this->load->view('applicant/applicant_detail',$data);
    }

}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */