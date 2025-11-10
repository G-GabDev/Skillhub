<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    // 🔓 Public can view proposals (for display in project details)
    public function index()
    {
        $proposals = Proposal::with(['project', 'user'])->latest()->get();
        return response()->json($proposals);
    }

    // 🔒 Only logged-in users can submit a proposal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'cover_letter' => 'required|string',
            'bid_amount' => 'required|numeric|min:0',
        ]);

        $proposal = Proposal::create([
            'user_id' => Auth::id(),
            'project_id' => $validated['project_id'],
            'cover_letter' => $validated['cover_letter'],
            'bid_amount' => $validated['bid_amount'],
        ]);

        return response()->json($proposal, 201);
    }

    // 🔒 Only the freelancer who made the proposal can update it
    public function update(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);

        if ($proposal->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'cover_letter' => 'sometimes|string',
            'bid_amount' => 'sometimes|numeric|min:0',
            'status' => 'in:pending,accepted,rejected',
        ]);

        $proposal->update($validated);

        return response()->json($proposal);
    }

    // 🔒 Only the freelancer can delete their proposal
    public function destroy($id)
    {
        $proposal = Proposal::findOrFail($id);

        if ($proposal->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $proposal->delete();

        return response()->json(['message' => 'Proposal deleted successfully']);
    }
}
