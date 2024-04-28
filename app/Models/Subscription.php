<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function membership(){
      return $this->belongsTo(Membership::class);
    }

    public function member(){
      return $this->belongsTo(Member::class);
    }
}
