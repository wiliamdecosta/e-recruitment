<?php

class M_user extends CI_Model
{

    function __construct()
    {
        parent::__construct();

    }

    public function getLists($cond = "")
    {
        $result = array();
        $sql = "SELECT * FROM APP_USERS";
        if ($cond != '') $sql .= " WHERE " . $cond;
        $sql .= " ORDER BY USER_NAME";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) $result = $q->result();
        return $result;
    }

    public function getUserPwd($username, $pwd)
    {
        $sql = "SELECT * FROM admin WHERE admin_user = ? AND admin_password = ? ";
        $qs = $this->db->query($sql, array($username, $pwd));
        return $qs;
    }

    public function getApplicantDetail($email, $pwd)
    {
        $sql = "SELECT * FROM recruitment.p_applicant WHERE applicant_email = ? AND applicant_password = ? ";
        $qs = $this->db->query($sql, array($email, $pwd));
        return $qs;
    }


    public function getApplicantItem($email)
    {
        $sql = "SELECT *, " .
            " EXTRACT(DAY FROM applicant_date_of_birth) as day, " .
            " EXTRACT(MONTH FROM applicant_date_of_birth) as month, " .
            " EXTRACT(YEAR FROM applicant_date_of_birth) as year " .
            " FROM recruitment.p_applicant WHERE applicant_email = '" . $email . "'";
        $qs = $this->db->query($sql)->row();
        return $qs;
    }

    public function updateUserApplicant()
    {
        $inFullName = strtoupper($this->input->post('inFullName'));
        $inKTP = $this->input->post('inKTP');
        $slJurusan = $this->input->post('slJurusan');
        $slPendidikan = $this->input->post('slPendidikan');
        $inHP = $this->input->post('inHP');
        $inTelp = $this->input->post('inTelp');
        $hari = $this->input->post('hari');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $inKotaAsal = strtoupper($this->input->post('inKotaAsal'));
        $inAddress = ucfirst($this->input->post('inAddress'));
        $inIPK = floatval($this->input->post('inIPK'));

        $dateofbirth = $tahun . '-' . $bulan . '-' . $hari;
        $applicant_id = $this->session->userdata('applicant_id');

        $data = array(
            'major_id' => $slJurusan,
            'education_id' => $slPendidikan,
            'applicant_fullname' => $inFullName,
            'applicant_ktp_no' => $inKTP,
            'applicant_telp' => $inTelp,
            'applicant_hp' => $inHP,
            'applicant_date_of_birth' => $dateofbirth,
            'applicant_address' => $inAddress,
            'applicant_city' => $inKotaAsal,
            'applicant_ipk' => $inIPK
        );

        $this->db->where('applicant_id', $applicant_id);
        $this->db->update('recruitment.p_applicant', $data);

        return $this->db->affected_rows();

    }

    public function getListDokumen()
    {
        $sql = " SELECT a.applicant_doc_file, b.* , " .
            " CASE WHEN a.applicant_doc_file is null THEN 0  " .
            " ELSE 1 " .
            " END as doc_count" .
            " FROM " .
            " (SELECT * FROM recruitment.p_applicant_doc " .
            " WHERE applicant_id =" . $this->session->userdata('applicant_id') . ") as a " .
            " RIGHT JOIN recruitment.p_doc_type as b ON a.p_doc_type_id = b.p_doc_type_id ";


        $qs = $this->db->query($sql)->result();
        return $qs;

    }


}

