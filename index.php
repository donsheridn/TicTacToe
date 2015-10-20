<?php
/**
 * Created by PhpStorm.
 * User: DonS
 * Date: 1/17/2015
 * Time: 4:41 PM
 */

include_once 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use SDPHP\TTTGame\TicTacToe;

$session = new Session();        //this will store the game information between page refreshes
$session->start();               //start the session, although a session will actually start on demand, that is,
                                 //if any session request is made to read/write session data.

$request = Request::createFromGlobals();     //Request is represented by some global variables
                                             //($_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, ...)

//if they haven't started a game yet let's load one
if (!$session->has('game')) {
    $tictactoe = new TicTacToe();            //this creates a TicTacToe object who's constructor draws the board
    $session->set('game', $tictactoe);       //this sets a session for the game and stores the tictactoe object.
}

include_once('src/view/TTTView.php');        //display the webpage for the game, and the current state of the game.
                                             //It calls the playGame() function which controls what is happening.



