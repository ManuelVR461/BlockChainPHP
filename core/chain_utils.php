<?php
include("vendor/autoload.php");

use Symfony\Component\Uid\Uuid;
use Elliptic\EC;

class ChainUtils{
    protected static $ec;

    public function __construct(){
        self::$ec = new EC('secp256k1');
    }

    static function genKeyPair($seed){
        // $secret = ChainUtils::hash($seed);
        // return self::$ec->keyFromPrivate($secret);
        return self::$ec->genKeyPair();
    }

    static function getPublicKey($pk){
        return $pk->getPublic(true, "hex");
    }

    static function verifySignature($publicKey, $signature, $datahash){
        $key = self::$ec->keyFromPublic($publicKey, 'hex');
        $verify = $key->verify($datahash, $signature->toDER('hex'));
        return $verify;
    }

    static function uuidv1(){
        return Uuid::v1();
    }

    static function hash($data){
        $datalen = count((array) $data);
        return hash('sha256', hash('sha256', "\x18BitGameLP coins for life games\n" . chr($datalen) . json_encode($data), true));
    }
    
    static function timesTamp(){
        return round(microtime(true) * 100);
    }

    public function __destruct(){

    }

}