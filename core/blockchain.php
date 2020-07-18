<?php
require_once("block.php");
require_once("memorypool.php");

class BlockChain{
    public $chain;
    public $memoryPool;
    
    public function __construct(){
        $this->chain = array(Block::genesis());
        $this->memoryPool = new MemoryPool;
    }

    public function getLastBlock() {
        return $this->chain[count($this->chain)-1];
    }

    public function addBlock($data){
        $block = Block::mine($this->getLastBlock(),$data);
        array_push($this->chain,$block);
        return $block;
    }

    public function isValidChain($blockChain){
        try {
            if(json_encode($blockChain->chain[0]) !== json_encode(Block::genesis())){
                throw new Exception("Invalid Block Genesis", 1);
            }
            
            for ($i = 1; $i < count($blockChain->chain); $i++) {
                $block = $blockChain->chain[$i];
                $previusBlock = $blockChain->chain[$i-1];
                if($block->previusHash !== $previusBlock->hash){
                    throw new Exception("Invalid PreviusHash Block", 2);
                }
                if($block->hash !== Block::blockHash($block)){
                    throw new Exception("Invalid Hash Block", 3);
                }
            }
            return true;   
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function replaceChain($newBlockChain = []){
        try {
            if(count($newBlockChain->chain) <= count($this->chain)){
                throw new Exception("Received chain is not longer than current chain", 4);
            } else if(!$this->isValidChain($newBlockChain)) {
                throw new Exception("the received chain is not valid", 5);
            }

            $this->chain = $newBlockChain;
            return $this->chain;

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function __destruct(){

    }

}