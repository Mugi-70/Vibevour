<?php

namespace App\Http\Controllers;

use App\Models\vote;
use App\Models\question;
use App\Models\option;
use App\Models\result;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortOrder = $request->query('sort', 'asc');
        $filter = $request->query('filter', '');
        $startDate = $request->query('start_date', '');
        $endDate = $request->query('end_date', '');

        $query = Vote::query();

        if ($sortOrder == 'a-z') {
            $query->orderBy('title', 'asc');
        } elseif ($sortOrder == 'z-a') {
            $query->orderBy('title', 'desc');
        } elseif ($sortOrder == 'terbaru') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sortOrder == 'terlama') {
            $query->orderBy('created_at', 'asc');
        }

        if ($filter == 'berjalan') {
            $query->where('status', 'open');
        } elseif ($filter == 'selesai') {
            $query->where('status', 'closed');
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
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

    public function vote($slug)
    {
        $vote = Vote::where('slug', $slug)->with(['questions.options'])->firstOrFail();
        return view('voting.voting', compact('vote', 'slug'));
    }

    public function getVoteData($slug)
    {
        $vote = Vote::where('slug', $slug)->with(['questions.options'])->firstOrFail();
        return response()->json([
            'vote' => [
                'title' => $vote->title,
                'created_at' => Carbon::parse($vote->created_at)->format('d/m/y H:i'),
                'description' => $vote->description,
                'close_date' => Carbon::parse($vote->close_date)->format('d/m/y H:i'),
                'questions' => $vote->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'options' => $question->options->map(function ($option) {
                            return [
                                'id' => $option->id,
                                'option' => $option->option
                            ];
                        })
                    ];
                })
            ]
        ]);
    }


    public function checkProtection($slug)
    {
        $vote = Vote::where('slug', $slug)->firstOrFail();
        return response()->json([
            'is_protected' => $vote->is_protected
        ]);
    }

    public function verifyAccess(Request $request, $slug)
    {
        $vote = Vote::where('slug', $slug)->firstOrFail();

        if (!$vote->is_protected) {
            return response()->json(['valid' => true]);
        }

        $accessCode = $request->input('access_code');
        $valid = $vote->access_code === $accessCode;

        if ($valid) {
            session(["verified_vote_{$slug}" => true]);
        }

        return response()->json(['valid' => $valid]);
    }

    public function getVoteSummary($slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options.results')->firstOrFail();

        $totalVotes = $vote->questions->flatMap->options->flatMap->results->count();
        $accessCode = $vote->access_code;

        return response()->json([
            'totalVotes' => $totalVotes,
            'accessCode' => $accessCode,
        ]);
    }


    public function storeVoteData(Request $request, $slug)
    {
        $request->validate([
            'votes' => 'required|array',
            'votes.*' => 'exists:options,id'
        ], [
            'votes.required' => 'Harap pilih setidaknya satu opsi sebelum mengirimkan vote.',
            'votes.*.exists' => 'Opsi yang dipilih tidak valid.'
        ]);

        $vote = Vote::where('slug', $slug)->firstOrFail();

        if ($vote->status === 'closed') {
            return response()->json(['message' => 'Voting telah ditutup.'], 403);
        }

        foreach ($request->votes as $question_id => $option_id) {
            Result::create([
                'vote_id' => $vote->id,
                'question_id' => $question_id,
                'option_id' => $option_id
            ]);
        }

        return response()->json(['message' => 'Vote berhasil disimpan!']);
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
            $validationRules = [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'open_date' => 'required|date_format:d-m-Y H:i',
                'visibility' => 'required|in:public,private',
            ];

            if ($request->filled('close_date')) {
                $validationRules['close_date'] = 'date_format:d-m-Y H:i|after:open_date';
            }

            $validationMessages = [
                'open_date.before' => 'Tanggal buka vote harus lebih awal dari tanggal tutup vote.',
                'close_date.after' => 'Tanggal tutup vote harus lebih akhir dari tanggal buka vote.'
            ];


            $request->validate($validationRules, $validationMessages);

            $vote = new Vote();
            $vote->title = $request->title;
            $vote->slug = Str::slug($request->title);
            $vote->description = $request->description;
            $vote->open_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->open_date))->format('Y-m-d H:i:s');
            $vote->close_date = $request->close_date;
            $vote->result_visibility = $request->visibility;
            $vote->status = 'open';

            if ($request->filled('close_date')) {
                $vote->close_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->close_date))->format('Y-m-d H:i:s');
            }
            if ($request->has('require_name') && $request->require_name) {
                $vote->name = 'required';
            }

            if ($request->has('is_protected') && $request->is_protected) {
                $vote->access_code = $request->access_code;
            }

            // dd($vote);
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
        $vote = Vote::where('slug', $slug)->with('questions.options.results')->firstOrFail();

        return view('voting.detailvote', compact('vote'));
    }

    public function getVoteDetail($slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options.results')->firstOrFail();

        return response()->json($vote);
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

        $validationRules = ([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'visibility' => 'required|in:public,private',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string|max:1000',
            'questions.*.options.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'open_date' => 'nullable|date',
            'close_date' => 'nullable|date',
            'is_protected' => 'boolean',
            'access_code' => 'nullable|string|max:6',
        ]);

        if ($request->filled('close_date')) {
            $validationRules['close_date'] = 'date|after:open_date';
        }


        // dd($validationRules);
        // dd($request->all());
        // dd($request->is_protected);

        $validationMessages = [
            'open_date.before' => 'Tanggal buka vote harus lebih awal dari tanggal tutup vote.',
            'close_date.after' => 'Tanggal tutup vote harus lebih akhir dari tanggal buka vote.'
        ];

        // $request->validate($validationRules, $validationMessages);

        $vote->title = $request->title;
        $vote->description = $request->description;
        $vote->open_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->open_date))->format('Y-m-d H:i:s');
        $vote->close_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->close_date ?: null))->format('Y-m-d H:i:s');
        $vote->result_visibility = $request->visibility;
        $vote->is_protected = $request->is_protected ? 1 : 0;
        $vote->access_code = $request->is_protected ? $request->access_code : null;
        $vote->save();

        foreach ($request->questions as $qIndex => $qData) {
            $questionId = $qData['id'] ?? null;

            if ($questionId) {
                $question = Question::find($questionId);
                if ($question) {
                    $question->question = $qData['text'];
                    $question->save();
                }
            } else {
                $question = new Question();
                $question->vote_id = $vote->id;
                $question->question = $qData['text'];
                $question->save();
            }

            $existingOptions = $question->options->pluck('id')->toArray();

            if (isset($qData['options'])) {
                foreach ($qData['options'] as $oIndex => $oData) {
                    if (!isset($oData['text'])) continue;

                    $optionId = $oData['id'] ?? null;

                    if ($optionId && in_array($optionId, $existingOptions)) {
                        $option = Option::find($optionId);
                        if ($option) {
                            $option->option = $oData['text'];

                            if (isset($oData['image']) && $oData['image']->isValid()) {
                                if ($option->image) {
                                    Storage::delete(str_replace('storage/', 'public/', $option->image));
                                }

                                $imagePath = $oData['image']->store('public/images');
                                $option->image = str_replace('public/', 'storage/', $imagePath);
                            }

                            $option->save();
                        }
                    } else {
                        $option = new Option();
                        $option->question_id = $question->id;
                        $option->option = $oData['text'];

                        if (isset($oData['image']) && $oData['image']->isValid()) {
                            $imagePath = $oData['image']->store('public/images');
                            $option->image = str_replace('public/', 'storage/', $imagePath);
                        }

                        $option->save();
                    }
                }
            }

            Option::where('question_id', $question->id)
                ->whereNotIn('id', array_column($qData['options'] ?? [], 'id'))
                ->delete();
        }

        return redirect()->route('vote.show', ['slug' => $vote->slug])
            ->with('success', 'Vote berhasil diperbarui.');
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
