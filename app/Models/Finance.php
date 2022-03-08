<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $table = 'finance';
    protected $fillable = [
        'user_id',
        'type',
        'category',
        'amount',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
