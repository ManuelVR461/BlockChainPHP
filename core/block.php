<?php
require_once("config.php");
require_once("chain_utils.php");

class Block {
    public $timesTamp;
    public $previusHash;
    public $hash;
    public $data;
    public $nonce;
    public $difficulty;
    public $processTime;

    public function __construct($timesTamp, $previusHash, $hash, $data, $nonce, $difficulty, $processTime){
        $this->timesTamp = $timesTamp;
        $this->previusHash = $previusHash;
        $this->hash = $hash;
        $this->data = $data;
        $this->nonce = $nonce;
        $this->difficulty = $difficulty;
        $this->processTime = $processTime;
    }

    public function toString(){
        return "Block -
                timesTamp -----: {$this->timesTamp}
                previusHash ---: {$this->previusHash}
                hash ----------: {$this->hash}
                data ----------: {$this->data}
                Nonce: --------: {$this->nonce}
                Difficulty: ---: {$this->difficulty}
                ProcessTime: --: {$this->processTime}
        ";
    }

    static function genesis(){
        $genesis = "En fecha de 27JUN2020 Inicia la plataforma BitGame Lottery and Parley";
        return new Block(strtotime("12 July 2020"), str_repeat("0", 64), str_repeat("0", 64), $genesis, 0, Config::DIFFICULTY, 0);
    }

    static function hash($timesTamp, $previusHash, $data, $nonce, $difficulty){
        return ChainUtils::hash(array($timesTamp, $previusHash, $data, $nonce, $difficulty));
    }

    static function adjustDifficulty($previusBlock, $currentTime){
        $difficulty = $previusBlock->difficulty;
        $difficulty = ((int) $previusBlock->timesTamp + (int) Config::MINE_RATE > $currentTime) ? $difficulty + 1 : $difficulty - 1;
        return $difficulty;
    }

    static function blockHash($block){
        return self::hash($block->timesTamp, $block->previusHash, $block->data, $block->nonce, $block->difficulty);
    }

    static function mine($previusBlock,$data){
        $previusHash = $previusBlock->hash;
        $nonce = 0;
        $t1 = ChainUtils::timesTamp();

        do{
            $timesTamp = ChainUtils::timesTamp();
            $nonce++;
            $difficulty = Block::adjustDifficulty($previusBlock, $timesTamp);
            $hash = Block::hash($timesTamp, $previusHash, $data, $nonce, $difficulty);
        }while(substr($hash, 0, $difficulty) !== str_repeat("0", $difficulty));
        $t2 =  ChainUtils::timesTamp();
        $processTime = $t2 - $t1;

        return new Block($timesTamp, $previusHash, $hash, $data, $nonce, $difficulty, $processTime);
        
    }

    

    public function __destruct(){

    }

}