<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_Mod extends CI_Model {

		// public function get_User($data){
        //     return $this->db->get_where('user',['email'=>$data])->row_array();
			
		// }

		public function get_User($data){
            return $this->db->get_where('user',['user_name'=>$data])->row_array();
			
		}

		public function get_role($id){
			// $jbtn=$this->db->get_where('penguna',['id'=>$id])->row();
			// return $jbtn->role_id;
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
			}elseif($pegawai=$this->db->get_where('pegawai',['id'=>$id])->row()){
				return $pegawai->role_id;
			}elseif($admin_kepeg=$this->db->get_where('admin_kepeg',['id'=>$id])->row()){
				return $admin_kepeg->role_id;
			}
		}

		// public function get_penguna($id){
		// 	return $this->db->get_where('penguna',['id'=>$id])->result();
		// }

		

		public function get_admin($id){
			return $admin=$this->db->get_where('admin',['id'=>$id])->result();
			// return $admin->role_id;
		}

		public function get_sekretaris($id){
			return $sekretaris=$this->db->get_where('sekretaris',['id'=>$id])->result();
			// return $sekretaris->role_id;
		}

		public function get_direktur($id){
			return $direktur=$this->db->get_where('direktur',['id'=>$id])->result();
			// return $direktur->role_id;
		}

		public function get_wadir($id){
			return $wadir=$this->db->get_where('wadir',['id'=>$id])->result();
			// return $wadir->role_id;
		}

		public function get_adum($id){
			return $adum=$this->db->get_where('adum',['id'=>$id])->result();
			// return $adum->role_id;
		}

		public function get_pegawai($id){
			return $pegawai=$this->db->get_where('pegawai',['id'=>$id])->result();
			// return $adum->role_id;
		}

		public function get_adminkepeg($id){
			return $admin_kepeg=$this->db->get_where('admin_kepeg',['id'=>$id])->result();
			// return $adum->role_id;
		}
}

?>