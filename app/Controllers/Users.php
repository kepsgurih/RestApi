<?php 
namespace App\Controllers;

use App\Models\PrivateKeyModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use Firebase\JWT\JWT;
use CodeIgniter\I18n\Time;


header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class Users extends ResourceController{

    public function __construct()
    {
        $this->key = new PrivateKeyModel();
    }
    public function index()
    {
        $secret_key = $this->key->key();
        
        $token = null;

        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        $myTime = new Time('now');

        if($token){
            try{
                $decoded = JWT::decode($token, $secret_key, array('HS256'));
                if($decoded){
                    $output = [
                        'date' => $myTime->toLocalizedString('Y-MM-d HH:m:s'),
                        'data' => $decoded
                    ];
                    return $this->respond($output, 200);
                }
            }
            catch(\Exception $e){
                $output = [
                    'message' => 'Access Ditolak',
                    "error" => $e->getMessage()
                ];
         
                return $this->respond($output, 401);

            }
        }
    }
}