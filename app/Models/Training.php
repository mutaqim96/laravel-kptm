<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','trainer','attachment'];

    // one training belongs to a user - FK
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getAttachmentAttribute(){
        //get function getkene pascal case.
        return asset('storage/'.$this->attachment);
    }
