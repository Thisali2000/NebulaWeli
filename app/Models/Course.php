<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'location',
        'course_type',
        'course_name',
        'no_of_semesters',
        'duration',
        'training_period',
        'min_credits',
        'entry_qualification',
        'conducted_by',
        'course_medium',
        'course_content',
        'specializations',
        'added_by',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'course_id' => 'int',
        'no_of_semesters' => 'int',
        'min_credits' => 'int',
        'status' => 'boolean',
        'specializations' => 'array',
    ];

    // Relationships
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'course_modules', 'course_id', 'module_id')
                   ->withPivot('is_core', 'semester')
                   ->withTimestamps();
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class, 'course_id', 'course_id');
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class, 'course_id', 'course_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'course_id', 'course_id');
    }

    public function payments()
    {
        return $this->hasMany(PaymentDetail::class, 'course_id', 'course_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'user_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    public function scopeByMedium($query, $medium)
    {
        return $query->where('course_medium', $medium);
    }

    public function scopeConductedBySLT($query)
    {
        return $query->where('conducted_by', true);
    }

    public function scopeExternal($query)
    {
        return $query->where('conducted_by', false);
    }

    // Accessors
    public function getFullCourseNameAttribute()
    {
        return "{$this->course_name}";
    }

    public function getDurationFormattedAttribute()
    {
        if (!$this->duration) {
            return 'Not specified';
        }
        
        $parts = explode('-', $this->duration);
        if (count($parts) !== 3) {
            return $this->duration; // Return as-is if format is unexpected
        }
        
        $years = (int)$parts[0];
        $months = (int)$parts[1];
        $days = (int)$parts[2];
        
        $durationParts = [];
        
        if ($years > 0) {
            $durationParts[] = $years . ' ' . ($years === 1 ? 'year' : 'years');
        }
        
        if ($months > 0) {
            $durationParts[] = $months . ' ' . ($months === 1 ? 'month' : 'months');
        }
        
        if ($days > 0) {
            $durationParts[] = $days . ' ' . ($days === 1 ? 'day' : 'days');
        }
        
        if (empty($durationParts)) {
            return 'Not specified';
        }
        
        return implode(', ', $durationParts);
    }

    public function getTotalFeeAttribute()
    {
        return $this->course_fee + $this->registration_fee;
    }

    // Mutators
    public function setCourseNameAttribute($value)
    {
        $this->attributes['course_name'] = ucwords(strtolower($value));
    }


} 