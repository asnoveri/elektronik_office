<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user_Mod extends CI_Model
{

    public function get_data_user($role_id, $id)
    {
        $query = "SELECT * FROM user, `peguna`, role_user WHERE user.id=`peguna`.id AND `peguna`.role_id=role_user.role_id AND `peguna`.id=$id and `peguna`.role_id=$role_id";
        return $query = $this->db->query($query)->row_array();
    }

    public function get_all_user($length = "", $start = "", $order = "", $dir = "", $search = "")
    {
        $this->db->order_by($order, $dir);
        $this->db->order_by('fullname', 'asc');
        $this->db->like('fullname', $search);
        $this->db->or_like('email', $search);
        $this->db->limit($length, $start);
        return $this->db->get('user')->result();
    }

    public function get_all_user_count()
    {
        return $this->db->count_all_results('user');
    }


    public function get_all_jabatan($length = "", $start = "", $order = "", $dir = "", $search = "")
    {
        if ($search) {
            $like = " AND role_name like '$search%'";
        } else {
            $like = '';
        }
        $query = "SELECT  * FROM role_user
                    WHERE role_id BETWEEN 4 AND 6  $like  ORDER by role_name $dir  LIMIT $start,$length";
        return  $this->db->query($query)->result();
    }

    public function get_all_jabatan_count()
    {
        $query = "SELECT  * FROM role_user
            WHERE role_id BETWEEN 4 AND 6 ";
        return  $this->db->query($query)->result();
    }

    public function cek_username($data)
    {
        $this->db->where('user_name', $data);
        if ($this->db->get('user')->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_user($id)
    {
        if ($user = $this->db->get_where('user', ['id' => $id])->row()) {
            return $user->fullname;
        } else {
            return false;
        }
    }

    public function get_userbyID($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row();
    }

    public function get_wadir($id)
    {
        $this->db->where('id_unitkerja', $id);
        $this->db->where('parent_unit', 14);
        return $wadir = $this->db->get('unit_kerja')->row();
    }

    public function get_direktur()
    {
        $this->db->where('role_id', 4);
        $this->db->where('status', 1);
        return $direktur = $this->db->get('peguna')->result();
    }

    public function get_direktur_one()
    {
        $this->db->where('role_id', 4);
        $this->db->where('status', 1);
        return $direktur = $this->db->get('peguna')->row();
    }

    public function get_adum()
    {
        $this->db->where('role_id', 6);
        $this->db->where('status', 1);
        return $direktur = $this->db->get('peguna')->result();
    }

    public function get_cek_jabatan_user($jabatan)
    {
        $query = "SELECT * FROM `jabatan`,`unit_kerja` WHERE `jabatan`.`nama_jabatan`=`unit_kerja`.`id_unitkerja` and `jabatan`.`nama_jabatan`=$jabatan and `jabatan`.`status`=1";
        return $this->db->query($query)->row();
    }

    public function get_userpswd($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row();
    }

    public function get_user_BYID($id)
    {
        return $this->db->get_where('role_user', ['role_id' => $id])->row_array();
    }

    public function get_all_role()
    {
        return $this->db->get('role_user')->result_array();
    }


    public function get_alluser_combobox($search = "")
    {
        if ($search) {
            $this->db->like('fullname', $search);
            $this->db->where('is_active', 1);
            return $this->db->get('user')->result();
        } else {
            $this->db->where('is_active', 1);
            return $this->db->get('user')->result();
        }
    }

    public function get_allwadir_combobox($search = "")
    {
        if ($search) {
            $this->db->like('unitkerja', $search);
            $this->db->where('parent_unit', 14);
            return $this->db->get('unit_kerja')->result();
        } else {
            $this->db->where('parent_unit', 14);
            return $this->db->get('unit_kerja')->result();
        }
    }

    public function get_allpenguna($length = "", $start = "", $dir = "", $search = "", $id)
    {
        if ($search) {
            // $like= " AND fullname like '$search%' AND  email like '$search%'";
            $like = " AND fullname like '$search%'";
        } else {
            $like = '';
        }
        $query = "SELECT user.id,fullname,user_name,email, peguna.id_penguna, role_user.role_id  FROM user,peguna,role_user
                WHERE user.id=peguna.id AND peguna.role_id=role_user.role_id
                AND peguna.role_id=$id  AND status=1 $like  ORDER by fullname $dir  LIMIT $start,$length";
        return $this->db->query($query)->result();
    }

    public function get_allpengunan_count($id, $search)
    {
        if ($search) {
            $like = " AND fullname like '$search%'";
        } else {
            $like = '';
        }
        $query = "SELECT user.id,fullname,user_name,email, peguna.id_penguna, role_user.role_id  FROM user,peguna,role_user
                WHERE user.id=peguna.id AND peguna.role_id=role_user.role_id
                AND peguna.role_id=$id AND status=1 $like";
        return  $this->db->query($query)->result();
    }



    public function ubahstatus($id_penguna, $data)
    {
        $this->db->where('id_penguna', $id_penguna);
        $this->db->update('peguna', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function Add_user($data)
    {
        $this->db->insert('user', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function del_User($id)
    {
        if (!$this->db->simple_query("DELETE FROM `user` WHERE `user`.`id` = $id")) {
            return $error = $this->db->error();
        } else {
            return false;
        }
    }

    public function del_User1($id)
    {
        $this->db->delete('user', ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    public function get_penguna_BYID($id, $status = '', $role_id)
    {
        $this->db->where('status', $status);
        $this->db->where('role_id', $role_id);
        $this->db->where('id', $id);
        return $this->db->get('peguna')->row();
    }

    public function change_isactive_User($data, $id)
    {
        $this->db->update('user', $data, array('id' => $id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_userEdit($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row();
    }

    public function Update_images($new_images, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $new_images);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_userBYid($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Add_Penguna($data)
    {
        $this->db->insert('peguna', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Add_Pengunafor_jabatan($data, $role_id)
    {
        $this->db->insert('peguna', $data);
        if ($this->db->affected_rows() > 0) {
            $this->db->select_max('id_penguna');
            $this->db->where('role_id', $role_id);
            $query = $this->db->get('peguna')->row();
            return $query->id_penguna;
        } else {
            return false;
        }
    }

    public function get_unitkerjabyID($id)
    {
        $unit_kerja = $this->db->get_where('unit_kerja', ['id_unitkerja' => $id])->row();
        return $unit_kerja->unitkerja;
    }

    public function get_unitkerjaPegawaiBYukp($id_unitkerja, $status = '', $jabatan)
    {
        return $this->db->get_where('jabatan', ['id_unitkerja' => $id_unitkerja, 'status' => $status, 'nama_jabatan' => $jabatan])->row();
    }

    public function get_unitkerjaPegawai($id_peguna, $id_unitkerja, $status = '', $jabatan)
    {
        return $this->db->get_where('jabatan', [
            'id_peguna' => $id_peguna,
            'id_unitkerja' => $id_unitkerja, 'status' => $status, 'nama_jabatan' => $jabatan
        ])->row();
    }

    public function get_unitkerjaPegawainonAktiv($id_peguna, $id_unitkerja, $status = '', $jabatan)
    {
        return $this->db->get_where('jabatan', [
            'id_peguna' => $id_peguna,
            'id_unitkerja' => $id_unitkerja, 'status' => $status, 'nama_jabatan' => $jabatan
        ])->row();
    }

    public function get_jabatanWadir($id)
    {
        $query = "SELECT `jabatan`.`id_jabatan`,`nama_jabatan`, `unit_kerja`.`unitkerja` FROM `jabatan`,`unit_kerja` WHERE `jabatan`.`nama_jabatan`=`unit_kerja`.`id_unitkerja` AND `jabatan`.`id_peguna`=$id AND jabatan.`status`=1";
        return $data = $this->db->query($query)->row();
    }


    public function get_jabatanWadrinonaktiv($id)
    {
        $query = "SELECT `jabatan`.`id_jabatan`,`nama_jabatan`, `unit_kerja`.`unitkerja` FROM `jabatan`,`unit_kerja` WHERE `jabatan`.`nama_jabatan`=`unit_kerja`.`id_unitkerja` AND `jabatan`.`id_peguna`=$id AND jabatan.`status`=0";
        return $data = $this->db->query($query)->row();
    }

    public function get_jabatanOP($id)
    {
        $query = "SELECT * FROM jabatan WHERE id_peguna=$id";
        $data = $this->db->query($query)->row();
        return $data->id_jabatan;
    }

    public function get_jabatanOPNonAktiv($id)
    {
        $query = "SELECT * FROM jabatan WHERE id_peguna=$id and status=0";
        $data = $this->db->query($query)->row();
        return $data->id_jabatan;
    }

    public function ubahstatusJabatan($id, $data)
    {
        $this->db->where('id_jabatan', $id);
        $this->db->update('jabatan', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function ubahstatusJabatanByidpenguna($id, $data)
    {
        $this->db->where('id_peguna', $id);
        $this->db->update('jabatan', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ubahstatuJBtnByidpengdanIdjabatan($id, $unit_kerja, $jabatan, $data)
    {
        $this->db->where('id_peguna', $id);
        $this->db->where('id_unitkerja', $unit_kerja);
        $this->db->where('nama_jabatan', $jabatan);
        $this->db->update('jabatan', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add_jabatan($data)
    {
        $this->db->insert('jabatan', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_allUnit_kerja($search)
    {
        if ($search) {
            $this->db->like('unitkerja', $search);
            $this->db->where('parent_unit', 0);
            $this->db->where('id_unitkerja !=', 1);
            $this->db->where('id_unitkerja !=', 14);
            $this->db->where('id_unitkerja !=', 50);
            return $this->db->get('unit_kerja')->result();
        } else {
            $this->db->where('parent_unit', 0);
            $this->db->where('id_unitkerja !=', 1);
            $this->db->where('id_unitkerja !=', 14);
            $this->db->where('id_unitkerja !=', 50);
            return $this->db->get('unit_kerja')->result();
        }
    }

    public function get_alljabatan($search, $unitker)
    {
        if ($search) {
            $this->db->like('unitkerja', $search);
            $this->db->where('parent_unit', $unitker);
            $this->db->where('id_unitkerja !=', 46);
            return $this->db->get('unit_kerja')->result();
        } else {
            $this->db->where('parent_unit', $unitker);
            $this->db->where('id_unitkerja !=', 46);
            return $this->db->get('unit_kerja')->result();
        }
    }

    public function get_jml_peg()
    {
        $this->db->where('is_active', 1);
        return $this->db->get('user')->result();
    }

    public function get_semua_user()
    {
        $this->db->where('is_active', 1);
        return $this->db->get('user')->result();
    }

    public function get_penguna_user($id)
    {
        return $this->db->get_where('peguna', ['id' => $id, 'status' => 1])->result();
    }

    public function get_jabatan_user($id_penguna)
    {
        $query = $this->db->get_where('jabatan', ['id_peguna' => $id_penguna, 'status' => 1])->result();
        return $query;
    }

    public function get_unitkerja_user($id_unitkerja)
    {
        $query = $this->db->get_where('unit_kerja', ['id_unitkerja' => $id_unitkerja])->result();
        return $query;
    }
}
