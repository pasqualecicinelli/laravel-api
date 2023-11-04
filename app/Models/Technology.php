<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    // Nasconde le tabelle ponte quando vediamo le api projects
    protected $hidden = ['pivot'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}