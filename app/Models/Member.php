<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['picture'];

    public function registerMediaCollections(): void
    {
        $this
        ->addMediaCollection('picture')
        ->singleFile();
    }

    public function getPictureAttribute(){
      return $this->hasMedia('picture')
             ? $this->getFirstMediaUrl('picture')
             : null;
    }
}
