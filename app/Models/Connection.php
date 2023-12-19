<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'connection_user_id',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'connection_user_id');
    }
    public function connection()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function commonConnections()
    {
        return $this->hasMany(Connection::class, 'connection_user_id', 'connection_user_id')->where('status', 'accepted')->with('connection');
    }
    public function commonConnectionsOtherSide()
    {
        return $this->hasMany(Connection::class, 'connection_user_id', 'user_id')->where('status', 'accepted')->with('connection');
    }
}
