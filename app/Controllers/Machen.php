<?php

namespace App\Controllers;

use App\Models\Machen_model;
use App\Models\PrivateKeyModel;
use App\Models\Properties_model;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Exception;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class Machen extends ResourceController
{

    public function __construct()
    {
        $this->Machen = new Machen_model();
        $this->key = new PrivateKeyModel();
    }

    public function index()
    {
        $secret_key = $this->key->key();
        $token = null;
        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        if ($token) {
            $decoded = JWT::decode($token, $secret_key, array('HS256'));
            try {
                if ($decoded) {
                    $id     = $decoded->data->id;
                    return $this->respond($this->Machen->getUser($id), 201);
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access Ditolak',
                    "error" => $e->getMessage()
                ];

                return $this->respond($output, 401);
            }
        }
    }
    public function properties()
    {
        return $this->respond($this->Machen->getAllProperties(), 201);
    }
    public function images($id = null)
    {
        $id = $this->request->getVar('id');
        return $this->respond($this->Machen->images($id), 201);
    }

    public function create()
    {


        $data = json_decode(file_get_contents("php://input"));
        $dataId = date_create();

        $secret_key = $this->key->key();

        $token = null;

        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');

        $arr = explode(" ", $authHeader);

        $token = $arr[1];

        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));
                if ($decoded) {
                    helper(['form', 'url']);
                    date_default_timezone_set("Asia/Bangkok");
                    $proid           = date_timestamp_get($dataId);
                    $files           = $this->request->getFileMultiple("gambar");
                    $judul           = $this->request->getPost("judul");
                    $user_id         = $this->request->getPost("user_id");
                    $slug            = $judul . '-' . $user_id;
                    $tipe            = $this->request->getPost("tipe");;
                    $luas_tanah      = $this->request->getPost("luas_tanah");
                    $luas_bangunan   = $this->request->getPost("luas_bangunan");
                    $sertifikat      = $this->request->getPost("sertifikat");
                    $deskripsi       = nl2br($this->request->getPost("deskripsi"));
                    $harga           = $this->request->getPost("harga");
                    $jumlah_lantai   = $this->request->getPost("jumlah_lantai");
                    $jumlah_km       = $this->request->getPost("jumlah_km");
                    $jumlah_kt       = $this->request->getPost("jumlah_kt");
                    $provinsi        = $this->request->getPost("provinsi");
                    $kota            = $this->request->getPost("kota");
                    $kecamatan       = $this->request->getPost("kecamatan");
                    $kelurahan       = $this->request->getPost("kelurahan");
                    // Data Store API
                    $buatData = [
                        'id'            => $proid,
                        'user_id'       => $decoded->data->id,
                        'judul'         => $judul,
                        'slug'          => url_title($slug, '-', TRUE),
                        'tipe'          => $tipe,
                        'luas_tanah'    => $luas_tanah,
                        'luas_bangunan' => $luas_bangunan,
                        'sertifikat'    => $sertifikat,
                        'deskripsi'     => $deskripsi,
                        'harga'         => $harga,
                        'jumlah_lantai' => $jumlah_lantai,
                        'jumlah_km'     => $jumlah_km,
                        'jumlah_kt'     => $jumlah_kt,
                        'provinsi'      => $provinsi,
                        'kota'          => $kota,
                        'kecamatan'     => $kecamatan,
                        'kelurahan'     => $kelurahan,
                        'created'       => date("Y-m-d H:i:s"),
                        'updated'       => date("Y-m-d H:i:s"),
                        'date'          => date("Y-m-d H:i:s")
                    ];
                    $insert = $this->Machen->insert_by_user($buatData);
                    if ($insert == TRUE) {
                        foreach ($files as $file) {
                            $newName = $file->getRandomName();
                            $file->move(WRITEPATH . 'uploads/user-properties', $newName);
                            $dataGambar = [
                                'upload_id' => $proid,
                                'gambar' => $newName
                            ];
                            $this->Machen->insert_images($dataGambar);
                        }
                        $output = [
                            'status' => 200,
                            'message' => 'Data Berhasil di unggah'
                        ];
                        return $this->respond($output, 200);
                    } else {
                        $output = [
                            'status' => 401,
                            'message' => 'Data gagal di unggah'
                        ];
                        return $this->respond($output, 401);
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'Access Ditolak',
                    "error" => $e->getMessage()
                ];

                return $this->respond($output, 401);
            }
        }
    }
}
