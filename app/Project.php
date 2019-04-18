<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'code', 'budget', 'from', 'to'
    ];

    protected $guarded = [
        'client_id'
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsToMany(User::class);
    }
}
