<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService)
    {

    }

    public function index()
    {
        return $this->contactService->index();
    }

    public function show(Contact $contact){
        return ContactResource::make($contact);
    }

    public function store(ContactRequest $request): ContactResource|JsonResponse
    {
        return $this->contactService->store($request);
    }

    public function update(Contact $contact, ContactUpdateRequest $request)
    {
        return $this->contactService->update($contact, $request);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->noContent();
    }
}
