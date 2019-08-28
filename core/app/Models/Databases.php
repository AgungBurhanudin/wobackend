<?php

namespace Models;

use Resources,
    Libraries;

class Databases {

    public function __construct() {
        $this->db = new Resources\Database;
        $this->error = new Libraries\ResponseError;
    }

    public function singleRow($sql) {
        return $this->db->row($sql);
    }
    
    public function query($sql) {
        return $this->db->query($sql);
    }

    public function multipleRow($sql) {
        return $this->db->results($sql);
    }

    public function cekmutasi($id_mutasi) {
        $sql_cek = "select count(a.*) as a,count(b.*) as b from tbl_mutasi_anak a join tbl_mutasi_kenaikan_gaji b on a.id_mutasi = b.id_mutasi where a.id_mutasi='$id_mutasi' or b.id_mutasi='$id_mutasi'";
        return $this->db->row($sql_cek);
    }

    public function cekId($table, $nameRow, $id) {
        $sql_cek = "select * from $table where $nameRow = '$id'";
        return $this->db->row($sql_cek);
    }

    public function cekRowCount($table, $nameRow, $id) {
        $sql_cek = "select count($nameRow) as count from $table where $nameRow = '$id'";
        return $this->db->row($sql_cek);
    }

    public function deleteRow($table, $nameRow, $value) {
        $sql_cek = "delete from $table where $nameRow = '$value'";
        return $this->db->row($sql_cek);
    }

    public function cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip) {
        $ftime = $time_sess != 0 ? "and last_used > DATE_SUB(NOW(),INTERVAL 60 MINUTE)" : '';
        $qcek_login = "select * from app_user "
                . "where user_token = '$token' and status = 1 and appid = '$appid' "
                . "and user_id = '$noid' and UPPER(user_user_name) = '$username' "
                . "$ftime;";
        $arr = $this->db->row($qcek_login);
        if (!isset($arr->user_user_name)) {
            $this->error->invalidSession();
        } else {
            $this->db->query("update app_user set last_used = now() where user_id = $noid");
        }
    }

    public function cekuseridMember($noid) {
        $sql_cek = "select * from app_user where user_id = '$noid' and status = 1;";
        return $this->db->row($sql_cek);
    }


}
