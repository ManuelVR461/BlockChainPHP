<?php
include_once("core/Config.php");
require_once('core/websockets.php');

class WsSocket extends WebSocketServer {
    protected $usu=array();
    
    public function __construct($server,$port){
        parent::__construct($server,$port);
    }
    
    protected function process ($user, $message) {
        foreach ($this->users as $currentUser) {
            if($currentUser !== $user){
                $this->send($currentUser,$message);
            }
        }
    }

    protected function connected ($user) {
        if(!empty($this->usu)){

            foreach ($this->usu as $key => $value) {
                $usu = $value;
            }
            //print_r($usu);
            if(!in_array("x", $usu) ){
                array_push($this->usu,array("user"=>"x","id" => $user->id));
            }
            if(!in_array("o", $usu) ){
                array_push($this->usu,array("user"=>"o","id" => $user->id));
            }
            $this->usu = array_merge($this->usu);
        }else{
            array_push($this->usu,array("user"=>"x","id"=>$user->id));
        }
        
        //print_r($this->usu);
        $join = array("users"=>$this->usu,"currentUser"=>$user->id);
        $this->send($user,json_encode($join));
    }
    
    protected function closed ($user) {
        echo 'Deconectado'.PHP_EOL;
        foreach ($this->usu as $key => $usu) {
            if($usu['id']==$user->id){
                unset($this->usu[$key]);
            }    
        }
    }
}


$newservice = new WsSocket(Config::P2P_SERVER,Config::P2P_PORT);

try {
    $newservice->run();
}
catch (Exception $e) {
    $newservice->stdout($e->getMessage());
}