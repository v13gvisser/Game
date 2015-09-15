<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Server {
    private $turn;
    private $player;
    private $move;
    
    public function getMethod($g) {
        return $_GET[$g];
    }
 public function __construct() {
     $this->turn = "Blue";
     $this->move = "";
     $this->player = "";
 }
    
    
    
}