<?php

namespace Src\Domain\Subscriber\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id',
        'user_id',
    ];

    // Define relationships, accessors, mutators, and other model logic here

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }   


}