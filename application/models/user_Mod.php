<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class user_Mod extends CI_Model {

        public function get_data_user($role_id,$id_jabatan,$email){

            if($role_id == 3 && !$id_jabatan==null){
                $query="SELECT * FROM user, role_user, jabatan_user WHERE
            user.role_id=role_user.role_id and user.id_jabatan=jabatan_user.id_jabatan and role_user.role_id=$role_id and jabatan_user.id_jabatan=$id_jabatan";
            return $this->db->query($query)->row_array();
            }else{
                $query="SELECT * FROM user, role_user WHERE
            `user`.`role_id`=`role_user`.`role_id`  and `role_user`.`role_id`='$role_id' and `user`.`email`='$email'";
            return $this->db->query($query)->row_array();
            }
            
            
        }
        
        // public function get_data(){
        //     return $this->db->get('user')->result_array();
        // }

        public function get_all_user(){
            $query="SELECT * FROM  role_user";
            return $this->db->query($query)->result_array();
        }

        public function get_user_BYID($id){
                return $this->db->get_where('role_user',['role_id'=>$id])->row_array();
        }

        public function get_all_user_not_admin(){
            $query="SELECT * FROM  role_user where role_id !=1";
            return $this->db->query($query)->result_array();
        }

        public function get_user_bytipe_roleID($id){
            if($id==1 || $id==2){
            return $this->db->get_where('user',['role_id'=>$id])->result_array();
            
            }else{
              $query="SELECT * FROM user, jabatan_user WHERE
               user.id_jabatan=jabatan_user.id_jabatan and user.role_id=$id";
              return $this->db->query($query)->result_array();
            }
        }

        public function get_admin(){
            return $this->db->get_where('user',['role_id'=>1])->result_array();
        }

        public function Add_Admin($data){
            $this->db->insert('user',$data);
            if($this->db->affected_rows()> 0){
                return true;
            }else{
                return false;
            }
        }

        public function del_Admin($id){
            $this->db->delete('user',['id'=>$id]);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function get_admin_BYID($data){
            return $this->db->get_where('user',$data)->row_array();
            
        }
        
        public function editAdmin($id,$data){
           $this->db->update('user',$data, ['id'=>$id]);
           if($this->db->affected_rows() > 0){
               return true;
           }else{
               return false;
           }
        }

        public function get_all_jabatan(){
            return $this->db->get('jabatan_user')->result_array();
        }

        public function Add_jabatan($data){
           $this->db->insert('jabatan_user',['jabatan'=>$data]);
           if($this->db->affected_rows() > 0){
               return true;
           }else{
               return false;
           }
        }

        public function delJabtan($id){
            $this->db->delete('jabatan_user',['id_jabatan'=>$id]);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getJabatanlike($data){
            $this->db->like('jabatan', $data);
           return $this->db->get_where('jabatan_user')->result_array();
          
        }

        public function change_isactive_User($data,$id){
            $this->db->update('user', $data, array('id' => $id));
          if($this->db->affected_rows() > 0){
              return true;
          }else{
              return false;
          }
        }

        public function get_userPEg_BYID($data){
            return $this->db->get_where('user',$data)->row();
            
        }

        public function Update_images($new_images,$id){ 
            $this->db->where('id', $id);
            $this->db->update('user', $new_images);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function edit_pegawaiBYid($data,$id,$role_id){
            $this->db->where('id', $id);
            $this->db->where('role_id', $role_id);
            $this->db->update('user', $data);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function cekPegJabatan($cekjbtn,$role_id){
            $this->db->where('id_jabatan', $cekjbtn);
            $this->db->where('role_id',$role_id);
            if($this->db->get('user')->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        


}

?>