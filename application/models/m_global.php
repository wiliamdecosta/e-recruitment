<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_global extends CI_Model
{

    public function checkDuplicated($table, $field)
    {
        $this->db->where($field);
        $query = $this->db->get($table);

        return $query->num_rows();

    }

    public function email_checking($email){
        $this->db->where('applicant_email',$email);
        $query = $this->db->get('recruitment.p_applicant');

        return $query->num_rows();
    }

}