<?php

namespace App\Controllers;

use App\Models\Pay_model;
use App\Models\PrivateKeyModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
use Exception;
class Payment_Methods extends ResourceController
{
    public function __construct()
    {
        $this->Pay = new Pay_model();
        $this->key = new PrivateKeyModel();
    }
    public function qr()
    {
        $secret_key = $this->key->key();
        $token = null;
        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        if ($token) {
            $decoded = JWT::decode($token, $secret_key, array('HS256'));
            try{
                $email = $decoded->data->email;
                $resource = $this->Pay->QRCode($email);
                return $this->respond($resource);
            }
            catch(\Exception $e){
                $errorLog = [
                    'message' => "Error"
                  ];
                  $this->respond($errorLog, 401);
            }

        }
    }
}
