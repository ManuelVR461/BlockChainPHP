<?php
require_once("config.php");
require_once("chain_utils.php");
require_once("transaction.php");
require_once("blockchain.php");

class Wallet{
    public $balance;
    public $keyPair;
    public $publicKey;
    protected static $seed = "palabra secreta";
    //public $blockchain;

    public function __construct($bc=null){
        $k = new ChainUtils;
        $this->balance = Config::INITIAL_BALANCE;
        $this->keyPair = ChainUtils::genKeyPair(self::$seed);
        $this->publicKey = ChainUtils::getPublicKey($this->keyPair);
        //$this->blockchain = $bc;
    }

    public function toString(){
        return "WALLET -\n
                publicKey: --: {$this->publicKey}\n
                Balance: ----: {$this->balance}";
    }

    public function sign($datahash){
        return $this->keyPair->sign($datahash);
    }

    public function createTransaction($recipient, $amount, $blockchain){
        try {
            if($amount > $this->balance){
                throw new Exception('Amount '.$amount.' Exceeds Your Balance', 9);
            }

            $transaction = $blockchain->memoryPool->existingTransaction($this->publicKey);

            if($transaction){
                $transaction->update($this, $recipient, $amount);
            } else {
                $transaction = Transaction::newTransaction($this, $recipient, $amount);
                $blockchain->memoryPool->updateOrAddTransaction($transaction);
            }

            return $transaction;

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}