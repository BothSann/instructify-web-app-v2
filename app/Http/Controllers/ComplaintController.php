<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $complaints = Complaint::where('user_id', Auth::id())->get();
        return view("frontend.pages.complaint.index", compact("complaints"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $manualId = $request->query('manual_id');

        if(!$manualId) {
            return redirect()->route('manuals.index')->with('error','Please select a manual to file a complaint.');
        }

        $complaintTypes = Complaint::$complaintTypes;

        $manual = Manual::findOrFail($manualId);
        return view("frontend.pages.complaint.create", compact("manual", "complaintTypes"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        //
        // dd($request->all());
        $complaint = new Complaint();
        $complaint->manual_id = $request->manual_id;
        $complaint->user_id = Auth::id();
        $complaint->complaint_type = $request->complaint_type;
        $complaint->description = $request->description;
        $complaint->save();

        return redirect()->route("complaints.index")->with('success', 'Complaint uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
