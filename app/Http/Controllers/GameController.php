<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    // Return view of the game
    public function index()
    {
        return view('game');
    }

    // API Endpoint to start a new session
    // Will start a new session and return
    // the session ID
    public function startGame()
    {
        $new_session = new Game;
        $new_session->save();
        return $new_session;
    }

    // API Endpoint to save score
    public function saveScore($session_id)
    {
        // Get the game session
        $session = Game::find($session_id);

        // If game is already finished, return error
        if ($session->finished) {
            return response()->json([
                'error' => 'Game is already finished'
            ], 400);
        }

        // Get the score from the body
        $score = intval(request()->getContent());
        
        // Update the score of the game
        Game::where('id', $session_id)
            ->update(['score' => $score]);
    }

    // API Endpoint to end game session
    public function endGame($session_id)
    {
        // Update the score of the game
        Game::where('id', $session_id)
            ->update(['finished' => true, 'finished_at' => now()]);
    }

    // Leaderboard
    public function leaderboard()
    {
        // Get all games that have ended, ordered by score
        $games = Game::where('finished', true)->orderBy('score', 'desc')->get();

        $result = "<ol>";

        foreach ($games as $game) {
            $result .= "<li>{$game->score} pts</li>";
        }

        $result .= "</ol>";

        return $result;
    }
}
