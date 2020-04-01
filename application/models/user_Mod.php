<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class user_Mod extends CI_Model {

        public function get_data_user($role_id,$id){
            if($role_id==1){
                $query="SELECT * FROM user, `admin`, role_user WHERE user.id=`admin`.id AND `admin`.role_id=role_user.role_id AND `admin`.id=$id";
                return $query = $this->db->query($query)->row_array();
            }else if($role_id==2){
                $query="SELECT * FROM user, sekretaris, role_user WHERE user.id=sekretaris.id AND sekretaris.role_id=role_user.role_id AND sekretaris.id=$id";
                return $query = $this->db->query($query)->row_array();
            }else if($role_id==4){
                $query="SELECT * FROM user, direktur, role_user WHERE user.id=direktur.id AND direktur.role_id=role_user.role_id AND direktur.id=$id";
                return $query = $this->db->query($query)->row_array();
            }else if($role_id==3){
                $query="SELECT * FROM user, pegawai, role_user WHERE user.id=pegawai.id AND pegawai.role_id=role_user.role_id AND pegawai.id=$id";
                return $query = $this->db->query($query)->row_array();
            }else if($role_id==5){
                $query="SELECT * FROM user, wadir, role_user WHERE user.id=wadir.id AND wadir.role_id=role_user.role_id AND wadir.id=$id";
                return $query = $this->db->query($query)->row_array();
            }
            else if($role_id==6){
                $query="SELECT * FROM user, adum, role_user WHERE user.id=adum.id AND adum.role_id=role_user.role_id AND adum.id=$id";
                return $query = $this->db->query($query)->row_array();
            }
        }

        
        public function get_all_user($length="",$start="",$order="",$dir="",$search=""){
            if($order){
                $this->db->order_by($order,$dir); 
                $this->db->limit($length,$start);  
                return $this->db->get('user')->result();
            }
            if($search){
                $this->db->like('fullname',$search);
                $this->db->or_like('email',$search);
                $this->db->limit($length,$start);  
                return $this->db->get('user')->result();
            }
                $this->db->order_by('fullname','asc');
                $this->db->limit($length,$start);  
                return $this->db->get('user')->result();
        }

        public function get_all_user_count(){
            return $this->db->count_all_results('user');
        }
        
        
        public function get_user_BYID($id){
                return $this->db->get_where('role_user',['role_id'=>$id])->row_array();
        }

        public function get_user_BYIDjabtan($id){
            $this->db->where('id_jabatan !=', 0);
            $this->db->where('id_jabatan',$id);
            return $this->db->get('user')->row();
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

        public function Add_user($data){
            $this->db->insert('user',$data);
            if($this->db->affected_rows()> 0){
                return true;
            }else{
                return false;
            }
        }

        public function del_User($id){
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

        public function cekPegJabatan($cekjbtn){
            $this->db->where('id_jabatan', $cekjbtn);
            if($this->db->get('user')->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function get_jbtnBYid($id){
          return  $this->db->get_where('jabatan_user',['id_jabatan'=> $id])->row();

        }

        public function change_Jabatan_User($data,$id){
            $this->db->update('user', $data, array('id' => $id));
          if($this->db->affected_rows() > 0){
              return true;
          }else{
              return false;
          }
        }
        


}

?>