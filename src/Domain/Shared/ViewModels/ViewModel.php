<?php

namespace Src\Domain\Shared\ViewModels;

// You might pass models or DTOs to the ViewModel
// use App\Domain\User\Models\User;
// use App\Domain\User\DataTransferObjects\UserData;

class ViewModel
{
    /**
     * Create a new ViewModel instance.
     *
     * @param  mixed  $data (e.g., an Eloquent model, a DTO, or an array)
     * @return void
     */
    public function __construct(
        // public readonly User $user,
        // public readonly UserData $userData,
    ) {
        //
    }

    /**
     * Get the data prepared for the view.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            // 'username' => $this->user->name,
            // 'formatted_address' => $this->userData->address,
            // 'is_admin' => $this->user->isAdmin(),
        ];
    }
}