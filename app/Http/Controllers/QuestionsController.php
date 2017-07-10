<?php

namespace App\Http\Controllers;

use Anacreation\Etvtest\Converters\ConverterManager;
use Anacreation\Etvtest\Converters\ConverterType;
use Anacreation\Etvtest\Models\Question;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\CreateQuestionService;
use Anacreation\Etvtest\Services\EditQuestionServices;
use App\Http\Requests\Tests\EditTestRequest;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Anacreation\Etvtest\Models\Test $test
     * @return \Illuminate\Http\Response
     */
    public function index(Test $test) {

        $questions = $test->questions()->orderBy('order')->get()->map(function ($question) {
            return ConverterManager::convert($question, ConverterType::EDIT)->getData()[0];
        });

        return view('questions.index', compact('test', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Test $test) {
        return view('questions.create', compact('test'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Test $test, CreateQuestionService $service) {
        $question = $service->create($request->all(), $test->id);

        return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test, Question $question) {
        $this->authorize('edit', Test::class);
        $question = ConverterManager::convert($question, ConverterType::EDIT)->getData();

        return view('questions.edit', compact('test', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test, Question $question, EditQuestionServices $services) {
        $this->authorize('edit', Test::class);
        $services->updateQuestionById($question->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test, Question $question) {
        $question->delete();

        return response(200);
    }

    public function updateOrder(Request $request, EditQuestionServices $services) {
        $this->authorize('edit', Test::class);

        foreach ($request->all() as $question) {
            $services->updateQuestionById($question["id"], $question);
        }

        return response(200);
    }
}
