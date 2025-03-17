<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Complaint;
use App\Models\Manual;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rules\RecaptchaRule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;






class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $manualsCount = Manual::count();
        $complaintsCount = Complaint::count();
        $usersCount = User::count();
        $pendingApprovals = Manual::where('status', 'pending')->count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $rejectedComplaints = Complaint::where('status', 'rejected')->count();  
        return view("admin.dashboard", compact("manualsCount", "complaintsCount", "usersCount", "pendingApprovals", "pendingComplaints", "resolvedComplaints", "rejectedComplaints"));  
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
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function manuals()
    {
        $manuals = Manual::with('category', 'user')->get();
        $statuses = Manual::$statuses;
        return view("admin.pages.manual.index", compact("manuals", "statuses"));
    }

    public function downloadManual(Manual $manual) {
        $filePath = public_path($manual->file_path);
    
        if(!file_exists($filePath)) {
            abort(404);
        }
    
        $fileName = "{$manual->title}.pdf";
        
        return response()->download($filePath, $fileName);
    }

    public function approveManual(Manual $manual) {

        // Check if the manual is already approved
        if ($manual->status == 'approved') {
            return redirect()->back()->with('error','Manual is already approved.');
        }
        $manual->status = "approved";
        $manual->save();

        return back()->with("success","Manual approved successfully.");
    }

    public function rejectManual (Manual $manual) {

        // Check if the manual is already rejected
        if ($manual->status == "rejected") {
            return redirect()->back()->with('error','Manual is already rejected.');
        }
        $manual->status = "rejected";
        $manual->save();

        return back()->with("success","Manual rejected successfully.");
    }

    public function complaints() {
        $complaints = Complaint::with('manual', 'user')->get();
        $statuses = Complaint::$statuses;
        $admin = Auth::user();
        
        return view('admin/pages/complaint/index', compact('complaints','statuses', 'admin'));
    }

    public function resolveComplaint (Complaint $complaint) {
        // Check if the complaint is already dismissed
        if ($complaint->status == 'dismissed') {
            return redirect()->back()->with('error','Complaint has already been dismissed.');
        }
        $complaint->status = "resolved";
        $complaint->save();
        return back()->with("success","Complaint resolved successfully.");
    }

    public function dismissComplaint(Complaint $complaint)
    {
        $complaint->status = 'dismissed';
        $complaint->save();
        
        return redirect()->back()->with('success', 'Complaint has been dismissed');
    }

    public function users() {
        $users = User::all();
        return view('admin.pages.user.index', compact('users'));
    }

    public function banUser (User $user) {
        // Check if the user is already banned
        if ($user->is_banned) {
            return redirect()->back()->with('error','User is already banned.');
        }

        $user->is_banned = true;
        $user->save();

        return redirect()->back()->with('success','User banned successfully.');
    }

    public function unbanUser (User $user) {
        if (!$user->is_banned) {
            return redirect()->back()->with('error','User is already unbanned.');
        }

        $user->is_banned = false;
        $user->save();
        return redirect()->back()->with('success','User unbanned successfully.');
    }

    public function createUser () {
        return view('admin.pages.user.create');
    }

    public function storeUser (Request $request) {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', new RecaptchaRule()],
        ]);



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('admin.users.index')
        ->with('success', 'User created successfully.');
    }
}
