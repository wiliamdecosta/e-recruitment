<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function index()
    {
        $this->load->model('base/variables','variables');
        $enabled_frontend = $this->variables->get_var('frontend-enabled');

        if($enabled_frontend == 'N') {
            $this->load->view('portal/disabled_page');
        }else {
            $this->load->view('portal/login');
        }
    }


    public function login_action()
    {
        $this->load->model('M_user');
        $email = $this->security->xss_clean($this->input->post('email'));
        $pwd = md5($this->security->xss_clean($this->input->post('password')));

        $rc = $this->M_user->getApplicantDetail($this->security->xss_clean($email), $pwd)->result();

        if (count($rc) == 1 AND $rc[0]->applicant_password == $pwd) {

            // Cek account status
            if($rc[0]->applicant_status_id == 1){
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
            }else{
                if($rc[0]->applicant_status_id == 2){
                    $data['success'] = false;
                    $data['message'] = "Akun anda diblock, silahkan hubungin admin!";
                    echo json_encode($data);
                }
                if($rc[0]->applicant_status_id == 3){
                    $data['success'] = false;
                    $data['message'] = "Akun anda belum diaktivasi, silahkan cek email anda untuk melakukan aktivasi!";
                    echo json_encode($data);
                }
            }



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