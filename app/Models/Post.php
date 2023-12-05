<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'text'];
}
