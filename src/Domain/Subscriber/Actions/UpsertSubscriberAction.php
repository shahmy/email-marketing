<?php

namespace Src\Domain\Subscriber;

use Src\Domain\Shared\Models\User;
use Src\Domain\Subscriber\Models\Subscriber;

class UpsertSubscriberAction
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     *
     * @param  mixed  $data
     * @return mixed
     */
    public function execute(SubscriberDto $subscriberDto, User $user): Subscriber
    {
        $subscriber = Subscriber::updateOrCreate(
            [
                'id' => $subscriberDto->id
            ],
            [
                ...$subscriberDto->all(),
                'user_id' => $user->id,
                'form_id' => $subscriberDto->form?->id,
            ]
        );

        $subscriber->tags()->sync($subscriberDto->tags->toCollection()->pluck('id'));

        return $subscriber->load('tags', 'form');
    }
}