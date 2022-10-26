<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name',
        'comment',
        'status',
    ];

    protected $hidden = [
        'email',
        'ip_adress',
    ];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
