<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
      'content',
      'user_id'
    ]; //eloquent model $fillable property  to have attribute that is written

    public function getByUserId($id)
    {
        //dd($this->where('user_id', $id)); //todo:model where:method return: Builder:class
        //dd($this->where('user_id', $id)->get());
        return $this->where('user_id', $id)->get(); //todo:model get:method return collection
    }
}
