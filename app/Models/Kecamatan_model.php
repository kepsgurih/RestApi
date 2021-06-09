<?php
namespace App\Models;

use CodeIgniter\Model;

class Kecamatan_model extends Model{
    protected $table = "sax_lokasi_kecamatan";

    public function location($kota){
        return $this->where('kota',$kota)->findAll();
    }
}