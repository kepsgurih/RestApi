<?php namespace App\Controllers;
 
use Firebase\JWT\JWT;
use App\Models\Auth_model;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Exception;
 
class Auth extends ResourceController
{
    public function __construct()
    {
        $this->auth = new Auth_model();
    }
 
    public function privateKey()
    {
        $privateKey = <<<EOD
            -----BEGIN RSA PRIVATE KEY-----
            AAAAB3NzaC1yc2EAAAADAQABAAABgQC
            /JswlE7UOWUNdwy5+pyYCQ5rbjSRDmp
            KTMdnvT9/26dcHWr08Q3c6AF9ODU7e/
            7YVaL4UeFDgFGi3TQTvF8LdhIHpEa4L
            nUYNLa3M8Fq6HBsv/xul/ZqE2/YDR8I
            10EPnSrWkiB7riYpnZmktOuShy5II7g
            aBRvXPpaDcEvfRpYSz0SK6SOcCfuxxz
            t4IN2JMToG5c/+e6BNmidNJTSUGFK1I
            5MLG27kEm44AiDs4h+pYhfi+6pm8fe1
            nJt5jYtmhYFBP5lbzYN096mUn/6+8e0
            xz1bJmOZNynDlSPUPUaxbFg+ivSGGTO
            Uo++3zCYYPyUSSxizVuXnxShkRe4N2F
            heKGBu50KL1gRK3d8a/eU38TG5ss49l
            dwcs7qcu9SzvWPrkkJaN6I/1mfiklRa
            QGzpLTs/YjEy0yTjn/lmbsPbYAP9ooS
            UCdfZzcdBuDX+T1kMDURy0uBwUe9lYz
            v/s4Fljdctrt4zOX3trHPUKy0BGiyCQ
            chS7f7DuHHMotHpk=
            -----END RSA PRIVATE KEY-----
            EOD;
        return $privateKey;
    }
 
    public function register()
    {

        // GET API FROM DATA
        $fullname   = $this->request->getVar('fullname');
        $phone      = $this->request->getVar('phone');
        $email      = $this->request->getVar('email');
        $password   = $this->request->getVar('password');


        $avatar = "https://ui-avatars.com/api/?size=128&background=random&name=";
 
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        date_default_timezone_set("Asia/Bangkok");
        $data = json_decode(file_get_contents("php://input"));
        $dataId = date_create();
        $dataRegister = [
            'id' => date_timestamp_get($dataId),
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'password' => $password_hash,
            'avatar'    => str_replace(" ","+",$avatar . $fullname),
            'created' =>date("Y-m-d H:i:s"),
            'updated' =>date("Y-m-d H:i:s")
        ];
 
        $register = $this->auth->register($dataRegister);
 
        if($register == true){
            $output = [
                'status' => 200,
                'message' => 'Berhasil register'
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 400,
                'message' => 'Gagal register'
            ];
            return $this->respond($output, 400);
        }
    }
 
    public function login()
    {
        $email      = $this->request->getVar('email');
        $password   = $this->request->getVar('password');
 
        $cek_login = $this->auth->cek_login($email);
 
        // var_dump($cek_login['password']);
 
        if(password_verify($password, $cek_login['password']))
        {
            $secret_key = $this->privateKey();
            $issuer_claim = "https://rumahdia.id"; // this can be the servername. Example: https://domain.com
            $audience_claim = "https://rumahdia.id/";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 3600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim.$cek_login['id'],
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $cek_login['id'],
                    "fullname" => $cek_login['fullname'],
                    "avatar" => $cek_login['avatar'],
                    "phone" => '62' . $cek_login['phone'],
                    "email" => $cek_login['email'],
                    "buck"  => $cek_login['buck']
                )
            );
 
            $token = JWT::encode($token, $secret_key);
 
            $output = [
                'status' => 200,
                'message' => 'Berhasil login',
                "token" => $token,
                "email" => $email,
                "expireAt" => $expire_claim
            ];
            return $this->respond($output, 200);
        } else {
            $output = [
                'status' => 401,
                'message' => 'Gagal Login',
                "password" => $password
            ];
            return $this->respond($output, 401);
        }
    }
 
}