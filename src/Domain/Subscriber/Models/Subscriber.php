<?php

namespace Src\Domain\Subscriber\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Src\Domain\Shared\Models\User;
use Src\Domain\Subscriber\Models\Form;
use Src\Domain\Subscriber\Tag;

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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(related: Tag::class);    
    }


}