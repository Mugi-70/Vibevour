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

    public function voting($slug)
    {
        $vote = Vote::where('slug', $slug)->with(['questions.options'])->firstOrFail();


        foreach ($vote->questions as $question) {
            foreach ($question->options as $option) {
                $option->image = Storage::url('options/' . $option->image);
                // dd($option);
            }
        }

        return view('voting.voting', compact('vote', 'slug'));
    }

    public function getVoteData($slug)
    {
        $vote = Vote::where('slug', $slug)->with(['questions.options'])->firstOrFail();
        return response()->json([
            'vote' => [
                'title' => $vote->title,
                'created_at' => Carbon::parse($vote->created_at)->format('d/m/y'),
                'description' => $vote->description,
                'open_date' => $vote->open_date,
                'close_date' => Carbon::parse($vote->close_date)->format('d/m/y' . ' H:i'),
                'result_visibility' => $vote->result_visibility,
                'require_name' => $vote->require_name,
                'questions' => $vote->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'type' => $question->type,
                        'required' => $question->required,
                        'options' => $question->options->map(function ($option) {
                            return [
                                'id' => $option->id,
                                'option' => $option->option,
                                'image' => $option->image ? url('storage/options/' . $option->image) : null
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
            session([
                "verified_vote_{$slug}" => true,
                "verified_vote_{$slug}_expires_at" => now()->addMinutes(10)
            ]);
        }

        return response()->json(['valid' => $valid]);
    }

    public function checkAccessSession($slug)
    {
        $vote = Vote::where('slug', $slug)->firstOrFail();

        if (!$vote->is_protected) {
            return response()->json([
                'verified' => true
            ]);
        }

        $expiresAt = session("verified_vote_{$slug}_expires_at");
        $verified = session()->has("verified_vote_{$slug}")
            && $expiresAt && now()->lessThan($expiresAt);

        if (!$verified) {
            session()->forget([
                "verified_vote_{$slug}",
                "verified_vote_{$slug}_expires_at"
            ]);
        }

        return response()->json([
            'verified' => $verified
        ]);
    }

    public function     storeVoteData(Request $request, $slug)
    {
        $vote = Vote::where('slug', $slug)->firstOrFail();

        if ($vote->status === 'closed') {
            return response()->json(['message' => 'Voting telah ditutup.'], 403);
        }

        $rules = [
            'votes' => 'nullable|array',
            'votes.*' => 'exists:options,id',
        ];

        if ($vote->require_name) {
            $rules['name'] = 'required|string|max:255';
        }

        $request->validate($rules, [
            'votes.*.exists' => 'Opsi yang dipilih tidak valid.',
            'name.required' => 'Nama wajib diisi.',
        ]);

        $voterName = $vote->require_name ? $request->input('name') : null;
        $ipAddress = $request->ip();

        if (!empty($request->votes)) {
            $hasVoted = Result::where('vote_id', $vote->id)
                ->where('ip_address', $ipAddress)
                ->exists();

            if ($hasVoted) {
                return response()->json(['message' => 'Anda sudah melakukan voting sebelumnya.', 'has_voted' => true]);
            }

            foreach ($request->votes as $questionId => $optionIds) {
                if (!is_array($optionIds)) {
                    $optionIds = [$optionIds];
                }

                foreach ($optionIds as $optionId) {
                    Result::create([
                        'vote_id' => $vote->id,
                        'question_id' => $questionId,
                        'option_id' => $optionId,
                        'name' => $voterName,
                        'ip_address' => $ipAddress,
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Vote berhasil dikirim!']);
    }

    public function getVoteSummary($slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options.results')->firstOrFail();

        $results = $vote->questions->flatMap->options->flatMap->results;

        $namedVotes = $results->filter(fn($result) => !is_null($result->name))->unique('name')->count();

        $anonymousVotes = $results->where('name', null)->count();

        $totalVotes = $namedVotes + $anonymousVotes;

        return response()->json([
            'totalVotes' => $totalVotes,
            'accessCode' => $vote->access_code,
            'required_name' => $vote->require_name,
        ]);
    }

    public function getPeople($slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options.results')->firstOrFail();

        $results = $vote->questions->flatMap->options->flatMap->results;

        $people = $results->whereNotNull('name')->unique('name')->pluck('name')->toArray();

        return response()->json([
            'people' => array_values($people)
        ]);
    }

    public function getResult(string $slug)
    {
        $vote = Vote::where('slug', $slug)->with('questions.options.results')->firstOrFail();

        return view('voting.hasilvote', compact('vote'));
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
            // dd($request->all());

            $vote = new Vote();
            $vote->title = $request->title;
            $vote->slug = Str::slug($request->title);
            $vote->description = $request->description;
            $vote->open_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->open_date))->format('Y-m-d H:i:s');
            $vote->result_visibility = $request->visibility;
            $vote->status = 'open';

            if ($request->filled('close_date')) {
                $vote->close_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->close_date))->format('Y-m-d H:i:s');
            }

            $vote->require_name = $request->has('require_name') && $request->require_name ? true : false;

            if ($request->has('is_protected') && $request->is_protected) {
                $vote->is_protected = true;
                $vote->access_code = $request->access_code;
            }

            $vote->save();

            if (!empty($request->questions)) {
                foreach ($request->questions as $questionKey => $questionText) {
                    $question = new Question();
                    $question->vote_id = $vote->id;
                    $question->question = $questionText;
                    $question->type = isset($request->is_multiple[$questionKey]) && $request->is_multiple[$questionKey] ? 'multiple' : 'single';
                    $question->required = isset($request->is_required[$questionKey]) && $request->is_required[$questionKey] ? true : false;
                    $question->save();

                    if (isset($request->choices[$questionKey]) && is_array($request->choices[$questionKey])) {
                        foreach ($request->choices[$questionKey] as $index => $optionText) {
                            $option = new Option();
                            $option->question_id = $question->id;
                            $option->option = $optionText;

                            if ($request->hasFile("choice_images.$questionKey.$index")) {
                                $file = $request->file("choice_images.$questionKey.$index");
                                $imagePath = $file->store('options', 'public');
                                $option->image = basename($imagePath);
                            }

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

        foreach ($vote->questions as $question) {
            foreach ($question->options as $option) {
                if ($option->image) {
                    $option->image = asset('storage/options/' . $option->image);
                }
            }
        }

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
     *   the specified resource in storage.
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
            'questions.*.type' => 'nullable|in:single,multiple',
            'questions.*.required' => 'nullable|boolean',
            'questions.*.options.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'open_date' => 'nullable|date',
            'close_date' => 'nullable|date',
            'require_name' => 'boolean',
            'is_protected' => 'boolean',
            'access_code' => 'nullable|string|max:6',
        ]);

        if ($request->filled('close_date')) {
            $validationRules['close_date'] = 'date|after:open_date';
        }

        $validationMessages = [
            'open_date.before' => 'Tanggal buka vote harus lebih awal dari tanggal tutup vote.',
            'close_date.after' => 'Tanggal tutup vote harus lebih akhir dari tanggal buka vote.'
        ];

        // dd($request->all());

        $vote->title = $request->title;
        $vote->description = $request->description;
        $vote->open_date = Carbon::createFromFormat('d-m-Y H:i', trim($request->open_date))->format('Y-m-d H:i:s');
        $closeDateInput = trim($request->close_date);
        $vote->close_date = $closeDateInput
            ? Carbon::createFromFormat('d-m-Y H:i', $closeDateInput)->format('Y-m-d H:i:s')
            : null;

        $vote->result_visibility = $request->visibility;
        $vote->require_name = $request->require_name ? 1 : 0;
        $vote->is_protected = $request->is_protected ? 1 : 0;
        $vote->access_code = $request->is_protected ? $request->access_code : null;
        $vote->save();

        foreach ($request->questions as $qIndex => $qData) {
            $questionId = $qData['id'] ?? null;

            if ($questionId) {
                $question = Question::find($questionId);
                if ($question) {
                    $question->question = $qData['text'];
                    $question->type = isset($qData['type']) && $qData['type'] === 'multiple' ? 'multiple' : 'single';
                    $question->required = isset($qData['required']) ? true : false;
                    $question->save();
                }
            } else {
                $question = new Question();
                $question->vote_id = $vote->id;
                $question->question = $qData['text'];
                $question->type = isset($qData['type']) && $qData['type'] === 'multiple' ? 'multiple' : 'single';
                $question->required = isset($qData['required']) ? true : false;
                $question->save();
            }

            $existingOptions = $question->options->pluck('id')->toArray();

            if (isset($qData['options'])) {
                foreach ($qData['options'] as $oIndex => $oData) {
                    $optionId = $oData['id'] ?? null;
                    $base64Image = $request->choice_images[$qData['id'] ?? null][$oIndex] ?? null;
                    $removeImage = $request->remove_images[$optionId] ?? false;
                    $filename = null;

                    if ($base64Image) {
                        preg_match("/data:image\/(.*?);base64,(.*)$/", $base64Image, $matches);

                        if (count($matches) == 3) {
                            $extension = $matches[1];
                            $base64Str = $matches[2];
                            $imageDecoded = base64_decode($base64Str);

                            $filename = uniqid() . '.' . $extension;
                            $path = 'options/' . $filename;

                            Storage::disk('public')->put($path, $imageDecoded);
                        }
                    }

                    if (isset($oData['id'])) {
                        $option = Option::find($oData['id']);
                        if ($option) {
                            if ($filename) {
                                if ($option->image) {
                                    Storage::disk('public')->delete($option->image);
                                }
                                $option->image = $filename;
                            } else if ($removeImage) {
                                if ($option->image) {
                                    Storage::disk('public')->delete('options/' . $option->image);
                                }
                                $option->image = null;
                            }
                            $option->option = $oData['text'] ?? $option->option;
                            $option->save();
                        }
                    } else {
                        $newOption = new Option();
                        $newOption->question_id = $question->id;
                        $newOption->option = $oData['text'] ?? '';
                        $newOption->image = $filename;
                        $newOption->save();
                    }
                }
            }

            Option::where('question_id', $question->id)
                ->whereNotIn('id', array_column($qData['options'] ?? [], 'id'))
                ->delete();

            Result::where('question_id', $question->id)->delete();
        }

        return redirect()->route('vote.show', ['slug' => $vote->slug])
            ->with('success', 'Vote berhasil diperbarui.');
    }

    public function deleteQuestion($id)
    {
        try {
            $question = Question::findOrFail($id);

            $question->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pertanyaan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pertanyaan: ' . $e->getMessage()
            ], 500);
        }
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
