<?php

namespace App\Controllers;

use App\Models\Kecamatan_model;
use App\Models\Kelurahan_model;
use App\Models\Provinsi_model;
use App\Models\Kota_model;
use CodeIgniter\RESTful\ResourceController;

class Location extends ResourceController{

    public function __construct()
    {
        $this->Prov = new Provinsi_model();
        $this->Kot = new Kota_model();
        $this->Kec = new Kecamatan_model();
        $this->Kel = new Kelurahan_model();
    }
    // All Provinsi
    public function index(){
        echo 'error';
    }
    public function provinsi($id=null){
        $id = $this->request->getPost('id');
        return $this->respond($this->Prov->location($id), 201);
    }
    public function kota($provinsi=null){
        $provinsi = $this->request->getPost('provinsi');
        return $this->respond($this->Kot->location($provinsi),201);
    }
    public function kecamatan($kota=null){
        $kota = $this->request->getPost('kota');
        return $this->respond($this->Kec->location($kota),201);
    }
    public function kelurahan($kecamatan=null){
        $kecamatan = $this->request->getPost('kecamatan');
        return $this->respond($this->Kel->location($kecamatan),201);
    }

}