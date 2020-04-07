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
                $this->db->order_by($order,$dir);
                $this->db->order_by('fullname','asc'); 
                $this->db->like('fullname',$search);
                $this->db->or_like('email',$search);
                $this->db->limit($length,$start);  
                return $this->db->get('user')->result();
        }

        public function get_all_user_count(){
            return $this->db->count_all_results('user');
        }

        public function get_all_op($length="",$start="",$order="",$dir="",$search=""){
            $this->db->order_by($order,$dir); 
            $this->db->like('fullname',$search);
            $this->db->or_like('email',$search);
            $this->db->limit($length,$start);
            $this->db->from('user');
            $this->db->join('sekretaris', 'sekretaris.id = user.id');
            return  $query = $this->db->get()->result();
        }

        public function get_all_sek_count(){
            return $this->db->count_all_results('sekretaris');
        }
        public function cek_username($data){
            $this->db->where('user_name', $data);
            if($this->db->get('user')->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }
        
        public function get_user($id){
            if($user=$this->db->get_where('user',['id'=>$id])->row()){
                return $user->fullname;
            }else{
                return false;
            }   
        }

        public function get_userpswd($id){
            return $this->db->get_where('user',['id'=>$id])->row();
        }

        public function get_user_BYID($id){
                return $this->db->get_where('role_user',['role_id'=>$id])->row_array();
        }

        public function get_all_role(){
                return $this->db->get('role_user')->result_array();
        }

        public function get_alluser_combobox($search=""){
            if($search){
                $this->db->like('fullname',$search);
                return $this->db->get('user')->result();
            }else{
                return $this->db->get('user')->result();
            }
        }

        public function get_OPByid($id){
            return $this->db->get_where('sekretaris',['id'=>$id])->row();
        }

        public function get_admin($length="",$start="",$order="",$dir="",$search=""){
            $this->db->order_by($order,$dir); 
            $this->db->like('fullname',$search);
            $this->db->or_like('email',$search);
            $this->db->limit($length,$start);
            $this->db->from('user');
            $this->db->join('admin', 'admin.id = user.id');
            return  $query = $this->db->get()->result();
        }

        public function get_all_admin_count(){
            return $this->db->count_all_results('admin');
        }

        public function del_Admin($id_admin){
            $this->db->delete('admin',['id_admin'=>$id_admin]);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
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
                // return false;
                return $this->db->error();
            }
        }

        public function add_sekeretaris($data){
            $this->db->insert('sekretaris',$data);
            if($this->db->affected_rows()> 0){
                return true;
            }else{
                return false;
            }
        }

        public function del_Sekre($id_sekretaris){
            $this->db->delete('sekretaris',['id_sekretaris'=>$id_sekretaris]);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }
        
        public function get_admin_BYID($id){
            return $this->db->get_where('admin',['id'=>$id])->row();
        }
        
        public function change_isactive_User($data,$id){
            $this->db->update('user', $data, array('id' => $id));
          if($this->db->affected_rows() > 0){
              return true;
          }else{
              return false;
          }
        }

        public function get_userEdit($id){
            return $this->db->get_where('user',['id'=>$id])->row();
            
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

        public function edit_userBYid($data,$id){
            $this->db->where('id', $id);
            $this->db->update('user', $data);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function Add_admin($data){
            $this->db->insert('admin',$data);
            if($this->db->affected_rows()> 0){
                return true;
            }else{
                return false;
            }
        }
}

?>