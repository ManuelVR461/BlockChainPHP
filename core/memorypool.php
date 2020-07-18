<?php
require_once("transaction.php");

class MemoryPool{
    public $transactions;

    public function __construct(){
        $this->transactions = [];
    }

    public function updateOrAddTransaction($transaction){
        try {
            
            $outputTotal = array_reduce($transaction->outputs[0],function($total,$output){
                $total += $output['amount'];
                return $total;
            });
        
            if($transaction->input['amount'] !== $outputTotal){
                throw new Exception("Invalid Transaction from $transaction->input['address']", 10);
            }

            if(!Transaction::verifyTransaction($transaction)){
                throw new Exception("Invalid Signature from $transaction->input['address']", 11);
            }
    
            $exist=false;
            if(count($this->transactions) > 0){
                foreach ($this->transactions as $key => $trs) {
                    if($trs->id === $transaction->id){
                        $this->transactions[$key] = $transaction;
                        $exist=true;
                    }
                }
            }
            if(!$exist){
                array_push($this->transactions, $transaction);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        
    }

    public function existingTransaction($address){
        $exist = false;
        $tx = null;
        if(count($this->transactions) > 0){
            foreach ($this->transactions as $key => $txs) {
                if($txs->input['address'] === $address){
                    $exist = true;
                    $tx = $txs;
                }
            }
        }
        return ($exist==true) ? $tx : $exist;
    }

    public function clear(){
        $this->transactions = array();
    }

}