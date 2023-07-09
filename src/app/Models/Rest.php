<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    protected $table = 'rests';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // リレーションの定義
    public function attend()
    {
        return $this->belongsTo(Attend::class, 'attend_id');
    }
}
