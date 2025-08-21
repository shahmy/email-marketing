<?php

namespace Src\Domain\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BaseModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): Factory
    {
        $parts = str(get_called_class())->explode('\\');
        $domain = $parts[1];
        $model = $parts->last();

        return app("Database\Factories\\{$domain}\\{$model}Factory");

    }
}
