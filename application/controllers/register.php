<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function index() {
	   $this->load->view('portal/register');
	}

	public function register_action(){

		$out['success'] = true;
		$out['message'] = 'Silahkan cek email anda untuk verifikasi !';
		echo json_encode($out);
	}


}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */