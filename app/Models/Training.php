<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title','description','trainer','attachment'];

    // one training belongs to a user - FK
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getAttachmentUrlAttribute(){
        //boleh buat default image. lso dia tak return broken image ke apa

        // if($this->attachment){
        // //get function getkene pascal case.
        // return asset('storage/'.$this->attachment);}
        // else{
        //     return ' location kau punya gambar. guna function asset'
        // }
        return asset('storage/'.$this->attachment);

    }
    }
