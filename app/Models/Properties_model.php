<?php
namespace App\Models;

use CodeIgniter\Model;

class Properties_model extends Model{
    protected $table = "sax_properties";
    public function getUser($id){
        $builder = $this->db->table('sax_properties');
        $query   = $builder->get(); 
        return $query->getResult();
    }
}
?>