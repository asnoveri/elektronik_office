<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_Mod extends CI_Model {
    
    
    public function upload_SRT_Msk($data){
     $this->db->insert('surat_masuk',$data);
     if($this->db->affected_rows()> 0){
         $this->db->select_max('id_surat_masuk');
         return $this->db->get('surat_masuk')->row();
     }else{
        return false;
        }
    }

    public function upload_SRT_keluar($data){
        $this->db->insert('surat_keluar',$data);
        if($this->db->affected_rows()> 0){
            $this->db->select_max('id_surat_keluar');
            return $this->db->get('surat_keluar')->row();
        }else{
           return false;
           }
       }

    public function add_srt_msuk_diter($data){
        $this->db->insert('surat_masuk_diter',$data);
        if($this->db->affected_rows()> 0){
            return true;
        }else{
           return false;
           }
       }

       public function add_srt_keluar_diter($data){
        $this->db->insert('surat_keluar_diter',$data);
        if($this->db->affected_rows()> 0){
            return true;
        }else{
           return false;
           }
       }

    public function get_all_srtMSk(){
         $this->db->order_by('tgl_surat_masuk','DESC');
        return $this->db->get('surat_masuk')->result();
    }

    public function get_srtMSkBYID($id){
        return $this->db->get_where('surat_masuk',['id_surat_masuk'=> $id])->row();
    }

    public function get_srtMSkBYID_ter($id){
        return $this->db->get_where('surat_masuk_diter',['id_surat_masuk'=> $id])->result();
    }
    public function get_srtMSkBYID_diterke($id){
        return $this->db->get_where('surat_masuk_diter',['di_teruskan_ke'=> $id])->result();
    }
    public function get_srtMSkBYID_terSingle($id,$idterus){
            $this->db->where('id_surat_masuk',$id);
            $this->db->where('id_terus',$idterus);
        return $this->db->get('surat_masuk_diter')->row(); 
    }

    public function get_srtMskditerByIdKirim($id_surat_masuk,$di_kirimkan_oleh){
        $this->db->where('id_surat_masuk',$id_surat_masuk);
        $this->db->where('di_kirimkan_oleh',$di_kirimkan_oleh);
    return $this->db->get('surat_masuk_diter')->result(); 
    }

    public function edit_feedback_srtMSK($data,$id){
        $this->db->update('surat_masuk_diter', $data, array('id_terus' => $id));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function edit_kondisiSrtMSK($idterus,$data){
        $this->db->update('surat_masuk_diter', $data,['id_terus'=>$idterus]);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_all_srtkeluarPeruser($id){
        $this->db->order_by('tgl_surat_keluar', 'DESC');
        return $this->db->get_where('surat_keluar',['asal_surat'=> $id])->result();
    }

    public function get_surat_keluarByid($id){
        return $this->db->get_where('surat_keluar',['id_surat_keluar'=> $id])->row();
    }

      public function get_surat_keluar_diterBYopadmn(){
        $this->db->order_by('id_surat_keluar', 'DESC');
        return $this->db->get_where('surat_keluar_diter',['di_teruskan_ke_srt_klr'=>0])->result();
    }

    public function get_surat_keluarByidMulti($id){
        $this->db->where('di_teruskan_ke_srt_klr !=', 0);
        $this->db->where('id_surat_keluar',$id);
        return $this->db->get('surat_keluar_diter')->result();
    }

    public function edit_feedback_srtkelter($data,$id){
        $this->db->update('surat_keluar_diter', $data, array('id_terus_srt_keluar' => $id));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function edit_feedback_srtkel($data,$id){
        $this->db->update('surat_keluar', $data, array('id_surat_keluar' => $id));
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_surat_keluarterBY($id){
       return $this->db->get_where('surat_keluar_diter',['di_teruskan_ke_srt_klr'=>$id])->result();  
    }

    
}

?>