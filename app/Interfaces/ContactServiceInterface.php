<?php

namespace App\Interfaces;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

interface ContactServiceInterface
{
    public function index();
    public function store(ContactRequest $request): JsonResponse|ContactResource;
    public function update(Contact $contact, ContactRequest $request): JsonResponse|ContactResource;
}