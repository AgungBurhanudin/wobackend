<?php
if($action_request == "get"){
  $id_wedding = $_GET['id'];
  $sql = "SELECT * FROM undangan WHERE id_wedding = '$id_wedding'  ORDER BY nama";
  $data['data'] = $this->db->results($sql,'array');
  $reply = json_encode($data);
}