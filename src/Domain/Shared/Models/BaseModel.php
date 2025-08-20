<?php

namespace Domain\Shared\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    protected $garded = [];

    protected static function newFactory(): Factory
    {
        $parts = str(get_called_class())->explode('\\');
        $domain = $parts[1];
        $model = $parts->last();

        return app("Database\Factories\\{$domain}\\{$model}Factory");

    }
}
