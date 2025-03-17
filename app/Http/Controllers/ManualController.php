<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manual;
use App\Http\Requests\StoreManualRequest;
use App\Http\Requests\UpdateManualRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manuals = Manual::with(['category', 'user', 'admin'])
            ->where('status', 'approved')
            ->where(function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('is_banned', false);
                })
                ->orWhereNotNull('uploaded_by_admin');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
    // Add categories for the filter dropdown
        $categories = Category::all();
        return view("frontend.pages.manual.index", compact("manuals" ,"categories"));
    }

    public function indexV2() {
        $manuals = Manual::with('category')
            ->where('uploaded_by', Auth::id())
            ->get();
        $statuses = Manual::$statuses;
        return view("frontend.pages.manual.indexv2", compact("manuals", "statuses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view("frontend.pages.manual.create", compact("categories"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManualRequest $request)
    {
        //
        $manual = new Manual();
        $manual->title = $request->manual_title;
        $manual->description = $request->manual_description;
        $manual->category_id = $request->category_id;
        $manual->uploaded_by = Auth::id();

        // Handle file upload
        if($request->hasFile("manual_file") && $request->file("manual_file")->isValid()) {
            $fileName = $request->file("manual_file")->store('', 'public');
            $filePath = "uploads/manuals/$fileName";

            // Full path for storing in database
            $manual->file_path = $filePath; 

            // Get the file size in MB
            $manual->file_size = number_format($request->file('manual_file')->getSize() / (1024 * 1024), 2);

            $manual->save();
        }

        return redirect()->route("manuals.indexv2")->with("success", "Manual uploaded successfully! Waiting for admin approval.");
    }


    /**
     * Search for manuals based on search term.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        // Query with relationships
        $query = Manual::with(['category', 'user']);
        
        // Apply search if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by category if selected
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Apply sorting
        $sortOption = $request->input('sort', 'newest');
        
        switch ($sortOption) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'alphabetical':
                $query->orderBy('title', 'asc');
                break;
            case 'downloads':
                $query->orderBy('created_at', 'desc'); // Fallback to newest
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        // Apply status filter - only show approved manuals
        $query->where('status', 'approved');

        // Filter out manuals from banned users
        $query->whereHas('user', function($q) {
            $q->where('is_banned', false);
        });
        
        // Get results
        $manuals = $query->get();
        
        // Get categories for the filter dropdown
        $categories = Category::all();
        
        // Search indicator for the view
        $searchPerformed = !empty($search);
        
        return view('frontend.pages.manual.index', compact('manuals', 'categories', 'searchPerformed', 'search'));
    }

    /**
    * Download the specified manual file.
    */

    public function download(Manual $manual) {
        $filePath = public_path($manual->file_path);

        if(!file_exists($filePath)) {
            abort(404);
        }

        $fileName = "{$manual->title}.pdf";
        
        return response()->download($filePath, $fileName);
    }


    /**
     * Display the specified resource.
     */
    public function show(Manual $manual)
    {
        // return view("frontend.pages.manual.show", compact('manual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manual $manual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManualRequest $request, Manual $manual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manual $manual)
    {
        //
    }

}
