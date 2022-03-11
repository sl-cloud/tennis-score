<?php
/**
 * A sample script to compute the state of a tennis game
 * This script requires minimum PHP 7 to run
 * The script can be run in both cli and web
 * 
 * @author Steve Lee
 * @version 0.0.1
 */

/**
 * A function to print a string and add a new line
 *
 * @param STRING $message - message to print
 *
 */
function printOutput(string $message)
{
    if (php_sapi_name() == 'cli') {
        echo $message . PHP_EOL;
    } else {
        echo $message . "<Br/>\n";
    }
}

/**
 * This function will take 3 parameters from user and will return the current state of the game as a string
 *
 * @param STRING $nameP1 - the name of the first player
 * @param STRING $nameP2 - the name of the second player
 * @param ARRAY $wins - an array of strings listing the name of each points winner
 *            
 * @return STRING $state - The state of the game as a string
 *               
 */
function computeGameState(string $nameP1, string $nameP2, array $wins)
{
    $state = '';
    $winner = '';

    // number of wins for player 1
    $p1Wins = 0;

    // number of wins for player 2
    $p2Wins = 0;

    // Possible scores not including DEUCE and ADVANTAGE
    $scores = [0, 15, 30, 40];
    
    //default scores
    $p1Score = 0;
    $p2Score = 0;

    //Check for empty array
    if(empty($wins)) {
        $state = "{$nameP1} {$p1Score} - {$nameP2} {$p2Score}";
    } else {
        // We will loop the $wins array and calculate the game state
        foreach ($wins as $player) {
            // We will make sure the name of the player matches either player 1 or player 2 or we will throw an exception
            if ($player != $nameP1 AND $player != $nameP2) {
                printOutput(print_r($wins, 1));
                throw new Exception("$player is not in the match.  Please check your input array.");
                
            } else {
                // Incrementing number of wins for each player
                if ($player == $nameP1) {
                    $p1Wins ++;
                } else {
                    $p2Wins ++;
                }
            }
            
            // A player needs to win at least 4 points before they can win the game
            if ($p1Wins < 4 AND $p2Wins < 4) {
                $p1Score = $scores[$p1Wins];
                $p2Score = $scores[$p2Wins];
                
                //Both players have the same number of wins
                if ($p1Wins == $p2Wins) {
                    //If number of wins reaches 3 and the scores are the same, than it is DEUCE.
                    //This can happen when the score is 40 - 40
                    if($p1Wins == 3) {
                        $state = "DEUCE";
                    } else {
                        $state = "{$p1Score}a";
                    } 
                } else {
                    $state = "{$nameP1} {$p1Score} - {$nameP2} {$p2Score}";
                }
            } else {
                /**
                 * Once at least one of the player reaches 4 wins, we can compute for DUECE, ADVANTAGE, or WIN
                 * Note the score can be DUECE even if no player have 4 wins
                 * 
                 * These are the possiblities:
                 * 1) If the difference in wins is less than 2, it is advantage to the player with higher wins
                 * 2) If the difference is 2, the player wins the game
                 * 3) If the wins are the same, then it is DEUCE
                 */
                
                //We will find the leading player
                if($p1Wins != $p2Wins) {
                    if($p1Wins > $p2Wins) {
                        $winner = $nameP1;
                        $diff = $p1Wins - $p2Wins;
                    } else {
                        $winner = $nameP2;
                        $diff = $p2Wins - $p1Wins;
                    }
                    
                    if($diff < 2) {
                        $state = "{$winner} Advantage";
                    } else {
                        //Game won
                        $state = "{$winner} WINS";
                        return $state;
                    } 
                } else {
                    //Deuce
                    $state = "DEUCE";
                }
            }
        }
    }

    return $state;
}

/**
 * Running the script with preset data and expected results
 */

try {
    $player1 = 'Bob';
    $player2 = 'Anna';
    
    //0-0
    $wins = [];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //Anna winning 15 - 30
    $wins = ['Anna', 'Bob', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //15a
    $wins = ['Bob','Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //30a
    $wins = ['Bob','Bob', 'Anna', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //Anna wins
    $wins = ['Bob','Bob','Anna','Anna','Anna','Bob','Anna','Bob','Bob','Anna','Anna','Anna','Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //DEUCE on 40 - 40
    $wins = ['Bob','Bob','Bob', 'Anna', 'Anna', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);

    //Bob Advantage from 40 - 40 DUECE
    $wins = ['Bob','Bob','Bob', 'Anna', 'Anna', 'Anna', 'Bob'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //DEUCE when one of more play won more than 3 games
    $wins = ['Bob','Bob','Bob', 'Anna', 'Anna', 'Anna', 'Bob', 'Anna', 'Bob', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //Bob wins even when we provide more data in the array then needed
    $wins = ['Bob','Bob','Bob', 'Anna', 'Anna', 'Anna', 'Bob', 'Bob', 'Anna', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //Anna Advantage from DUECE not 40 - 40
    $wins = ['Bob','Bob','Bob', 'Anna', 'Anna', 'Anna', 'Bob', 'Anna', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //30 - 15
    $wins = ['Bob', 'Anna', 'Bob'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    //15 - 40
    $wins = ['Anna', 'Anna', 'Bob', 'Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    
    /**
    //Typecast error
    $wins = 'Bob';
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);
    **/ 
    
    //Expecting exception
    $wins = ['Bob','Bob','Anna','Ann','Anna','Bob','Anna','Bob','Bob','Anna','Anna','Anna','Anna'];
    $state = computeGameState($player1, $player2, $wins);
    printOutput($state);       
    
} catch (Exception $e) {
    // catch exception
    printOutput('Error: ' . $e->getMessage());
}
