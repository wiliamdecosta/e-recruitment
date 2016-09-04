<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Excel_pelamar extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function download_pelamar() {

        $this->load->model('recruitment/p_applicant');
        $table = $this->p_applicant;

        $items = $table->getAll(0,-1);

        startExcel('daftar_pelamar_'.date('Ymd').'.xls');
        echo '<html>';
        echo '<head>
                <title>Pelamar</title>
              </head>
              <body>';

        echo '<h1>Daftar Pelamar</h1>';
        echo '<table border="1">';
        echo '<tr>
                <th>No</th>
                <th>Tgl Daftar</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>IPK</th>
                <th>Pendidikan Terakhir</th>
                <th>Jurusan</th>
                <th>Domisili</th>
                <th>Tgl Lahir</th>
                <th>No Telp/HP</th>
             </tr>';

        $no = 1;
        foreach($items as $item) {
            echo '<tr>';
            echo '<td>'.$no++.'</td>';
            echo '<td>'.$item['created_date'].'</td>';
            echo '<td>'.$item['applicant_fullname'].'</td>';
            echo '<td align="center">'.$item['gender'].'</td>';
            echo '<td align="right">'.$item['applicant_ipk'].'</td>';
            echo '<td>'.$item['education_code'].'</td>';
            echo '<td>'.$item['major_code'].'</td>';
            echo '<td>'.$item['applicant_city'].'</td>';
            echo '<td>'.$item['applicant_date_of_birth'].'</td>';
            echo '<td>'.$item['applicant_telp'].' / '.$item['applicant_hp'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</body>
            </html>';
        exit;
    }

    function download_pelamar_apply() {

        $job_posting_id = $this->input->get('job_posting_id');
        $this->load->model('recruitment/t_applicant_job');
        $table = $this->t_applicant_job;

        $table->setCriteria('applicant_job.job_posting_id = '.$job_posting_id);
        $items = $table->getAll(0,-1);


        $this->load->model('recruitment/p_job_posting');
        $tableJobPosting = $this->p_job_posting;
        $itemJobPosting = $tableJobPosting->get($job_posting_id);


        startExcel('daftar_pelamar_'.date('Ymd').'.xls');
        echo '<html>';
        echo '<head>
                <title>Pelamar</title>
              </head>
              <body>';

        echo '<h1>Daftar Pelamar</h1>';
        echo '<h3>Kode Lamaran : '.$itemJobPosting['job_code'].' <br>
                  Nomor Lamaran : '.$itemJobPosting['posting_no'].'</h3>';

        echo '<table border="1">';
        echo '<tr>
                <th>No</th>
                <th>Tgl Daftar</th>
                <th>Tgl Apply</th>
                <th>Nomor Registrasi</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>IPK</th>
                <th>Pendidikan Terakhir</th>
                <th>Jurusan</th>
                <th>Domisili</th>
                <th>Tgl Lahir</th>
                <th>No Telp/HP</th>
                <th>Approve (Y/N)?</th>
                <th>Panggilan Interview (Y/N)?</th>
                <th>Tgl Email Interview</th>
             </tr>';


        $no = 1;
        foreach($items as $item) {
            echo '<tr>';
            echo '<td>'.$no++.'</td>';
            echo '<td>'.$item['tgl_daftar'].'</td>';
            echo '<td>'.$item['created_date'].'</td>';
            echo '<td>'.$item['applicant_no_reg'].'</td>';
            echo '<td>'.$item['applicant_fullname'].'</td>';
            echo '<td align="center">'.$item['gender'].'</td>';
            echo '<td align="right">'.$item['applicant_ipk'].'</td>';
            echo '<td>'.$item['education_code'].'</td>';
            echo '<td>'.$item['major_code'].'</td>';
            echo '<td>'.$item['applicant_city'].'</td>';
            echo '<td>'.$item['applicant_date_of_birth'].'</td>';
            echo '<td>'.$item['applicant_telp'].' / '.$item['applicant_hp'].'</td>';
            echo '<td align="center">'.$item['is_approve'].'</td>';
            echo '<td align="center">'.$item['is_send_email'].'</td>';
            echo '<td>'.$item['send_email_date'].'</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</body>
            </html>';
        exit;
    }


    function download_pelamar_lulus() {

        $job_posting_id = $this->input->get('job_posting_id');
        $this->load->model('recruitment/t_applicant_job');
        $table = $this->t_applicant_job;

        $table->setCriteria("applicant_job.passed_status = 'Y'");
        $table->setCriteria('applicant_job.job_posting_id = '.$job_posting_id);

        $items = $table->getAll(0,-1);


        $this->load->model('recruitment/p_job_posting');
        $tableJobPosting = $this->p_job_posting;
        $itemJobPosting = $tableJobPosting->get($job_posting_id);


        startExcel('daftar_pelamar_'.date('Ymd').'.xls');
        echo '<html>';
        echo '<head>
                <title>Pelamar</title>
              </head>
              <body>';

        echo '<h1>Daftar Pelamar Lulus</h1>';
        echo '<h3>Kode Lamaran : '.$itemJobPosting['job_code'].' <br>
                  Nomor Lamaran : '.$itemJobPosting['posting_no'].'</h3>';

        echo '<table border="1">';
        echo '<tr>
                <th>No</th>
                <th>Tgl Daftar</th>
                <th>Tgl Apply</th>
                <th>Nomor Registrasi</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>IPK</th>
                <th>Pendidikan Terakhir</th>
                <th>Jurusan</th>
                <th>Domisili</th>
                <th>Tgl Lahir</th>
                <th>No Telp/HP</th>
                <th>Approve (Y/N)?</th>
                <th>Panggilan Interview (Y/N)?</th>
                <th>Tgl Email Interview</th>
             </tr>';


        $no = 1;
        foreach($items as $item) {
            echo '<tr>';
            echo '<td>'.$no++.'</td>';
            echo '<td>'.$item['tgl_daftar'].'</td>';
            echo '<td>'.$item['created_date'].'</td>';
            echo '<td>'.$item['applicant_no_reg'].'</td>';
            echo '<td>'.$item['applicant_fullname'].'</td>';
            echo '<td align="center">'.$item['gender'].'</td>';
            echo '<td align="right">'.$item['applicant_ipk'].'</td>';
            echo '<td>'.$item['education_code'].'</td>';
            echo '<td>'.$item['major_code'].'</td>';
            echo '<td>'.$item['applicant_city'].'</td>';
            echo '<td>'.$item['applicant_date_of_birth'].'</td>';
            echo '<td>'.$item['applicant_telp'].' / '.$item['applicant_hp'].'</td>';
            echo '<td align="center">'.$item['is_approve'].'</td>';
            echo '<td align="center">'.$item['is_send_email'].'</td>';
            echo '<td>'.$item['send_email_date'].'</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</body>
            </html>';
        exit;
    }

}

/* End of file pages.php */
/* Location: ./application/controllers/excel_pelamar.php */