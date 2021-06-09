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
// use CodeIgniter\I18n\Time;

class Payment extends ResourceController
{
  public function __construct()
  {
    $this->payer = new Pay_model();
    $this->key = new PrivateKeyModel();
  }
  public function index()
  {
    $secret_key = $this->key->key();
    $token = null;
    $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
    $arr = explode(" ", $authHeader);
    $token = $arr[1];

    // Statement Pertama
    if ($token) {
      $decoded = JWT::decode($token, $secret_key, array('HS256'));
      try {
        $email = $decoded->data->email;
        $order_id = 'order-' . $email;
        $params = [
          'external_id' => $order_id,
          'payer_email' => $email,
          'description' => 'Pembelian Akun Berbayar',
          'amount' => 32000
        ];
        return $this->respond($this->payer->payment($params));
      } catch (\Exception $e) {
        $errorLog = [
          'message' => $e
        ];
        $this->respond($errorLog, 401);
      }
    }
  }
}
