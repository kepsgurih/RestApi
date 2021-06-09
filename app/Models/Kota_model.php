<?php
namespace App\Models;

use CodeIgniter\Model;

class Kota_model extends Model{
    protected $table = "sax_lokasi_kota";

    public function location($provinsi){
        return $this->where('provinsi',$provinsi)->findAll();
    }
}