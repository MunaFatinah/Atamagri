<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimonials';

    protected $fillable = ['nama', 'peran', 'pesan', 'bintang'];

    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->nama))
            ->take(2)
            ->map(fn ($n) => strtoupper(substr($n, 0, 1)))
            ->implode('');
    }
}
