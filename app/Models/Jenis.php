<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'user_id',
    ];

    /**
     * Relasi jenis dengan user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
