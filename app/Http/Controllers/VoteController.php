<?php

namespace App\Http\Controllers;

use App\Models\vote;
use App\Models\question;
use App\Models\option;
use App\Models\result;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $sortOrder = $request->query('sort', 'desc');
        $filter = $request->query('filter', '');

        $query = Vote::orderBy('created_at', $sortOrder);

        if ($filter == 'berjalan') {
            $query->where('status', 'open');
        } elseif ($filter == 'selesai') {
            $query->where('status', 'closed');
        }

        $vote = $query->get();

        if ($request->ajax()) {
            return response()->json(['vote' => $vote]);
        }

        return view('voting.vote', compact('vote'));
    }

    public function getChartData($slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options')->firstOrFail();

        $chartData = [];

        foreach ($vote->questions as $question) {
            $options = $question->options->map(function ($option) {
                return [
                    'label' => $option->option,
                    'count' => Result::where('option_id', $option->id)->count(),
                ];
            });

            $chartData[] = [
                'question' => $question->question,
                'options' => $options,
            ];
        }

        return response()->json($chartData);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'visibility' => 'required|in:public,private',
            ]);

            $vote = new Vote();
            $vote->title = $request->title;
            $vote->slug = Str::slug($request->title);
            $vote->description = $request->description;
            $vote->close_date = $request->close_date;
            $vote->result_visibility = $request->visibility;
            $vote->status = 'open';

            if ($request->has('require_name') && $request->require_name) {
                $vote->name = 'required';
            }

            if ($request->has('is_protected') && $request->is_protected) {
                $vote->code = $request->access_code;
            }

            $vote->save();

            if (!empty($request->questions)) {
                foreach ($request->questions as $questionKey => $questionText) {
                    $question = new Question();
                    $question->vote_id = $vote->id;
                    $question->question = $questionText;
                    $question->save();

                    if (isset($request->choices[$questionKey]) && is_array($request->choices[$questionKey])) {
                        foreach ($request->choices[$questionKey] as $index => $optionText) {
                            $option = new Option();
                            $option->question_id = $question->id;
                            $option->option = $optionText;
                            $option->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return redirect()->route('vote.index')->with('success', 'Vote created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options')->firstOrFail();

        return view('voting.detailvote', compact('vote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $vote = Vote::where('slug', $slug)->with(['questions.options'])->firstOrFail();
        return view('voting.editvote', compact('vote'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $vote = Vote::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'close_date' => 'required|date',
            'visibility' => 'required|in:public,private',
        ]);

        $vote->title = $request->title;
        $vote->description = $request->description;
        $vote->close_date = $request->close_date;
        $vote->result_visibility = $request->visibility;

        if ($request->has('is_protected') && $request->is_protected == 'on') {
            $vote->code = $request->access_code;
        } else {
            $vote->code = null;
        }

        $vote->name = $request->has('require_name') && $request->require_name == 'on' ? 'required' : null;

        $vote->save();

        if ($request->has('deleted_questions')) {
            Question::whereIn('id', $request->deleted_questions)->delete();
        }

        foreach ($request->questions as $key => $questionText) {
            preg_match('/question_\d+_(\d+)/', $key, $matches);
            $questionId = $matches[1] ?? null;

            if ($questionId) {
                $question = Question::find($questionId);
                if ($question) {
                    $question->question = $questionText;
                    $question->save();

                    Option::where('question_id', $questionId)->delete();
                } else {
                    $question = new Question();
                    $question->vote_id = $vote->id;
                    $question->question = $questionText;
                    $question->save();
                    $questionId = $question->id;
                }
            } else {
                $question = new Question();
                $question->vote_id = $vote->id;
                $question->question = $questionText;
                $question->save();
                $questionId = $question->id;
            }

            if (isset($request->choices[$key])) {
                $choices = $request->choices[$key];
                $images = $request->choice_images[$key] ?? [];

                foreach ($choices as $index => $optionText) {
                    $option = new Option();
                    $option->question_id = $questionId;
                    $option->option = $optionText;
                    $option->image = $images[$index] ?? null;
                    $option->save();
                }
            }
        }

        return redirect()->route('vote.detail', ['slug' => $vote->slug])->with('success', 'Vote berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $vote = Vote::where('slug', $slug)->firstOrFail();
        $vote->delete();

        return redirect()->route('vote.index')->with('success', 'Vote berhasil dihapus');
    }
}
