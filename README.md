/**
 * I was asked to create a simple PHP script to  
 * compute the status of a tennis game using the
 * rules below  
**/

// REMINDER OF THE TENNIS RULES //

A tennis game is played as follows:

    First score  = 15 points
    Second score = 30 points
    Third score = 40 points

 

After a player reaches 40 points, he or she can:

    Enter a DEUCE state if both players have scored the same number of times
    Enter an ADVANTAGE state if both players scored at least three times AND the player scored one time more than his or her opponent
    WIN the game if he or she has scored at least four times AND two times more than the other player
    
Implement the function computeGameState($nameP1, $nameP2, $wins) which returns the current state of a game.

 

Parameters:

    nameP1, the name of the first player as a string
    nameP2, the name of the second player as a string
    wins, an array of strings listing the name of each ball's winner

 

Expected Result:

The current state of the game as a string:

    P1 0 - P2 0 (with players' names in the same order as given in parameters)
    P1 15 - P2 30
    15a (in case of a 15-15 draw)
    30a (in case of a 30-30 draw)
    P2 WINS
    DEUCE
    P1 ADVANTAGE
    ...    

EXAMPLE:

Parameters

Bob

Anna

Bob, Anna, Bob

Result

Bob 30 - Anna 15    
