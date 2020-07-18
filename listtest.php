<?php
require_once("core/blockchain.php");
require_once("core/Wallet.php");
require_once("core/memorypool.php");
require_once("core/miner.php");

$btn = isset($_REQUEST['btn'])?$_REQUEST['btn']:null;
$data = isset($_REQUEST['data'])?$_REQUEST['data']:null;

function casttoclass($class, $object){
  return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
}

if(!isset($_SESSION['datalogin']['bc'])){
    $bc = new BlockChain;
}else{
    $bc = casttoclass('BlockChain',$_SESSION['datalogin']['bc']);
}
switch ($btn) {
    case 'Limpiar':
        session_destroy();
        echo "Numeros de Bloques: ".count($bc->chain)." \n\n";
        print_r($bc->chain);
        break;
    case 'test1':
        
        $block0 = Block::genesis();
        echo $block0->toString();
        echo "\n";
        echo "\n";

        $block1 = Block::mine($block0,"Hola mundo");
        echo $block1->toString();
        echo "\n";
        echo "\n";

        $block2 = Block::mine($block1,"Otro Datos");
        echo $block2->toString();
        echo "\n";
        echo "\n";
        break;
    
    case 'test2':
        $bc = new BlockChain;
        $bc->addBlock("Nueva Data");
        $bc->addBlock("Otra informacion");
        print_r($bc);
        break;

    case 'test3':
        $bc = new BlockChain;
        $bc->addBlock("Nueva Data");
        print_r($bc);
        echo "\n\n";
        $bc->chain[1]->data = "otra data";
        print_r($bc);
        echo "\n\n";
        $valid = $bc->isValidChain($bc);
        echo " \n\n";
        echo ($valid==true) ? "Block Valid!":"Block Invalid!";
        break;
    case 'test4':
        $bc = new BlockChain;
        $bc2 = new BlockChain;
        $bc2->addBlock("Nueva Data de un nuevo chain");
        //$bc2->chain[1]->data = "otra data";
        $bc->replaceChain($bc2);
        print_r($bc);
        break;
    case 'test5':
        $w1 = new Wallet;
        $amount = 3000;
        $recipient = "otra direcion 1";
        $tx = Transaction::newTransaction($w1,$recipient,$amount);
        //$tx->outputs[0][1]['amount'] = 5000;
        print_r($tx);
        $verify = Transaction::verifyTransaction($tx);
        echo "Verified: " . (($verify == TRUE) ? "true" : "false") . "\n";
        echo "\n\n";
        $tx->update($w1,'otra direcion 2',50000);
        $tx->update($w1,'otra direcion 3',40000);
        echo "\n\n";
        echo "Con nueva transaccion";
        echo "\n\n";
        print_r($tx);
        echo "\n\n";
        $verify = Transaction::verifyTransaction($tx);
        echo "Verified: " . (($verify == TRUE) ? "true" : "false") . "\n";
        break;
    case 'test6':
        $w1 = new Wallet;
        $amount = 3000;
        $recipient = "otra direcion 1";
        $tx = Transaction::newTransaction($w1,$recipient,$amount);
        $mp = new MemoryPool;
        $mp->updateOrAddTransaction($tx);
        print_r($mp);
        break;
    case 'test7':
        $bc = new BlockChain;
        $w1 = new Wallet;
        $amount = 3000;
        $recipient = "otra direcion 1";
        $tx = $w1->createTransaction($recipient,$amount,$bc);
        $tx = $w1->createTransaction($recipient,$amount,$bc);
        print_r($tx);

        break;
    case 'listablocks':
        echo "\n\n";
        print_r($bc->chain);
        break;
    case 'MinarBlock':
        $d = json_encode($data,true);
        $bc->addBlock($d);
        $_SESSION['datalogin']['bc'] = $bc;
        echo "Numeros de Bloques: ".count($bc->chain)." \n\n";
        print_r($bc->chain);
        break;
    case 'Minar':
        $minerwallet = new Wallet;
        $minar = new Miner($bc,null,$minerwallet);
        $minar->miner();
        echo "\n\n";
        print_r($bc->chain);
        break;
    default:
        # code...
        break;
}
