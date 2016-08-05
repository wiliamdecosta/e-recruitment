<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class P_announcement_controller
* @version 07/05/2015 12:18:00
*/
class P_announcement_controller {

    function read() {

		$page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',10);
        $sidx = getVarClean('sidx','str','announcement_id');
        $sord = getVarClean('sord','str','DESC');

    	$data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false);

    	try {

            $ci = & get_instance();
		    $ci->load->model('recruitment/p_announcement');
		    $table = $ci->p_announcement;

		    $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 0;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );
            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

    	return $data;
    }

    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                $data = $this->create();
            break;

            case 'edit' :
                $data = $this->update();
            break;

            case 'del' :
                $data = $this->destroy();
            break;
        }

        return $data;
    }


    function create() {

    	$ci = & get_instance();
		$ci->load->model('recruitment/p_announcement');
		$table = $ci->p_announcement;

		$data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false);

		$jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

		$table->actionType = 'CREATE';
		$errors = array();

		if (isset($items[0])){
			$numItems = count($items);
			for($i=0; $i < $numItems; $i++){
        		try{

        		    $table->db->trans_begin(); //Begin Trans

                    	$table->setRecord($items[$i]);
                    	$table->create();

            		$table->db->trans_commit(); //Commit Trans

        		}catch(Exception $e){

        		    $table->db->trans_rollback(); //Rollback Trans
        			$errors[] = $e->getMessage();
        		}
        	}

        	$numErrors = count($errors);
        	if ($numErrors > 0){
        		$data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
        	}else{
        		$data['success'] = true;
        		$data['message'] = 'Data added successfully';
        	}
        	$data['rows'] =$items;
		}else {

			try{
			    $table->db->trans_begin(); //Begin Trans

        	        $table->setRecord($items);
            	    $table->create();

                $table->db->trans_commit(); //Commit Trans

    	        $data['success'] = true;
    	        $data['message'] = 'Data added successfully';

	        }catch (Exception $e) {
	            $table->db->trans_rollback(); //Rollback Trans

	            $data['message'] = $e->getMessage();
                $data['rows'] = $items;
	        }

		}
		return $data;

    }

    function update() {

    	$ci = & get_instance();
		$ci->load->model('recruitment/p_announcement');
		$table = $ci->p_announcement;

		$data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false);

		$jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'UPDATE';

        if (isset($items[0])){
        	$errors = array();
			$numItems = count($items);
			for($i=0; $i < $numItems; $i++){
        		try{
        		    $table->db->trans_begin(); //Begin Trans

                		$table->setRecord($items[$i]);
                		$table->update();

                    $table->db->trans_commit(); //Commit Trans

            		$items[$i] = $table->get($items[$i][$table->pkey]);
        		}catch(Exception $e){
        		    $table->db->trans_rollback(); //Rollback Trans

        			$errors[] = $e->getMessage();
        		}
        	}

        	$numErrors = count($errors);
        	if ($numErrors > 0){
        		$data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
        	}else{
        		$data['success'] = true;
        		$data['message'] = 'Data update successfully';
        	}
        	$data['rows'] =$items;
		}else {

			try{
			    $table->db->trans_begin(); //Begin Trans

    	        	$table->setRecord($items);
        	        $table->update();

                $table->db->trans_commit(); //Commit Trans

    	        $data['success'] = true;
    	        $data['message'] = 'Data update successfully';

	            $data['rows'] = $table->get($items[$table->pkey]);
	        }catch (Exception $e) {
	            $table->db->trans_rollback(); //Rollback Trans

	            $data['message'] = $e->getMessage();
                $data['rows'] = $items;
	        }

		}
		return $data;

    }

    function destroy() {
    	$ci = & get_instance();
		$ci->load->model('recruitment/p_announcement');
		$table = $ci->p_announcement;

		$data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false);

		$jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

		try{
		    $table->db->trans_begin(); //Begin Trans

			$total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');

                    $table->remove($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                }

                $table->remove($items);
                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }

        return $data;

    }


    function send_email_announcement() {
        $ci = & get_instance();
        $ci->load->model('recruitment/t_applicant_job');
        $table = $ci->t_applicant_job;

        $data = array('success' => false, 'message' => '');
        $job_posting_id = getVarClean('job_posting_id', 'int', 0);
        $posting_no = getVarClean('posting_no', 'str', '');
        $announcement_id = getVarClean('announcement_id', 'int', 0);

        try{
            $table->db->trans_begin(); //Begin Trans

                /*execute send email query here */
                $table->setCriteria("applicant_job.job_posting_id = ".$job_posting_id);

                $table->setCriteria("upper(applicant_job.is_approve) = 'Y'");
                $table->setCriteria("upper(applicant_job.passed_status) = 'Y'");
                $table->setCriteria("upper(applicant_status.code) = 'ACTIVE'");

                $items = $table->getAll(0,-1);
                $num_records = count($items);

                if( $num_records > 0 ) {
                    $ci->load->model('email_sender');
                    $email_sender = $ci->email_sender;

                    $ci->load->model('recruitment/p_announcement');
                    $p_announcement = $ci->p_announcement;
                }

                $total_sending = 0;
                for($i = 0; $i < $num_records; $i++) {

                    /* Step 1: send email per applicant */
                    $email_sender->email()->clear();
                    $email_sender->email()->set_newline("\r\n");
                    $email_sender->email()->from($email_sender->get_config('smtp_user'),'PDAM Tirtawening');
                    $email_sender->email()->to( trim(strtolower($items[$i]['applicant_email'])) );
                    $email_sender->email()->subject('Pengumuman Lulus - PDAM Tirtawening');
                    $email_sender->email()->message( html_entity_decode('Selamat kepada '.$items[$i]['applicant_fullname'].' dengan No.Registrasi : '.$items[$i]['applicant_no_reg'].'.<br>Anda dinyatakan lulus dalam seleksi perektrutan dengan nomor lowongan : '.$posting_no.'.<br>Untuk informasi lebih lanjut silahkan cek website PDAM Tirtawening Kota Bandung <a href="http://www.pambdg.co.id">http://www.pambdg.co.id</a> ') );

                    if(! $email_sender->email()->send() ) {
                        throw new Exception($email_sender->email()->print_debugger());
                    }

                    $total_sending++;

                }

                if($total_sending > 0) {
                    $p_announcement->setEmailStatus($announcement_id);
                    $data['message'] = $total_sending.' email pengumuman lulus telah dikirim kepada '.$num_records.' Pelamar yang lulus';
                }else {
                   $data['message'] = 'Maaf, Data pelamar yang lulus masih kosong. Email pengumuman belum dikirim.';
                }

                $data['success'] = true;

            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
        }

        return $data;

    }

}

/* End of file p_email_template_controller.php */
/* Location: ./application/libraries/p_email_template_controller.php */