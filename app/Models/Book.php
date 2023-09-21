<?php

namespace App\Models;

use App\Models\Traits\TimeStampFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    use TimeStampFormat;

    protected $fillable = [
        'author_id',
        'title',
        'genre',
        'release_date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
