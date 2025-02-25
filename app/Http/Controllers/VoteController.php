<?php

namespace App\Http\Controllers;

use App\Models\vote;
use App\Models\question;
use App\Models\option;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vote = Vote::all();
        return view('voting.vote', compact('vote'));

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
    public function show(vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(vote $vote)
    {
        //
    }
}
