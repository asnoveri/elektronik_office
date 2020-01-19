<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class menu_Mod extends CI_Model {

    // public function menu($id){
       
    //     $querymnu="SELECT menu.menu,call_child,  user_acess_menu.id_menu
    //     FROM user_acess_menu
    //     INNER JOIN menu ON menu.id_menu=user_acess_menu.id_menu WHERE user_acess_menu.role_id='$id' and menu.is_active=1 order by menu.posisi ASC";

    //     return $menu=$this->db->query($querymnu)->result_array();
        
    // }

    // public function submenu($id){
    //         $qury="SELECT * FROM menu, sub_menu WHERE menu.id_menu=sub_menu.id_menu AND menu.id_menu=$id and sub_menu.is_active=1 order by sub_menu.posisi ASC";
    //         return $this->db->query($qury)->result_array();

            
    // }

    // public function sub_menu($id){
    //     $query="SELECT * FROM sub_menu WHERE id_menu=$id and sub_menu.is_active=1 ORDER by posisi ASC";
    //     return $this->db->query($query)->result_array();
    // }

   public function get_all_menu(){
        $this->db->order_by('posisi ASC');
        return $this->db->get('menu')->result_array();
    
   }     

   public function get_all_menu_is_active(){
    return $this->db->get_where('menu',['is_active'=> 1])->result_array();   
   }

   public function get_all_sub_menu(){
    $query="SELECT * FROM `sub_menu`,`menu` WHERE sub_menu.id_menu=menu.id_menu ORDER BY sub_menu.posisi_sub ASC ";

    return $this->db->query($query)->result_array();

}   

   public function cek_menu_is_active($id){
        return $this->db->get_where('menu',['id_menu'=>$id])->row_array();
     
    }

    public function cek_Sub_menu_is_active($id){
        return $this->db->get_where('sub_menu',['id_submenu'=>$id])->row_array();
     
    }

   public function edit_menu_is_active($id,$data){
        $this->db->update('menu', $data, array('id_menu' => $id));
        
    }

    public function edit_sub_menu_is_active($id,$data){
        $this->db->update('sub_menu', $data, array('id_submenu' => $id));
        
    }


   public function add_menu($data){
       $this->db->insert('menu',$data);

       if($this->db->affected_rows()>0){
           return ture;
       }else{
           return flase;
       }
       
   } 

   public function add_Submenu($data){
        $this->db->insert('sub_menu',$data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return flase;
        }
   }


   public function get_menuBYID($id){
        return $this->db->get_where('menu',['id_menu'=>$id])->row_array();
       
   }

   public function edit_menu($id,$data){
    $this->db->update('menu', $data, array('id_menu' => $id));

        if($this->db->affected_rows()> 0){
            return true;
        }else{
            return false;
        }
   }


   public function get_submenuBYID($id){
    return $this->db->get_where('sub_menu',['id_submenu'=>$id])->row_array();
   }

   public function edit_sub_menu($id,$data){

    $this->db->update('sub_menu', $data, array('id_submenu' => $id));

        if($this->db->affected_rows()> 0){
            return true;
        }else{
            return false;
        }
   }


   public function cek_menu_is_insert($data){
        $this->db->where($data);
        return $this->db->get('menu');
    }

   public function cek_submenu_is_insert($data){
    $this->db->where($data);
    return $this->db->get('sub_menu');
   } 

   public function cek_posisiSMN($data){
      $this->db->where($data);
      return $this->db->get('sub_menu')->row_array();
   }

   public function cek_posisiMN($data){
    
    return $this->db->get_where('menu',['posisi'=>$data,'is_active'=>1])->row_array();
   }

   public function user_akses($data){
    
       $cek=$this->db->get_where('user_acess_menu',$data);
      
       if($cek->num_rows() > 0){
           $this->db->delete('user_acess_menu',$data);
           if($this->db->affected_rows() > 0){
               return true;
           }else{
               return false;
           }   
    }else{
            $this->db->insert('user_acess_menu',$data);
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return false;
            }
        }
   }

}

?>