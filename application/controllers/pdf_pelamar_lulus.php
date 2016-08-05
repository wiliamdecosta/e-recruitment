<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require('fpdf/fpdf.php');
class Pdf_pelamar_lulus extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function show() {

        $job_posting_id = $this->input->get('id');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('assets/img/logo_pdam.png',10,6,20);

        $pdf->SetTextColor(41,158,220);
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(190,8,'Daftar Peserta Lulus Seleksi Perekrutan','',0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',12);

        $this->load->model('recruitment/p_job_posting');
        $job_posting = $this->p_job_posting;
        $item_job = $job_posting->get($job_posting_id);
        $pdf->Cell(190,8,'( Kode Lowongan : '.$item_job['posting_no'].' , Tgl Lowongan : '.$item_job['posting_date'].' )','',0,'C');

        $this->load->model('recruitment/t_applicant_job');
        $table = $this->t_applicant_job;

        $table->setCriteria("applicant_job.job_posting_id = ".$job_posting_id);
        $table->setCriteria("applicant_job.passed_status = 'Y'");

        $items = $table->getAll(0,-1);

        $pdf->SetFillColor(186,211,28);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(174,201,91);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('Arial','B',9);

        $pdf->Ln(15);
        $header = array('No', 'Nama', 'No Registrasi', 'Email', 'Tgl Apply');
        $width = array(10, 50, 40, 60, 30);
        for($i = 0; $i < count($header); $i++)
            $pdf->Cell($width[$i],7,$header[$i],1,0,'C',true);
        $pdf->Ln();

        $pdf->SetFillColor(224,235,255);
        $pdf->SetTextColor(0);
        // Data
        $fill = false;
        $i = 1;
        foreach($items as $row) {
            $pdf->Cell($width[0],5,$i++,'LRTB',0,'C',$fill);
            $pdf->Cell($width[1],5,$row['applicant_fullname'],'LRTB',0,'L',$fill);
            $pdf->Cell($width[2],5,$row['applicant_no_reg'],'LRTB',0,'C',$fill);
            $pdf->Cell($width[3],5,$row['applicant_email'],'LRTB',0,'L',$fill);
            $pdf->Cell($width[4],5,$row['created_date'],'LRTB',0,'C',$fill);
            $pdf->Ln();
            $fill = !$fill;
        }

        $pdf->Output();
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/portal.php */