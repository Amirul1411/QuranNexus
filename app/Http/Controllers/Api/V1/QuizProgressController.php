<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class QuizProgressController extends Controller
{
    public function startQuiz(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validate request
            $request->validate([
                'surah_id' => 'required|string'
            ]);
            
            $surahId = $request->input('surah_id');
            
            Log::info('Starting quiz', [
                'user_id' => $user->_id,
                'surah_id' => $surahId
            ]);
            
            // Check for existing quiz
            $existingQuiz = collect($user->quiz_progress ?? [])->firstWhere('surah_id', $surahId);
            
            if ($existingQuiz) {
                return response()->json([
                    'message' => 'Quiz already started', 
                    'quiz' => $existingQuiz
                ], 200);
            }
            
            // Create new quiz progress
            $newQuiz = [
                'surah_id' => $surahId,
                'current_ayah_index' => "1",
                'current_question_id' => 1,
                'correct_answers' => 0,
                'wrong_answers' => 0,
                'answers' => [],
                'start_time' => Carbon::now()->toDateTimeString(),
                'end_time' => null,
                'status' => 'in-progress'
            ];
            
            $user = $user->updateQuizProgress($surahId, $newQuiz);
            
            return response()->json([
                'message' => 'Quiz started successfully',
                'quiz' => $newQuiz
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Error starting quiz', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Failed to start quiz',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function submitAnswer(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'surah_id' => 'required|string',
                'ayah_key' => 'required|string',
                'question_id' => 'required|integer',
                'selected_answer' => 'required|string',
                'correct_answer' => 'required|string'
            ]);
            
            $user = Auth::user();
            $surahId = $request->input('surah_id');
            $ayahKey = $request->input('ayah_key');
            $questionId = $request->input('question_id');
            $selectedAnswer = $request->input('selected_answer');
            $correctAnswer = $request->input('correct_answer');
            
            Log::info('Submitting answer', [
                'user_id' => $user->_id,
                'surah_id' => $surahId,
                'question_id' => $questionId
            ]);
            
            // Find existing quiz progress
            $quizProgress = collect($user->quiz_progress ?? [])->firstWhere('surah_id', $surahId);
            
            if (!$quizProgress) {
                return response()->json(['message' => 'Quiz not found'], 404);
            }
            
            $isCorrect = $selectedAnswer === $correctAnswer;
            
            // Update quiz progress
            $updatedQuiz = array_merge($quizProgress, [
                'answers' => array_merge($quizProgress['answers'], [[
                    'ayah_key' => $ayahKey,
                    'question_id' => $questionId,
                    'selected_answer' => $selectedAnswer,
                    'is_correct' => $isCorrect
                ]]),
                'correct_answers' => $quizProgress['correct_answers'] + ($isCorrect ? 1 : 0),
                'wrong_answers' => $quizProgress['wrong_answers'] + ($isCorrect ? 0 : 1),
                'current_question_id' => $quizProgress['current_question_id'] + 1
            ]);
            
            $user = $user->updateQuizProgress($surahId, $updatedQuiz);
            
            return response()->json([
                'message' => 'Answer submitted',
                'is_correct' => $isCorrect,
                'current_question_id' => $updatedQuiz['current_question_id']
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error submitting answer', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Failed to submit answer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function submitBatchAnswers(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validate request
            $request->validate([
                'surah_id' => 'required|string',
                'answers' => 'required|array|size:10',
                'answers.*.ayah_key' => 'required|string',
                'answers.*.question_id' => 'required|integer',
                'answers.*.selected_answer' => 'required|string',
                'answers.*.correct_answer' => 'required|string'
            ]);
            
            $surahId = $request->input('surah_id');
            $answers = $request->input('answers');
            
            // Get existing quiz progress
            $quizProgress = collect($user->quiz_progress ?? [])->firstWhere('surah_id', $surahId);
            
            if (!$quizProgress) {
                return response()->json(['message' => 'Quiz not found'], 404);
            }
            
            // Calculate statistics
            $correctAnswers = 0;
            $processedAnswers = [];
            
            foreach ($answers as $answer) {
                $isCorrect = $answer['selected_answer'] === $answer['correct_answer'];
                $correctAnswers += $isCorrect ? 1 : 0;
                
                $processedAnswers[] = [
                    'ayah_key' => $answer['ayah_key'],
                    'question_id' => $answer['question_id'],
                    'selected_answer' => $answer['selected_answer'],
                    'is_correct' => $isCorrect
                ];
            }
            
            // Update quiz progress
            $updatedQuiz = array_merge($quizProgress, [
                'answers' => array_merge($quizProgress['answers'], $processedAnswers),
                'correct_answers' => $quizProgress['correct_answers'] + $correctAnswers,
                'wrong_answers' => $quizProgress['wrong_answers'] + (count($answers) - $correctAnswers),
                'current_question_id' => $quizProgress['current_question_id'] + count($answers)
            ]);
            
            $user = $user->updateQuizProgress($surahId, $updatedQuiz);
            
            return response()->json([
                'message' => 'Batch answers submitted successfully',
                'correct_answers' => $correctAnswers,
                'total_questions' => count($answers)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error submitting batch answers', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Failed to submit batch answers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getQuizProgress(Request $request)
    {
        try {
            $user = Auth::user();
            $surahId = $request->input('surah_id');
            
            $quiz = collect($user->quiz_progress ?? [])->firstWhere('surah_id', $surahId);
            
            if (!$quiz) {
                return response()->json(['message' => 'Quiz not found'], 404);
            }
            
            return response()->json(['quiz' => $quiz], 200);
            
        } catch (\Exception $e) {
            Log::error('Error getting quiz progress', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Failed to get quiz progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function finishQuiz(Request $request)
    {
        try {
            $user = Auth::user();
            $surahId = $request->input('surah_id');
            
            $quizProgress = collect($user->quiz_progress ?? [])->firstWhere('surah_id', $surahId);
            
            if (!$quizProgress) {
                return response()->json(['message' => 'Quiz not found'], 404);
            }
            
            // Update quiz status
            $updatedQuiz = array_merge($quizProgress, [
                'status' => 'completed',
                'end_time' => now()
            ]);
            
            $user = $user->updateQuizProgress($surahId, $updatedQuiz);
            
            return response()->json(['message' => 'Quiz completed'], 200);
            
        } catch (\Exception $e) {
            Log::error('Error finishing quiz', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Failed to finish quiz',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}