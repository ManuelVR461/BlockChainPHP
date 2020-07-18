<?php
require_once("core/blockchain.php");
require_once("core/Wallet.php");
require_once("core/memorypool.php");
require_once("core/miner.php");

$btn = isset($_REQUEST['btn'])?$_REQUEST['btn']:null;
$data = isset($_REQUEST['data'])?$_REQUEST['data']:null;
$data_tx = (array)json_decode($data);


function casttoclass($class, $object){
  return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
}

if(!isset($_SESSION['datalogin']['w'])){
    $w = new Wallet;
}else{
    $w = casttoclass('Wallet',$_SESSION['datalogin']['w']);
}

if(!isset($_SESSION['datalogin']['bc'])){
    $bc = new BlockChain;
}else{
    $bc = casttoclass('BlockChain',$_SESSION['datalogin']['bc']);
}


switch ($btn) {
    case 'Limpiar':
        // session_destroy();
        // echo "Numeros de Bloques: ".count($bc->chain)." \n\n";
        // print_r($bc->chain);
        break;
    case 'listablocks':
        // echo "\n\n";
        // echo "Numeros de Bloques: ".count($bc->chain)." \n\n";
        // print_r($bc->chain);
        break;
    case 'listablocksminar':
        // echo "\n\n";
        // print_r($bc->memoryPool->transactions);
        break;
    case 'SenderWallet':
        // $d = json_encode($data,true);
        // $bc->addBlock($d);
        // $_SESSION['datalogin']['bc'] = $bc;
        // echo "Numeros de Bloques: ".count($bc->chain)." \n\n";
        // print_r($bc->chain);
        break;
    case 'MinerBlock':
        $tx = $w->createTransaction($data_tx['recipient'], $data_tx['amount'], $bc);
        print_r($tx);
        break;
    default:
        # code...
        break;
}
