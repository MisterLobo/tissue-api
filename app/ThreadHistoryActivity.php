<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class ThreadHistoryActivity extends Model
{
    protected $table = 'thread_history';
    protected $fillable = ['thread_id', 'instigator', 'action', 'meta'];
}
