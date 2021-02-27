<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const STATUS_TODO = 'to_do';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    const STATUSES = [
        self::STATUS_TODO,
        self::STATUS_IN_PROGRESS,
        self::STATUS_DONE
    ];

    protected $fillable = [
        'project_id', 'name', 'description', 'status', 'attachments', 'assigned_to'
    ];

    protected $casts = [
        'attachments' => 'array'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
