<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $table = 'todo';
    protected $fillable = ['user', 'task', 'is_done', 'subtask1', 'subtask2', 'subtask3', 'is_subtask1_done', 'is_subtask2_done', 'is_subtask3_done', ];
    
    // relasi 
    /*public function subTasks()
    {
        return $this->hasMany(Todo::class, 'parent_id');
    }*/
    
}
