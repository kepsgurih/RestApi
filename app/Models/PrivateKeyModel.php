<?php 
namespace App\Models;

use CodeIgniter\Model;

class PrivateKeyModel extends Model{
    public function key(){
        $privateKey = <<<EOD
            -----BEGIN RSA PRIVATE KEY-----
            AAAAB3NzaC1yc2EAAAADAQABAAABgQC
            /JswlE7UOWUNdwy5+pyYCQ5rbjSRDmp
            KTMdnvT9/26dcHWr08Q3c6AF9ODU7e/
            7YVaL4UeFDgFGi3TQTvF8LdhIHpEa4L
            nUYNLa3M8Fq6HBsv/xul/ZqE2/YDR8I
            10EPnSrWkiB7riYpnZmktOuShy5II7g
            aBRvXPpaDcEvfRpYSz0SK6SOcCfuxxz
            t4IN2JMToG5c/+e6BNmidNJTSUGFK1I
            5MLG27kEm44AiDs4h+pYhfi+6pm8fe1
            nJt5jYtmhYFBP5lbzYN096mUn/6+8e0
            xz1bJmOZNynDlSPUPUaxbFg+ivSGGTO
            Uo++3zCYYPyUSSxizVuXnxShkRe4N2F
            heKGBu50KL1gRK3d8a/eU38TG5ss49l
            dwcs7qcu9SzvWPrkkJaN6I/1mfiklRa
            QGzpLTs/YjEy0yTjn/lmbsPbYAP9ooS
            UCdfZzcdBuDX+T1kMDURy0uBwUe9lYz
            v/s4Fljdctrt4zOX3trHPUKy0BGiyCQ
            chS7f7DuHHMotHpk=
            -----END RSA PRIVATE KEY-----
            EOD;
        return $privateKey;
    }
}