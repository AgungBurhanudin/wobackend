<?php
if($action_request == "get"){
  $sql = "SELECT a.*,
    b.nama_panggilan AS nama_pria, 
    c.nama_panggilan AS nama_wanita,
    e.user_real_name,
    d.datetime,
    d.deskripsi
    FROM wedding a   
  LEFT JOIN 
    (SELECT id_wedding,nama_lengkap, nama_panggilan, alamat_nikah 
    FROM pengantin 
    WHERE gender = 'L' ) b 
  ON b.id_wedding = a.id 
  LEFT JOIN 
    (SELECT id_wedding,nama_lengkap, nama_panggilan, alamat_nikah 
    FROM pengantin 
    WHERE gender = 'P' ) c 
  ON c.id_wedding = a.id 
  LEFT JOIN 
  (SELECT * FROM log_aktivitas GROUP BY id_wedding ORDER BY datetime DESC LIMIT 1) d  
  ON d.id_wedding = a.id 
  LEFT JOIN app_user e 
  ON d.id_user = e.user_id 
  WHERE a.status = 1
  ORDER BY a.tanggal DESC";
  $result = $this->db->results($sql,'array');
  if(empty($result)){
    $data['data'] = null;
  }else{
    $data['data'] = $result;
  }
  
  $reply = json_encode($data);
}