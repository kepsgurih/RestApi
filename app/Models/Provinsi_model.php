<?php
namespace App\Models;

use CodeIgniter\Model;

class Provinsi_model extends Model{
    protected $table = "sax_lokasi_provinsi";
    protected $primaryKey = 'id';

    public function location($id = false){
        if($id === false){
            return $this->findAll();
        }
        else{
            return $this->find($id);
        }
    }
}