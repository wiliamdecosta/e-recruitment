<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| PATHS
| -------------------------------------------------------------------
|
*/
$ci = & get_instance();
$ci->load->helper('url');

$config['WS_URL'] = define('WS_URL',base_url().'index.php/ws/json/');
$config['WS_JQGRID'] = define('WS_JQGRID',base_url().'index.php/ws/json_jqgrid/');
$config['BASE_URL'] = define('BASE_URL',base_url().'index.php/');
$config['IMAGE_APP_PATH'] = define('IMAGE_APP_PATH',base_url().'application/third_party/images/');

$config['BS_PATH'] = define('BS_PATH',base_url().'application/third_party/assets/');
$config['BS_CSS_PATH'] = define('BS_CSS_PATH',base_url().'application/third_party/assets/css/');
$config['BS_JS_PATH'] = define('BS_JS_PATH',base_url().'application/third_party/assets/js/');

$config['UPLOAD_PATH'] = define('UPLOAD_PATH',base_url().'application/third_party/applicant_docs/');

/* End of file autoload.php */
/* Location: ./application/config/paths.php */