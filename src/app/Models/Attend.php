<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    protected $table = 'attends';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // リレーションの定義
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
