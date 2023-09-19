<?php

namespace App\Http\Controllers\Api;

use App\DTOs\LeadDTO;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'source' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png'],
            'owner' => ['required', 'exists:users,id'],
        ]);

        $imagePath = $request->file('source')->store('uploads/images');

        $lead = Candidate::create([
            'name' => $request->input('name'),
            'source' => $imagePath,
            'owner' => $request->input('owner'),
            'created_by' => Auth::user()->id,
        ]);

        $data = LeadDTO::from($lead);

        return response()->json($data, 200);
    }
}
