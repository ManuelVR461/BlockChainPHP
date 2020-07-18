<?php
require_once("wallet.php");

class Miner{
    public $blockchain;
    public $p2pServices;
    public $minerWallet;
    public $blockchainWallet;
    
    public function __construct($blockchain,$p2p,$minerWallet)
    {
        $this->blockchain = $blockchain;
        $this->p2pServices = $p2p;
        $this->minerWallet = $minerWallet;
        $this->blockchainWallet = new Wallet;
    }

    public function miner(){
        try {
            if(count($this->blockchain->memoryPool->transactions) === 0){
                throw new Exception('There are not unconfirmed transaction', 11);
            }
            array_push($this->blockchain->memoryPool->transactions,Transaction::reward($this->minerWallet,$blockchainWallet));
            $block = $this->blockchain->addBlock($this->blockchain->memoryPool->transactions);
            //sincronizar p2p;
            // $p2pServices->sync();
            $this->blockchain->memoryPool->clear();


        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        
    }
    
    public function __destruct()
    {

    }

}