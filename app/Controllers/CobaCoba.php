<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;

class CobaCoba extends Controller
{
    public function index()
    {
        $order = [
            'transaction_details' => [
                'order_id' => 'Order-123',
                'gross_amount' => 80000
            ],
            'credit_card' => [
                'secure' => true
            ]
        ];
        $twe = '{
            "transaction_details": {
              "order_id": "123",
              "gross_amount": 80000
            }, 
            "credit_card": {
              "secure": true
            }
          }';
        echo $twe . "\n\n\n\n";
        echo json_encode($order);
    }
}
