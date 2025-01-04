<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuizProgressController extends Controller
{
    public function startQuiz(Request $request) {
        $user = Auth::user();
        $surahId = $request->input('surah_id');
        
        $existingQuiz = collect($user->quiz_progress)->firstWhere('surah_id', $surahId);
    
        if ($existingQuiz) {
            return response()->json(['message' => 'Quiz already started', 'quiz' => $existingQuiz], 200);
        }
    
        $newQuiz = [
            'surah_id' => $surahId,
            'current_ayah_index' => "1",
            'current_question_id' => 1,
            'correct_answers' => 0,
            'wrong_answers' => 0,
            'answers' => [],
            'start_time' => now(),
            'end_time' => null,
            'status' => 'in-progress'
        ];
    
        $user->push('quiz_progress', $newQuiz);
        $user->save();
    
        return response()->json(['message' => 'Quiz started successfully', 'quiz' => $newQuiz], 201);
    }
    

    public function submitAnswer(Request $request) {
        $user = Auth::user();
        $surahId = $request->input('surah_id');
        $ayahKey = $request->input('ayah_key');
        $questionId = $request->input('question_id');
        $selectedAnswer = $request->input('selected_answer');
        $correctAnswer = $request->input('correct_answer');
    
        $quizIndex = collect($user->quiz_progress)->search(function ($quiz) use ($surahId) {
            return $quiz['surah_id'] == $surahId;
        });
    
        if ($quizIndex === false) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
    
        $isCorrect = $selectedAnswer === $correctAnswer;
    
        $user->quiz_progress[$quizIndex]['answers'][] = [
            'ayah_key' => $ayahKey,
            'question_id' => $questionId,
            'selected_answer' => $selectedAnswer,
            'is_correct' => $isCorrect
        ];
    
        if ($isCorrect) {
            $user->quiz_progress[$quizIndex]['correct_answers']++;
        } else {
            $user->quiz_progress[$quizIndex]['wrong_answers']++;
        }
    
        $user->quiz_progress[$quizIndex]['current_question_id']++;
    
        $user->save();
    
        return response()->json([
            'message' => 'Answer submitted',
            'is_correct' => $isCorrect,
            'current_question_id' => $user->quiz_progress[$quizIndex]['current_question_id']
        ], 200);
    }
    

    public function getQuizProgress(Request $request) {
        $user = Auth::user();
        $surahId = $request->input('surah_id');
    
        $quiz = collect($user->quiz_progress)->firstWhere('surah_id', $surahId);
    
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
    
        return response()->json(['quiz' => $quiz], 200);
    }
    
    
    public function finishQuiz(Request $request) {
        $user = Auth::user();
        $surahId = $request->input('surah_id');
    
        $quizIndex = collect($user->quiz_progress)->search(function ($quiz) use ($surahId) {
            return $quiz['surah_id'] == $surahId;
        });
    
        if ($quizIndex === false) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
    
        $user->quiz_progress[$quizIndex]['status'] = 'completed';
        $user->quiz_progress[$quizIndex]['end_time'] = now();
    
        $user->save();
    
        return response()->json(['message' => 'Quiz completed'], 200);
    }
}    
