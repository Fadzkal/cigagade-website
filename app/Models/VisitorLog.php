<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'visitor_logs';

    protected $fillable = [
        'ip_address',
        'ip_hash',
        'user_agent',
        'session_id',
        'page_url',
        'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];
}
