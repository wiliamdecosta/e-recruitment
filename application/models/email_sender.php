<?php
/**
* Class Abstract Model for CRUD
* @author Wiliam Decosta <wiliamdecosta@gmail.com>
* @version 1.0
* @date 07/05/2015 12:14:51
*/
class Email_sender extends  CI_Model {


    public $config_email = array();

    public $mail_ = null;

    function __construct() {

        parent::__construct();

		$this->config_email['protocol']   = 'smtp';
		$this->config_email['mail_path']  = 'ssl://smtp.gmail.com';
        $this->config_email['smtp_host']  = 'ssl://smtp.gmail.com';
        $this->config_email['smtp_port']  = 465;
        $this->config_email['smtp_user']  = 'wiliamdecosta@gmail.com';
        $this->config_email['smtp_pass']  = 'xxx';
		$this->config_email['mailtype']   = 'html';
		$this->config_email['charset']    = 'utf-8';

        $this->load->library('email', $this->config_email);
        $this->mail_ = $this->email;

	}

	public function email() {
	    return $this->mail_;
	}

	public function get_config($conf = "") {
        if(empty($conf))
            return $this->config_email;
	    return $this->config_email[$conf];
	}

    public function getHTMLTagOpener() {

        return '<html>
                    <head>
                        <title> Email Interview </title>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    </head>
                    <body>';
    }

    public function getHTMLTagCloser() {
        return '    </body>
                </html>';
    }
}