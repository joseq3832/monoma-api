<?php

namespace Src\Infraestructure\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Src\Infraestructure\Contracts\ILeadRepository;
use Src\Infraestructure\DTOs\LeadDTO;
use Src\Infraestructure\Models\Candidate;

final class LeadRepository implements ILeadRepository
{
    public function index()
    {
        $role = auth()->payload()->get('role');
        $user = auth()->user();

        $cacheKey = ($role === 'manager') ? 'candidates:all' : ('candidates:user_'.$user->id);

        $leads = Cache::remember($cacheKey, 3600, function () use ($role, $user) {
            return Candidate::when($role === 'agent', function ($query) use ($user) {
                return $query->where('owner', $user->id);
            })->get();
        });

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

        Cache::forget('candidates:*');

        $data = LeadDTO::from($lead);

        return response()->json($data, 200);
    }

    public function show(int $id)
    {
        $cacheKey = 'candidate:'.$id;

        $candidate = Cache::remember($cacheKey, 3600, function () use ($id) {
            return Candidate::find($id);
        });

        if (! $candidate) {
            return response()->json(['errors' => 'No lead found'], 404);
        }

        $data = LeadDTO::from($candidate);

        return response()->json($data, 200);
    }
}
