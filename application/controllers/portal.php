<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {

	function index() {
	   $this->load->view('portal/template/header');
	   $this->load->view('portal/beranda');
	   $this->load->view('portal/template/footer');

	}

	public function lowongan(){
		$this->load->model('recruitment/p_job','m_job');

		$data['job'] = $this->m_job->getListJob();
		$this->load->view('portal/lowongan',$data);
	}

	public function informasi(){
		$this->load->model('recruitment/p_job','m_job');

		$data['announcer'] = $this->m_job->getListPengumuman();
		$this->load->view('portal/informasi',$data);
	}

	public function getAnnouncer(){
		$this->load->model('recruitment/p_job','m_job');

		$data['announcer'] = $this->m_job->getListPengumuman();
		$this->load->view('portal/pengumuman',$data);
	}

	public function pengumuman(){
		$this->load->view('portal/pengumuman');
	}

	public function beranda(){
		$this->load->view('portal/beranda');
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */