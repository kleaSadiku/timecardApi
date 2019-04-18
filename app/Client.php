<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Project;

class Client extends Model
{
   protected $fillable = [
       'name', 'email', 'description', 'phone', 'nipt'
   ];

   public function project() {
      return $this->hasMany(Project::class);
   }
}
