<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['task_name', 'priority', 'project_id'];

    public function task()
    {
        return $this->belongsTo(Project::class);
    }


}
