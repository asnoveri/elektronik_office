<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class user_Mod extends CI_Model {

        public function get_data_user($role_id,$id){
            $query="SELECT * FROM user, `peguna`, role_user WHERE user.id=`peguna`.id AND `peguna`.role_id=role_user.role_id AND `peguna`.id=$id and `peguna`.role_id=$role_id";
                return $query = $this->db->query($query)->row_array();
            // if($role_id==1){
            //     $query="SELECT * FROM user, `admin`, role_user WHERE user.id=`admin`.id AND `admin`.role_id=role_user.role_id AND `admin`.id=$id";
            //     return $query = $this->db->query($query)->row_array();
            // }else if($role_id==2){
            //     $query="SELECT * FROM user, sekretaris, role_user WHERE user.id=sekretaris.id AND sekretaris.role_id=role_user.role_id AND sekretaris.id=$id";
            //     return $query = $this->db->query($query)->row_array();
            // }else if($role_id==4){
            //     $query="SELECT * FROM user, direktur, role_user WHERE user.id=direktur.id AND direktur.role_id=role_user.role_id AND direktur.id=$id";
            //     return $query = $this->db->query($query)->row_array();
            // }else if($role_id==3){
            //     $query="SELECT * FROM user, pegawai, role_user WHERE user.id=pegawai.id AND pegawai.role_id=role_user.role_id AND pegawai.id=$id";
            //     return $query = $this->db->query($query)->row_array();
            // }else if($role_id==5){
            //     $query="SELECT * FROM user, wadir, role_user WHERE user.id=wadir.id AND wadir.role_id=role_user.role_id AND wadir.id=$id";
            //     return $query = $this->db->query($query)->row_array();
            // }
            // else if($role_id==6){
            //     $query="SELECT * FROM user, adum, role_user WHERE user.id=adum.id AND adum.role_id=role_user.role_id AND adum.id=$id";
            //     return $query = $this->db->query($query)->row_array();
            // }
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


        public function get_all_jabatan($length="",$start="",$order="",$dir="",$search=""){
            if($search){
                $like= " AND role_name like '$search%'";
            }else{
                $like='';
            }
                    $query="SELECT  * FROM role_user
                    WHERE role_id BETWEEN 4 AND 6  $like  ORDER by role_name $dir  LIMIT $start,$length";
                    return  $this->db->query($query)->result();
    }

    public function get_all_jabatan_count(){
        $query="SELECT  * FROM role_user
        WHERE role_id BETWEEN 4 AND 6 ";
        return  $this->db->query($query)->result();
    }

        // public function get_all_op($length="",$start="",$order="",$dir="",$search="",$id){
        //     $this->db->order_by($order,$dir); 
        //     $this->db->like('fullname',$search);
        //     $this->db->or_like('email',$search);
        //     $this->db->limit($length,$start);
        //     $this->db->from('user');
        //     $this->db->join('sekretaris', 'sekretaris.id = user.id');
        //     return  $query = $this->db->get()->result();
        // }

        // public function get_all_sek_count(){
        //     return $this->db->count_all_results('sekretaris');
        // }
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

        public function get_wadir($id){
                    $this->db->where('id',$id);
                    $this->db->where('role_id',5);
                    $this->db->where('status',1);
            return $wadir=$this->db->get('peguna')->row();
        }

        public function get_direktur(){
                $this->db->where('role_id',4);
                $this->db->where('status',1);
            return $direktur=$this->db->get('peguna')->result();
        }

        public function get_adum(){
            $this->db->where('role_id',6);
            $this->db->where('status',1);
        return $direktur=$this->db->get('peguna')->result();
    }

        public function get_cek_jabatan_user($jabatan){
            $this->db->where('jabatan',$jabatan);
            $this->db->where('role_id',5);
            $this->db->where('status',1);
            return $this->db->get('peguna')->row();   
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

        public function get_allwadir_combobox($search=""){
            if($search){
                $this->db->like('unitkerja',$search);
                $this->db->where('parent_unit',14);
                return $this->db->get('unit_kerja')->result();
            }else{
                        $this->db->where('parent_unit',14);
                return $this->db->get('unit_kerja')->result();
            }
        }

        // public function get_OPByid($id){
        //     return $this->db->get_where('sekretaris',['id'=>$id])->row();
        // }

        public function get_allpenguna($length="",$start="",$dir="",$search="",$id){
        if($search){
            $like= " AND fullname like '$search%' AND  email like '$search%'";
        }else{
            $like='';
        }
                $query="SELECT user.id,fullname,user_name,email, peguna.id_penguna,jabatan, role_user.role_id  FROM user,peguna,role_user
                WHERE user.id=peguna.id AND peguna.role_id=role_user.role_id
                AND peguna.role_id=$id  AND status=1 $like  ORDER by fullname $dir  LIMIT $start,$length";
                return  $this->db->query($query)->result();
        }

        public function get_allpengunan_count($id){
            // return $this->db->count_all_results('admin');
            $query="SELECT user.id,fullname,user_name,email, peguna.id_penguna, role_user.role_id  FROM user,peguna,role_user
                WHERE user.id=peguna.id AND peguna.role_id=role_user.role_id
                AND peguna.role_id=$id AND status=1";
                return  $this->db->query($query)->result();
        }

        // public function get_direktur($length="",$start="",$order="",$dir="",$search=""){
        //     $this->db->order_by($order,$dir); 
        //     $this->db->like('fullname',$search);
        //     $this->db->or_like('email',$search);
        //     $this->db->limit($length,$start);
        //     $this->db->from('user');
        //     $this->db->join('direktur', 'direktur.id = user.id');
        //     return  $query = $this->db->get()->result();
        // }

        // public function get_all_direk_count(){
        //     return $this->db->count_all_results('direktur');
        // }

        
        // public function del_Direk($id_direktur){
        //     $this->db->delete('direktur',['id_direktur'=>$id_direktur]);
        //     if($this->db->affected_rows() > 0){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }

        // public function add_direktur($data){
        //     $this->db->insert('direktur',$data);
        //     if($this->db->affected_rows()> 0){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }

        public function ubahstatus($id_penguna,$data){
            $this->db->where('id_penguna', $id_penguna);
            $this->db->update('peguna', $data);
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
            if (!$this->db->simple_query("DELETE FROM `user` WHERE `user`.`id` = $id")){
                return $error = $this->db->error(); 
            }else{
                return false;
            }
        }

        public function del_User1($id){
            $this->db->delete('user',['id'=>$id]);
            if($this->db->affected_rows() > 0){
                return true;
            }
        }    


        // public function add_sekeretaris($data){
        //     $this->db->insert('sekretaris',$data);
        //     if($this->db->affected_rows()> 0){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }

        // public function del_Sekre($id_sekretaris){
        //     $this->db->delete('sekretaris',['id_sekretaris'=>$id_sekretaris]);
        //     if($this->db->affected_rows() > 0){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }
        
        public function get_penguna_BYID($id,$status='',$role_id){
                    $this->db->where('status',$status);
                    $this->db->where('role_id',$role_id);
                    $this->db->where('id',$id);
            return $this->db->get('peguna')->row();
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

        public function Add_Penguna($data){
            $this->db->insert('peguna',$data);
            if($this->db->affected_rows()> 0){
                return true;
            }else{
                return false;
            }
        }
}

?>