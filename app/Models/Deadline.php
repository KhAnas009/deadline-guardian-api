<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
     protected $fillable = [
        'title',
        'description',
        'category',
        'due_date',
        'priority',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
