<?php

namespace Src\Domain\Subscriber;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Data; 
use Spatie\LaravelData\DataCollection;
use Src\Domain\Shared\Models\User;

class SubscriberDto extends Data // extends Data (if using Spatie package)
{
    // Define public properties for your DTO, e.g.:
    // public string $name;
    // public int $age;
    // public array $items;

    /**
     * Create a new DTO instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(
        public readonly ?int $id,
        public readonly string $email,
        public readonly string $first_name,
        public readonly ?string $last_name,
        public readonly ?DataCollection $tags,
        public readonly ?FormData $form,
        public readonly ?User $user,
    ) {}

    
    public static function fromArray(array $data): static
    {
        return new static(
            // Map array keys to constructor properties
            // name: $data['name'],
            // age: $data['age']
        );
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            // 'name' => $this->name,
            // 'age' => $this->age,
        ];
    }

    public static function rules(ValidationContext $context = null): array
    {
        return [
            'email' => ['required', 'email', 'max:255',
            Rule::unique('subscribers','email')->ignore(request('subscriber')),
        ],
        'first_name'=> ['required', 'string', 'max:255'],
        'last_name'=> ['nullable', 'string', 'max:255'],
        'tag_ids'=> ['nullable', 'array'],
        'form_id'=> ['nullable', 'integer', 'exists:forms,id'],
        'user_id'=> ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}