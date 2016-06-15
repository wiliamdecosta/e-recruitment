<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {

	function index() {
	   $this->load->view('portal/template/header');
	   $this->load->view('portal/beranda');
	   $this->load->view('portal/template/footer');
	}

	public function lowongan(){
		$this->load->view('portal/lowongan');
	}

	public function informasi(){
		$this->load->view('portal/informasi');
	}

	public function pengumuman(){
		$this->load->view('portal/pengumuman');
	}

	public function beranda(){
		$this->load->view('portal/pengumuman');
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */