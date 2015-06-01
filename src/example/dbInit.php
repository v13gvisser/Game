<?php
if(!defined('LOCAL')) define('LOCAL', false);
if (LOCAL) {
    $dbUser = 'root';
    $dbName = $dbUser . '_' . 'game'; //aparte databese
} else {
    $dbUser = 'v13gvisser_Game';
    $dbName = 'v13gvisser_Game';
}

$dbWachtwoord = '3tCHz7qP';
/*$dbPrefix = $dbUser . '_';
$dbName = $dbPrefix . 'Game';   // aparte database
$dbWachtwoord = '';*/