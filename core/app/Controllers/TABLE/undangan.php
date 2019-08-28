<?php
if($action_request == "get"){
  $id_wedding = $_GET['id'];
  $sql = "SELECT * FROM undangan WHERE id_wedding = '$id_wedding'  ORDER BY nama";
  $data['data'] = $this->db->results($sql,'array');
 
  if (!empty($data['data'])){

    $reply = json_encode($data);
    
  }
  else{
    $data['data'] =null ;
    $reply = json_encode($data);
  }
}