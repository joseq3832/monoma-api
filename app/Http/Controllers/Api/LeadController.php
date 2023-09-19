<?php

namespace App\Http\Controllers\Api;

use App\DTOs\LeadDTO;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Candidate::all();

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

        $imagePath = $request->file('source')->storeAs('uploads/images', $imageName);

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
        try {
            $candidate = Candidate::findOrFail($id);
            $data = LeadDTO::from($candidate);

            return response()->json($data, 200);
        } catch (\Throwable $e) {
            return response()->json(['errors' => 'No lead found'], 404);
        }
    }
}
