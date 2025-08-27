<?php

namespace Src\Domain\Subscriber;

use Spatie\LaravelData\Data; // Consider using Spatie's Laravel Data package for DTOs

class TagDto extends Data {
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
        public readonly string $title,
    ) {
        // You can cast or transform data here if needed
    }

    /**
     * Create a DTO from an array of data.
     *
     * @param  array  $data
     * @return static
     */
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
}