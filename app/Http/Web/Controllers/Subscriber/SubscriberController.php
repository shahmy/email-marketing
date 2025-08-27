<?php

namespace App\Http\Web\Controllers\Subscriber;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Domain\Subscriber\SubscriberDto;
use Src\Domain\Subscriber\UpsertSubscriberAction;



use Inertia\Response;
use Src\Domain\Subscriber\UpsertSubscriberViewModel;

class SubscriberController
{
    protected $upsertSubscriberAction;

    public function __construct(UpsertSubscriberAction $upsertSubscriberAction)
    {
        $this->upsertSubscriberAction = $upsertSubscriberAction;
    }

    public function index()
    {
        //
    }

    public function create(): Response
    {
        return Inertia::render('Subscriber/form', [
            'viewModel' => new UpsertSubscriberViewModel()
        ]);
    }

    public function edit(SubscriberDto $subscriberDto): Response
    {
        return Inertia::render('Subscriber/form', [
            'viewModel' => new UpsertSubscriberViewModel($subscriberDto)
        ]);
    }


    public function store(SubscriberDto $subscriberDto, Request $request): JsonResponse
    {
        $this->upsertSubscriberAction->execute($subscriberDto, $request->user());
        return response()->json(['message' => 'Subscriber created successfully', 'data' => $subscriberDto]);
    }

    public function update(SubscriberDto $subscriberDto, Request $request): JsonResponse
    {
        $this->upsertSubscriberAction->execute($subscriberDto, $request->user());
        return response()->json(['message' => 'Subscriber updated successfully', 'data' => $subscriberDto]);
    }

    public function show(SubscriberDto $subscriberDto): JsonResponse
    {
        return response()->json(['data' => $subscriberDto]);
    }

    public function destroy(SubscriberDto $subscriberDto): JsonResponse
    {
        $this->upsertSubscriberAction->execute($subscriberDto, null);
        return response()->json(['message' => 'Subscriber deleted successfully', 'data' => $subscriberDto]);
    }
}