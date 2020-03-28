<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_Mod extends CI_Model {

		public function get_User($data){
            return $this->db->get_where('user',['email'=>$data])->row_array();
			
		}
		public function get_role($id){
			if($admin=$this->db->get_where('admin',['id'=>$id])->row()){
				return $admin->role_id;
			} elseif($sekretaris=$this->db->get_where('sekretaris',['id'=>$id])->row()){
				return $sekretaris->role_id;
			} elseif($direktur=$this->db->get_where('direktur',['id'=>$id])->row()){
				return $direktur->role_id;
			}elseif($wadir=$this->db->get_where('wadir',['id'=>$id])->row()){
				return $wadir->role_id;
			}elseif($adum=$this->db->get_where('adum',['id'=>$id])->row()){
				return $adum->role_id;
			}
		}

		
}

?>