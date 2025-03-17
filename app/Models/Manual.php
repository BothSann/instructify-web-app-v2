<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    /** @use HasFactory<\Database\Factories\ManualFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'category_id',
        'uploaded_by',
        'status',
    ];

    public static $statuses = [
        'approved' => 'Approved',
        'pending' => 'Pending',
        'rejected' => 'Rejected'
    ];


    /**
     * Get the user that uploaded the manual.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    
    /**
     * Get the category that the manual belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the complaints for the manual.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Scope a query to only include approved manuals.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending manuals.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include rejected manuals.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Relationship with admin users
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by_admin');
    }

    // Helper method to get uploader info regardless of type
    public function getUploaderAttribute()
    {
        if ($this->uploaded_by_admin) {
            return $this->admin;
        }
        
        return $this->user;
    }
}
