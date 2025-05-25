<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'entity', 'entity_id', 'file_path', 'original_name',
    ];

    public function entity()
    {
        switch ($this->entity) {
            case 'user':
                return $this->belongsTo(User::class, 'entity_id');
            case 'project':
                return $this->belongsTo(Project::class, 'entity_id');
            case 'task':
                return $this->belongsTo(Task::class, 'entity_id');
            default:
                return null;
        }
    }
}