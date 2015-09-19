<?php

class Server {

    private $turn;
    private $move;
    private $player;
    private $player1;
    private $player2;
    private $array = array();
    private $info;
    private $status;
    private $case;

    public function getMethod($g) {
        return $_GET[$g];
    }

    private function parseCase() {
        $this->case = $this->getMethod('action');
    }

    public function __construct() {
        $this->turn = "Blue";
        $this->move = "";
        $this->player = "";
    }

    public function setInfo($info) {
        $this->array['info'] = $info;
    }

    public function setStatus($status) {
        $this->array['status'] = $status;
    }

    public function getTurn() {
        $sql = 'select turn from game where player = :player';
        pdo()->prepare($sql);
        pdo()->bindParam(':player', $this->player);
        $this->turn = pdo()->execute();
    }

    private function getMove() {
        $this->move = $this->getMethod('move');
    }

    private function getPlayer() {
        $this->player = $this->getMethod('player');
    }

    public function playersFromDb() {
        for ($id = 1; $id < 3; $id++) {
            $sql = 'select player from game where id = :id';
            pdo()->prepare($sql);
            pdo()->bindParam(':id', $id);
            if ($id == 1) {
                $this->player1 = pdo()->execute();
            } elseif ($id == 2) {
                $this->player2 = pdo()->execute();
            }
        }
    }

    public function whoseTurn() {
        if ($this->player == $this->turn) {
            return 'yes';
        } else {
            return 'no';
        }
    }

    public function saveMove() {
        $sql = "update bord set taken = 'yes',player = :player, where id = :move ";
        pdo()->prepare($sql);
        pdo()->bindParam(':player', $this->player);
        pdo()->bindParam(':move', $this->move);
        pdo()->execute();
    }

    public function switchPlayer() {
        if ($this->player == 'Blue') {
            $player1 = 'Red';
            $player2 = 'Blue';
        } elseif ($this->player == 'Red') {
            $player1 = 'Blue';
            $player2 = 'Red';
        }

        $sql1 = "update game set turn = 1 where player = :player";
        pdo()->prepare($sql1);
        pdo()->bindParam(':player', $player1);
        pdo()->execute();

        $sql2 = "update game set turn = 0 where player = :player";
        pdo()->prepare($sql2);
        pdo()->bindParam(':player', $player2);
        pdo()->execute();
    }

    public function run() {
        $this->parseCase();
        switch ($this->case) {
            case 'initialize':
                $this->playersFromDb();
                $bord = 0;

                $this->setInfo(array('players' => array($this->player1, $this->player2), 'bord' => $bord, 'turn' => $this->turn));
                $this->setStatus('Initialized');
                break;

            case 'move':
                $this->getMove();
                $this->getPlayer();

                $this->saveMove();
                $this->changePlayer();

                $this->setStatus('move saved');
                break;

            case 'update':
                $this->getPlayer();
                $this->getTurn();
                $whoseMove = whoseMove();

                $this->setInfo(array('turn' => $whoseMove));
                $this->setStatus('turn checked');
                break;

            default:
                $this->setInfo("Command invalid");
                $this->setStatus('serverError');
                break;
        }
        $this->respond();
    }

    private function respond() {
        $data = json_encode($this->data);
        die($data); // echo and quit
    }

}
