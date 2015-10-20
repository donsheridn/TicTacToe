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
    public $player = "X";            //whose turn it is
    public $totalMoves = 0;          //how many moves have been made so far
    public $boardvert;               //the tic tac toe board


    //Draw out the board
    public function __construct()
    {
        $this->boardvert = [];                    //the tic tac toe board
        for ($i = 0; $i < 3; $i++) {              //Loop Vertical Line Array
            $boardhoriz = [];
            for ($l = 0; $l < 3; $l++) {          //Loop Horiz Line Array
                $boardhoriz[] = null;
            }
            $this->boardvert[] = $boardhoriz;
        }

        // print_r($this->boardvert);exit();
    }


    //Controls what is happening in the game
    function playGame($request)
    {
        if (!$this->isOver() && $request->get('move'))  //checks if the game is over yet, checks to see if a move has been submitted.
            $this->move($request);                      //if so handle it. Call the move() function which inputs the move

        //print_r($this->boardvert);    //displays what is stored in the boardvert, of the session.

        $this->displayGame();           //display the game.
    }


    //Display the game.
    function DisplayGame()
    {
        if (!$this->isOver()) {         //call the isOver() function to see if any game ending conditions have been met.
            echo "<div id=\"board\">";

            for ($x = 0; $x < 3; $x++) {
                for ($y = 0; $y < 3; $y++) {
                    echo "<div class=\"board_cell\">";

                    if ($this->boardvert[$x][$y]) {         //check to see if that position already has an image

                        echo "<img src=\"images/{$this->boardvert[$x][$y]}.jpg\" alt=\"{$this->boardvert[$x][$y]}\" title=\"{$this->boardvert[$x][$y]}\" />";

                    }
                    else {                       //if this position has no image, let them choose to put an x or o there

                        echo "<select name=\"{$x}_{$y}\">
                                    <option value=\"\"></option>
                                    <option value=\"{$this->player}\">{$this->player}</option>
                              </select>";

                    }
                    echo "</div>";
                }
                echo "<div class=\"break\"></div>";
            }
            echo "<p align=\"center\">
                        <input type=\"submit\" name=\"move\" value=\"Take Turn\" /><br/>
                        <b>It's player {$this->player}'s turn.</b></p>
                </div>";

        }
        else {                                  //the game is over someone has won the game or there was a tie.

            if ($this->isOver() != "Tie"){   //the game is over and someone has won the game

                echo $this->successMsg("Congratulations dude " . $this->isOver() . ", you've won the game!");

            }

            else if ($this->isOver() == "Tie"){   //the game is over and is a tie.

                echo $this->errorMsg("Draw match play again, or solve it with a Roshambo!");

            }

            session_destroy();

            echo "<p align=\"center\"><input type=\"submit\" name=\"newgame\" value=\"New Game\" /></p>";
        }

    }


    //
    function move($request)
    {
        if ($this->isOver())
            return;

        $_POST = array_unique($_POST);      //remove duplicate entries on the board

        foreach ($_POST as $key => $value) {            //loop through the $_POST array, looking for the submitted value.

            if ($value == $this->player) {          //checking to see if the value in that position is X or O.

                $coords = explode("_", $key);       //update the board in that position with the player's X or O.

                $this->boardvert[$coords[0]][$coords[1]] = $this->player;  //it is only here that the session
                //array is updated

                //change the turn to the next player
                if ($this->player == "X"){

                    $this->player = "O";

                }
                else{

                    $this->player = "X";

                }
                $this->totalMoves++;
            }
        }

        if ($this->isOver()){
            return;
        }

    }

    //Checks for ways to win the game.
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

    //Return a formatted error message
    function errorMsg($msg)
    {
        return "<div class=\"errorMsg\">$msg</div>";
    }

    //Return a formatted success message
    function successMsg($msg)
    {
        return "<div class=\"successMsg\">$msg</div>";
    }

}
