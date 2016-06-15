<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function index()
    {
        $this->load->view('portal/login');
    }


    public function login_action()
    {
        $this->load->model('M_user');
        $email = $this->security->xss_clean($this->input->post('email'));
        $pwd = md5($this->security->xss_clean($this->input->post('password')));

        $rc = $this->M_user->getApplicantDetail($this->security->xss_clean($email), $pwd)->result();

        if (count($rc) == 1 AND $rc[0]->applicant_password == $pwd) {
            $sessions = array(
                'applicant_fullname' => $rc[0]->applicant_fullname,
                'applicant_id' => $rc[0]->applicant_id,
                'applicant_email' => $rc[0]->applicant_email
            );
            //Set session
            $this->session->set_userdata($sessions);

            $data['success'] = true;
            $data['message'] = "Login Sukses";
            echo json_encode($data);
        } else {
            $data['success'] = false;
            $data['message'] = "Email atau Password tidak valid";
            echo json_encode($data);
        }

    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . "login");
    }

}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */