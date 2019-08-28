<?php
if($action_request == "get"){
  $id = $_GET['id'];
  $expl = explode("_",$id);
//   print_r($expl);die();
  if($expl[0] == 'undangan'){

    $id_user = $expl[1];
    $sql = "SELECT * FROM undangan WHERE id = '$id_user'";
    
    $cek = $this->db->results($sql,'array');
    if (!empty($cek)){
        $update = "Update undangan set status = true where id = '$id_user'";
        $this->db->query($update);
    }

    $data = array(
        'response_code' => '0000',
        'response_message' => "Berhasil"
    );
  }else{
    $data['data'] = null;
  }

  $reply = json_encode($data);
}