<?php
/**
 * Created by PhpStorm.
 * User: DonS
 * Date: 1/18/2015
 * Time: 10:09 AM
 */

namespace SDPHP\TTTGame;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


class TicTacToe
{
    public $player = "X";            //whose turn is
    public $totalMoves = 0;        //how many moves have been made so far
    public $boardvert;        //the tic tac toe board


    /**
     * Purpose: run the game until it's tied or someone has won
     * Preconditions: all $_POST content
     * Postconditions: game is in play
     **/
    public function __construct()
    {
            $this->boardvert = [];                    //the tic tac toe board
            for ($i = 0; $i < 3; $i++) {              //Loop Vertical Line Array
                $boardhoriz = [];
                for ($l = 0; $l < 3; $l++) {          //Loop Horiz Line Array
//                    $boardhoriz[] = 0;              //this was an error, initializing all values to 0 as the the
                                                      //isOver() function thinks the game is over at the start!!
                    $boardhoriz[] = null;
                }
                $this->boardvert[] = $boardhoriz;
            }

//        $array = range(0, 2);
//        $this->boardvert = array_map(function($n, $array) {return range(0, 2);}, $array);

//        print_r($this->boardvert);exit();
}

//    function playGame($_POST)
    function playGame($request)
    {
//        if (!$this->isOver() && $_POST['move'])      //move is the form action=move and is always equal to "Take Turn"
//        $this->move($_POST);                         //Here the move function is being passed the $_Post array

        if (!$this->isOver() && $request->get('move'))  //checks to see if a move has been submitted, if so handle it.
            $this->move($request);

        print_r($this->boardvert);    //displays what is stored in the boardvert, of the session.

        //player pressed the button to start a new game
//        if ($_POST['newgame'])
//            $this->newGame();

        //display the game
        $this->displayGame();
    }

    /**
     * Purpose: display the game interface
     * Preconditions: none
     * Postconditions: start a game or keep playing the current game
     **/
    function DisplayGame()
    {
        //while the game isn't over
        if (!$this->isOver()) {
            echo "<div id=\"board\">";

            for ($x = 0; $x < 3; $x++) {
                for ($y = 0; $y < 3; $y++) {
                    echo "<div class=\"board_cell\">";
    //                    echo $boardvert[$x][$y];

                    //check to see if that position is already filled
    //                if ($this->$boardvert[$x][$y]) {
                    if ($this->boardvert[$x][$y]) {
    //                    echo "In displayboard, board position has been found";
    //                        echo "<img src=\"images/{$this->board[$x][$y]}.jpg\" alt=\"{$this->board[$x][$y]}\" title=\"{$this->board[$x][$y]}\" />";
                        echo "<img src=\"images/{$this->boardvert[$x][$y]}.jpg\" alt=\"{$this->boardvert[$x][$y]}\" title=\"{$this->boardvert[$x][$y]}\" />";
                    } else {
    //                        //let them choose to put an x or o there
                        echo "<select name=\"{$x}_{$y}\">
                                    <option value=\"\"></option>
                                    <option value=\"{$this->player}\">{$this->player}</option>
                                </select>";
                    }
                    echo "</div>";
                }
                echo "<div class=\"break\"></div>";
            }

            echo "
                    <p align=\"center\">
                        <input type=\"submit\" name=\"move\" value=\"Take Turn\" /><br/>
                        <b>It's player {$this->player}'s turn.</b></p>
                </div>";

         }
         else {

                //someone won the game or there was a tie
                if ($this->isOver() != "Tie")
                    echo $this->successMsg("Congratulations player " . $this->isOver() . ", you've won the game!");
                else if ($this->isOver() == "Tie")
                    echo $this->errorMsg("Whoops! Looks like you've had a tie game. Want to try again?");

                session_destroy();

                echo "<p align=\"center\"><input type=\"submit\" name=\"newgame\" value=\"New Game\" /></p>";
         }
    }


    /**
     * Purpose: trying to place an X or O on the board
     * Preconditions: the position they want to make their move
     * Postconditions: the game data is updated
     **/
//function move($_POST)
    function move($request)
    {
    if ($this->isOver())
        return;

        //remove duplicate entries on the board
    $_POST = array_unique($_POST);

//How to directly access the $_POST array of the $Request object??

        foreach ($_POST as $key => $value) {            //loop through the $_POST array, looking for the submitted value
                if ($value == $this->player) {          //checking to see if the value in that position is X or O
                    //update the board in that position with the player's X or O
                    $coords = explode("_", $key);
                    $this->boardvert[$coords[0]][$coords[1]] = $this->player;  //it is only here that the session
                                                                               //array is updated

                    //change the turn to the next player
                    if ($this->player == "X")
                        $this->player = "O";
                    else
                        $this->player = "X";

                    $this->totalMoves++;
                }

        }

    if ($this->isOver())
        return;
    }

    /**
     * Purpose: check for a winner
     * Preconditions: none
     * Postconditions: return the winner if found
     **/
    function isOver()
    {
        //top row
        if ($this->boardvert[0][0] && $this->boardvert[0][0] == $this->boardvert[0][1] && $this->boardvert[0][1] == $this->boardvert[0][2])
            return $this->boardvert[0][0];

        //middle row
        if ($this->boardvert[1][0] && $this->boardvert[1][0] == $this->boardvert[1][1] && $this->boardvert[1][1] == $this->boardvert[1][2])
            return $this->boardvert[1][0];

        //bottom row
        if ($this->boardvert[2][0] && $this->boardvert[2][0] == $this->boardvert[2][1] && $this->boardvert[2][1] == $this->boardvert[2][2])
            return $this->boardvert[2][0];

        //first column
        if ($this->boardvert[0][0] && $this->boardvert[0][0] == $this->boardvert[1][0] && $this->boardvert[1][0] == $this->boardvert[2][0])
            return $this->boardvert[0][0];

        //second column
        if ($this->boardvert[0][1] && $this->boardvert[0][1] == $this->boardvert[1][1] && $this->boardvert[1][1] == $this->boardvert[2][1])
            return $this->boardvert[0][1];

        //third column
        if ($this->boardvert[0][2] && $this->boardvert[0][2] == $this->boardvert[1][2] && $this->boardvert[1][2] == $this->boardvert[2][2])
            return $this->boardvert[0][2];

        //diagonal 1
        if ($this->boardvert[0][0] && $this->boardvert[0][0] == $this->boardvert[1][1] && $this->boardvert[1][1] == $this->boardvert[2][2])
            return $this->boardvert[0][0];

        //diagonal 2
        if ($this->boardvert[0][2] && $this->boardvert[0][2] == $this->boardvert[1][1] && $this->boardvert[1][1] == $this->boardvert[2][0])
            return $this->boardvert[0][2];

        if ($this->totalMoves >= 9)
            return "Tie";
    }

    /**
     * Purpose: return a formatted error message
     * Preconditions: the message to format
     * Postconditions: formatted message is returned
     **/
    function errorMsg($msg)
    {
        return "<div class=\"errorMsg\">$msg</div>";
    }

    /**
     * Purpose: return a formatted success message
     * Preconditions: the message to format
     * Postconditions: formatted message is returned
     **/
    function successMsg($msg)
    {
        return "<div class=\"successMsg\">$msg</div>";
    }

}
