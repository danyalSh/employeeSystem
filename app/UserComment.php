<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'comment_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_comments';
}
