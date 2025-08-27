<?php

namespace Src\Domain\Subscriber;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Domain\Subscriber\Models\Subscriber;

class Form extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
    ];


    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class);
    }   


}