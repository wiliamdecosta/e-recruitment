<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller
{

    function index()
    {
        $this->load->view('portal/register');
    }

    public function register_action()
    {

        $email = strtolower($this->input->post('email'));
        $ktp_number = $this->input->post('ktp_number');
        $full_name = strtoupper($this->input->post('full_name'));
        $password = $this->input->post('password');
        $activation = md5(uniqid(rand(),true));

        $email_count = $this->email_check($email);
        if ($email_count > 0) {
            $out['success'] = false;
            $out['message'] = 'Email sudah terdaftar ! Silahkan menggunakan alamat email yang lain.';
            echo json_encode($out);
        } else {
            /* Register here & send mail */

            //1. Create user applicant
            try {
                $this->db->trans_begin();
                $create_user = $this->createUser($email, $password, $ktp_number, $full_name,$activation);
                if ($create_user > 0) {
                    //2. Send mail
                    $this->send_email_register($email,$activation,$full_name);
                    $this->db->trans_commit(); //Commit Trans
                }

            } catch (Exception $e) {
                $this->db->trans_rollback(); //Rollback Trans
                $data['message'] = $e->getMessage();
            }


            $out['success'] = true;
            $out['message'] = 'Silahkan cek email anda untuk aktivasi !';

            echo json_encode($out);
        }


    }

    private function email_check($email)
    {
        $this->load->model('M_global');
        $check = $this->M_global->email_checking($email);
        return $check;
    }

    function createUser($email, $password, $ktp_number, $full_name,$activation)
    {
        $this->load->model('recruitment/p_applicant', 'p_applicant');
        $create = $this->p_applicant->createUserRegister($email, $password, $ktp_number, $full_name,$activation);
        return $create;
    }

    function send_email_register($email,$activation,$full_name)
    {
        $this->load->model('email_sender');
        $this->email_sender->email()->clear();
        $this->email_sender->email()->set_newline("\r\n");
        $this->email_sender->email()->from($this->email_sender->get_config('smtp_user'), 'PDAM Tirtawening');
        $this->email_sender->email()->to($email);
        $this->email_sender->email()->subject('Account Acitvation');
        $this->email_sender->email()->message(html_entity_decode("Dear ".$full_name." , <br><br> ".
                                                                " Terima kasih telah melakukan pendaftaran di recruitment.pdambdg.co.id
                                                                 <br> Untuk mengaktifkan akun anda silahkan klik tautan berikut atau copy-paste pada browser
                                                                 <br>
                                                                ".site_url('activation')."?email=".urlencode($email)."&token=".$activation));

        if (!$this->email_sender->email()->send()) {
            throw new Exception($this->email_sender->email()->print_debugger());
        }

        $data['success'] = true;
        return $data;

    }


}