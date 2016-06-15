<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lowongan extends CI_Controller {

	function index() {
	   $this->load->view('portal/template/header');
	   $this->load->view('portal/lowongan');
	   $this->load->view('portal/template/footer');
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */