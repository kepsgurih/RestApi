<?php
namespace App\Models;
use CodeIgniter\Model;

class Machen_model extends Model{
    protected $tableUpload = "sax_uploads";

    protected $tableProperties = "sax_properties";

    public function insert_by_user($data)
    {
        $query = $this->db->table($this->tableProperties)->insert($data);
        return $query ? true : false;
    }
    public function insert_images($data){
        $query = $this->db->table($this->tableUpload)->insert($data);
        return $query ? true : false;
    }
    public function getAllProperties(){
        $builder = $this->db->table($this->tableProperties);
        $builder->select('sax_properties.id, user_id, judul, slug, tipe, luas_tanah, luas_bangunan, sertifikat, deskripsi, harga, jumlah_lantai, jumlah_km, jumlah_kt, provinsi, kota, kecamatan, kelurahan,sax_uploads.gambar');
        $builder->join($this->tableUpload, 'sax_uploads.upload_id = sax_properties.id');
        $builder->groupBy('sax_properties.id');
        $builder->orderBy('sax_properties.date','DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    public function images($id){
        $builder = $this->db->table($this->tableUpload);
        $builder->select('*');
        $query = $builder->where('upload_id',$id)->get();

        return $query->getResult();
    }
    public function getUser($id){
        $builder = $this->db->table($this->tableProperties);
        $builder->select('sax_properties.id, user_id, judul, slug, tipe, luas_tanah, luas_bangunan, sertifikat, deskripsi, harga, jumlah_lantai, jumlah_km, jumlah_kt, provinsi, kota, kecamatan, kelurahan,sax_uploads.gambar');
        $builder->join($this->tableUpload, 'sax_uploads.upload_id = sax_properties.id');
        $builder->groupBy('sax_properties.id');
        $builder->orderBy('sax_properties.date','DESC');
        $query = $builder->where('sax_properties.user_id',$id)->get();
        return $query->getResult();
    }
}
?>