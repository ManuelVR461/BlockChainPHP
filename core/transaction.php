<?php
class Transaction{
    public $id;
    public $input;
    public $outputs;

    public function __construct(){
        $this->id = (string) ChainUtils::uuidv1();
        $this->input = null;
        $this->outputs = array();
    }

    function signTransaction($transaction, $senderWallet){

        $outputs = $transaction->outputs;
        $outputsHash = ChainUtils::hash($outputs);
        $signature = $senderWallet->sign($outputsHash);
        $transaction->input = array(
            "timesTamp" => ChainUtils::timesTamp(),
            "amount" => $senderWallet->balance,
            "address" => $senderWallet->publicKey,
            "signature" => $signature
        );
    }

    static function transactionWithOutput($senderWallet, $outputs){
        $transaction = new Transaction;
        array_push($transaction->outputs, $outputs);
        Transaction::signTransaction($transaction, $senderWallet);
        return $transaction;
    }

    static function newTransaction($senderWallet, $recipient, $amount){
        try {
            if($amount > $senderWallet->balance){
                throw new Exception('Amount '.$amount.' Exceeds Your Balance', 6);
            }
            if(!$recipient || !$senderWallet->publicKey){
                throw new Exception('Transaccion no include direccion de reenvio o recepcion', 7);
            }

            $tx = Transaction::transactionWithOutput($senderWallet,array(
                array("amount"=>$senderWallet->balance - $amount, "address" => $senderWallet->publicKey),
                array("amount"=>$amount, "address" => $recipient)
            ));

            return $tx;

       } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function verifyTransaction($transaction){
        return ChainUtils::verifySignature(
                    $transaction->input['address'],
                    $transaction->input['signature'],
                    ChainUtils::hash($transaction->outputs)
                );
    }

    public function update($senderWallet, $recipient, $amount){
        try {
            $exist = false;
            foreach ($this->outputs as $ind => $output) {
                foreach ($output as $key => $out) {
                    if(in_array($senderWallet->publicKey,$out)){
                        $senderOutput = $output[$key];
                        if($amount > $senderOutput['amount']){
                            throw new Exception('Amount '.$amount.' Exceeds Your Balance', 8);
                        }
                        $this->outputs[$ind][$key]['amount'] -= $amount;
                        $exist = true;
                    }
                    
                }
                
            }
            if($exist){
                array_push($this->outputs[0],array("amount"=>$amount,"address"=>$recipient));
            }
            Transaction::signTransaction($this, $senderWallet);
            return $this;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function reward($minerWallet, $senderWallet){
        return Transaction::transactionWithOutput($senderWallet,array(
            array("amount" => Config::MINING_REWARD, "address" => $minerWallet->publicKey)
        ));
    }

}