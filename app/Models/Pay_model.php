<?php
namespace App\Models;

use CodeIgniter\Model;
use Xendit\Xendit;
use CodeIgniter\I18n\Time;

class Pay_model extends Model{
    protected $table = "sax_payment_log";

    public function QRCode($email){
        Xendit::setApiKey('xnd_development_cw90SIwM6qlm8gfjcSj0PNlOg26Le9MKK6YysGr01cQNfjlzxveyBBQDPGY7I');
        $query = $this->table($this->table)->where('email', $email)->get();
        $data = $query->getRow();
        $qr_code = \Xendit\QRCode::get($data->order_id);
        $qr = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=";
        $output = [
          "images_QR" =>  $qr . $qr_code['qr_string'],
          "data_qr" => $qr_code
        ];

        return $output;
    }

    public function payment($params){
        Xendit::setApiKey('xnd_development_cw90SIwM6qlm8gfjcSj0PNlOg26Le9MKK6YysGr01cQNfjlzxveyBBQDPGY7I');
        $query = $this->table($this->table)->where('order_id', $params['external_id'])->countAll();
        $today = new Time('now');
        $date = $today->toDateTimeString();
        if($query>0){
            $kueri =$this->table($this->table)->where('order_id', $params['external_id'])->get();
            $data = $kueri->getRow();
            $createInvoice = \Xendit\Invoice::retrieve($data->invoice_id);
        }
        else{
            $createInvoice = \Xendit\Invoice::create($params);
            $data =[
                    'order_id' => $createInvoice['external_id'],
                    'invoice_id' => $createInvoice['id'],
                    'email' => $createInvoice['payer_email'],
                    'status' => $createInvoice['status'],
                    'date_exp' => $createInvoice['expiry_date'],
                    'date' => $date
            ];
            $this->db->table($this->table)->insert($data);
        }
        return $createInvoice;
    }
}
