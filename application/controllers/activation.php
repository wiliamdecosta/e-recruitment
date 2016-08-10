<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activation extends CI_Controller
{

    function index()
    {
        $this->load->model('recruitment/p_applicant', 'p_applicant');

        $email = strtolower($this->input->get('email'));
        $token = $this->input->get('token');

        // Cek email applicant
        $email_count = $this->email_check($email);
        if ($email_count > 0) {
            $update_user = $this->p_applicant->updateUserActivation($email, $token);
            if ($update_user > 0) {
                $out['status'] = 'success';
                $out['message'] = 'Akun anda berhasil diaktivasi, silahkan login menggunakan email dan password pada saat registrasi';
                $this->load->view('portal/v_activation',$out);
            }else{
                $out['status'] = 'error';
                $out['message'] = 'Aktivasi gagal';

                $this->load->view('portal/v_activation',$out);
            }


        }else{
            $out['status'] = 'warning';
            $out['message'] = 'Email tidak terdaftar pada sistem kami, silahkan hubungin admin !';
            $this->load->view('portal/v_activation',$out);
            //echo json_encode($out);
        }


    }

    private function email_check($email)
    {
        $this->load->model('M_global');
        $check = $this->M_global->email_checking($email);
        return $check;
    }


}
