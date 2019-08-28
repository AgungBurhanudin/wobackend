<?php

namespace Controllers;

use Libraries;
use Models;
use Resources;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
   $method = $_SERVER['REQUEST_METHOD'];
   if ($method == "OPTIONS") {
       die();
   }
   
class XREQUEST extends Resources\Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db = new Resources\Database;
        set_time_limit(150);
    }

    //proteksi ip
    public function act($folder_name, $file_name, $action_request, $interface)
    {
        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        $db            = new Models\Databases();
        $param         = file_get_contents('php://input');
        $jreq          = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $param),true);
        $userid          = $jreq['userid'];
        $username      = $jreq['username'];
        $token         = $jreq['token'];
        $tipebrowser   = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $jreq['appid'];
        $secClient     = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid         = $secClient;
        $time_sess     = '60';
        $ip            = getenv('REMOTE_ADDR');
        $ref           = date("ymdH") . $fungsi->randomNumber(8);
        $reply         = '';
        $wLog->writeLog($interface, $folder_name . '_' . $file_name, $param);

        //cek session
        $db->cekSession($userid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekuseridMember($userid);
        $nama_member       = $arr_member->user_real_name;
        $user_name       = $arr_member->user_user_name;
        include "$folder_name/$file_name.php";
        // $wLog->writeLog($interface, $folder_name . '_' . $file_name, $reply);
        echo $reply;

    }

}
