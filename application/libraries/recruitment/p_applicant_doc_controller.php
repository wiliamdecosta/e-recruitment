<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class P_applicant_doc_controller
* @version 07/05/2015 12:18:00
*/
class P_applicant_doc_controller {
    
    function read() {
		
		$page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',10);
        $sidx = getVarClean('sidx','str','p_doc_type_id');
        $sord = getVarClean('sord','str','DESC');
            	       
    	$data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false);
        
        $applicant_id = getVarClean('applicant_id','int',0);
        
    	try {
            
            $ci = & get_instance();
		    $ci->load->model('recruitment/p_applicant_doc');
		    $table = $ci->p_applicant_doc;
		    
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
            $req_param['where'] = array("applicant_doc.applicant_id = ".$applicant_id);
            
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
		$ci->load->model('recruitment/p_applicant_doc');
		$table = $ci->p_applicant_doc;
				
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
		$ci->load->model('recruitment/p_applicant_doc');
		$table = $ci->p_applicant_doc;

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
		$ci->load->model('recruitment/p_applicant_doc');
		$table = $ci->p_applicant_doc;

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
}

/* End of file P_applicant_doc_controller.php */
/* Location: ./application/libraries/P_applicant_doc_controller.php */