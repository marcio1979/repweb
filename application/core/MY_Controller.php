<?php
class MY_Controller extends CI_Controller {
 
 	public function __construct()
    {
        parent::__construct();
        //forceSsl();
    	//ini_set('session.gc_maxlifetime', 300);
        $this->params = null;
        
    	if ($this->session->userdata("logged") != 1) {
    		
    		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    			echo 'Acesso Negado';
    			exit;
    		} else {
    			redirect(base_url('login'));
    			exit;
    		}
    	}			
    }
}