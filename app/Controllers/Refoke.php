<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Refoke extends ResourceController{

    public function Index(){
        $data = [
            'status' => 401,
            'message' => 'Anda tidak di ijinkan untuk mengakses ini'
        ];
        return $this->respond($data, 401);
        
    }
}