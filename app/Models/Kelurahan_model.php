<?php
namespace App\Models;

use CodeIgniter\Model;

class Kelurahan_model extends Model{
    protected $table = "sax_lokasi_kelurahan";

    public function location($kecamatan){
        return $this->where('kecamatan',$kecamatan)->findAll();
    }
}