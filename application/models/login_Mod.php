<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_Mod extends CI_Model {

		public function get_User($data){
			
        
            return $this->db->get_where('user',['email'=>$data])->row_array();
			
		}

		
}

?>