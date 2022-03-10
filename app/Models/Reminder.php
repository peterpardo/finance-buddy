<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $table = 'reminders';
    protected $fillable = [
        'user_id',
        'name',
        'number',
        'sent',
        'amount',
        'date',
    ];

    public function user() {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
