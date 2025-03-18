<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManualRequest;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Manual;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rules\RecaptchaRule;
use Illuminate\Support\Facades\File;
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

    public function manuals(Request $request)
    {
        $query = Manual::with('category', 'user', 'admin');
        
        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        // Handle filter
        if ($request->has('filter') && in_array($request->filter, ['approved', 'pending', 'rejected'])) {
            $query->where('status', $request->filter);
        }
        
        $manuals = $query->get();
        $statuses = Manual::$statuses;
        
        // Calculate counts for filters
        $allCount = Manual::count();
        $approvedCount = Manual::where('status', 'approved')->count();
        $pendingCount = Manual::where('status', 'pending')->count();
        $rejectedCount = Manual::where('status', 'rejected')->count();
        
        return view("admin.pages.manual.index", compact(
            "manuals", 
            "statuses", 
            "allCount", 
            "approvedCount", 
            "pendingCount", 
            "rejectedCount"
        ));
    }

    public function storeManual(StoreManualRequest $request)
    {
        // Create new manual instance
        $manual = new Manual();
        $manual->title = $request->manual_title;
        $manual->description = $request->manual_description;
        $manual->category_id = $request->category_id;
        $manual->uploaded_by_admin = Auth::guard('admin')->id();
        $manual->uploaded_by = null;
        $manual->status = 'approved'; // Auto-approve when added by admin
    
        // Handle file upload
        if ($request->hasFile("manual_file") && $request->file("manual_file")->isValid()) {
            $fileName = $request->file("manual_file")->store('', 'public');
            $filePath = "uploads/manuals/$fileName";
    
            // Full path for storing in database
            $manual->file_path = $filePath;
    
            // Get the file size in MB
            $manual->file_size = number_format($request->file('manual_file')->getSize() / (1024 * 1024), 2);
    
            $manual->save();
            
            return redirect()->route('admin.manuals.index')
                ->with('success', 'Manual added successfully.');
        }
        
        return redirect()->back()
            ->with('error', 'Failed to upload manual file.')
            ->withInput();
    }

    public function downloadManual(Manual $manual) 
    {
        $filePath = public_path($manual->file_path);
    
        if(!file_exists($filePath)) {
            abort(404);
        }
    
        $fileName = "{$manual->title}.pdf";
        
        return response()->download($filePath, $fileName);
    }

    public function approveManual(Manual $manual) 
    {

        // Check if the manual is already approved
        if ($manual->status == 'approved') {
            return redirect()->back()->with('error','Manual is already approved.');
        }
        $manual->status = "approved";
        $manual->save();

        return back()->with("success","Manual approved successfully.");
    }

    public function rejectManual (Manual $manual) 
    {

        // Check if the manual is already rejected
        if ($manual->status == "rejected") {
            return redirect()->back()->with('error','Manual is already rejected.');
        }
        $manual->status = "rejected";
        $manual->save();

        return back()->with("success","Manual rejected successfully.");
    }

    public function destroyManual (Manual $manual) 
    {
        if($manual->file_path && File::exists(public_path($manual->file_path))) {
            File::delete(public_path($manual->file_path));
        }

        $manual->delete();
    
        return back()->with("success", "Manual deleted successfully.");
    }

    public function complaints(Request $request) 
    {
        $query = Complaint::with('manual', 'user');
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('manual', function($mq) use ($searchTerm) {
                    $mq->where('title', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('user', function($uq) use ($searchTerm) {
                    $uq->where('name', 'like', "%{$searchTerm}%")
                       ->orWhere('email', 'like', "%{$searchTerm}%");
                })
                ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        // Handle filter functionality
        if ($request->has('filter') && in_array($request->filter, ['pending', 'resolved', 'dismissed'])) {
            $query->where('status', $request->filter);
        }
        
        $complaints = $query->get();
        $statuses = Complaint::$statuses;
        $admin = Auth::user();
        
        // Calculate counts for filters
        $allCount = Complaint::count();
        $pendingCount = Complaint::where('status', 'pending')->count();
        $resolvedCount = Complaint::where('status', 'resolved')->count();
        $dismissedCount = Complaint::where('status', 'dismissed')->count();
        
        return view('admin/pages/complaint/index', compact(
            'complaints',
            'statuses', 
            'admin',
            'allCount',
            'pendingCount',
            'resolvedCount',
            'dismissedCount'
        ));
    }

    public function resolveComplaint (Complaint $complaint) 
    {
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

    public function users(Request $request) 
    {
        $query = User::query();
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        // Handle filter functionality
        if ($request->has('filter')) {
            if ($request->filter === 'banned') {
                $query->where('is_banned', 1);
            } elseif ($request->filter === 'active') {
                $query->where('is_banned', 0);
            }
        }
        
        $users = $query->get();
        $totalUsers = User::count();
        $bannedUsers = User::where('is_banned', 1)->count();
        $activeUsers = User::where('is_banned', 0)->count();
        
        return view('admin.pages.user.index', compact('users', 'totalUsers', 'bannedUsers', 'activeUsers'));
    }

    public function banUser (User $user) 
    {
        // Check if the user is already banned
        if ($user->is_banned) {
            return redirect()->back()->with('error','User is already banned.');
        }

        $user->is_banned = true;
        $user->save();

        return redirect()->back()->with('success','User banned successfully.');
    }

    public function unbanUser (User $user) 
    {
        if (!$user->is_banned) {
            return redirect()->back()->with('error','User is already unbanned.');
        }

        $user->is_banned = false;
        $user->save();
        return redirect()->back()->with('success','User unbanned successfully.');
    }

    public function createUser () 
    {
        return view('admin.pages.user.create');
    }

    public function storeUser (Request $request) 
    {
        
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

    public function deleteUser(User $user) 
    {
        // Delete the user
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function createManual()
    {
        $categories = Category::all();
        return view('admin.pages.manual.create', compact('categories'));
    }
    

}
