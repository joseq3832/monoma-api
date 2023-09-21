<?php

namespace App\Http\Controllers\Api;

use App\DTOs\LeadDTO;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager')->except('index');
    }

    public function index()
    {
        $role = auth()->payload()->get('role');
        $user = auth()->user();

        $leads = Candidate::when($role === 'agent', function ($query) use ($user) {
            return $query->where('owner', $user->id);
        })->get();

        $data = LeadDTO::collection($leads);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'source' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png'],
            'owner' => ['required', 'exists:users,id'],
        ]);

        $image = $request->file('source');
        $imageName = $image->getClientOriginalName();

        $imagePath = $image->storeAs('uploads/images', $imageName);

        $lead = Candidate::create([
            'name' => $request->input('name'),
            'source' => $imagePath,
            'owner' => $request->input('owner'),
            'created_by' => Auth::user()->id,
        ]);

        $data = LeadDTO::from($lead);

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $candidate = Candidate::find($id);

        if (! $candidate) {
            return response()->json(['errors' => 'No lead found'], 404);
        }

        $data = LeadDTO::from($candidate);

        return response()->json($data, 200);
    }
}
