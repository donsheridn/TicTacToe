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

print_r($_POST);            //The $_POST array holds an array with the current move
//print_r($_SERVER);
//print_r($_SESSION);       //The session holds an array with the state of the board
//print_r($request);

//if ($session->has('game')) {
//    print_r($session->get('game'));    //No point in rpinting the $session array here as it hasn't been updated yet!
//}

//if they haven't started a game yet let's load one
if (!$session->has('game')) {
    $tictactoe = new TicTacToe();
    $session->set('game', $tictactoe);
}

//if they haven't started a game yet let's load one
//if (!$_SESSION['game']['tictactoe'])
//    $_SESSION['game']['tictactoe'] = new TicTacToe();

?>

<html>
<head>
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" type="text/css" href="inc/style.css" />
</head>
<body>
<div id="content">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h2>Let's Play Tic Tac Toe!</h2>
        <?php
//        $_SESSION['game']['tictactoe']->playGame($_POST);
        $session->get('game')->playGame($request);
        ?>
    </form>
</div>
</body>
</html>