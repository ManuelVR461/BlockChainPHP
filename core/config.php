<?php

class Config{
    public function __construct(){
        date_default_timezone_set('America/Santiago');

    }

    const DIFFICULTY = 3;
    const MINE_RATE = 2 * 60 * 1000; //wait time in milliseconds
    const INITIAL_BALANCE = 100000;
    const MINING_REWARD = 50;
    const BLUE = "\033[0;34m";
    const RED = "\033[0;31m";
    const YELLOW = "\033[1;33m";
    const NC = "\033[0m";
    const P2P_SERVER = "localhost";
    const P2P_PORT = 3000;

}