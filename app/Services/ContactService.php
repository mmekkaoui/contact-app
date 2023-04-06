<?php

namespace App\Services;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactResource;
use App\Interfaces\ContactServiceInterface;
use App\Models\Contact;
use App\Repositories\AddressRepository;
use App\Repositories\ContactRepository;
use App\Repositories\PhoneNumberRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactService implements ContactServiceInterface
{
    protected UserRepository $userRepository;
    protected ContactRepository $contactRepository;
    protected PhoneNumberRepository $phoneNumberRepository;
    protected AddressRepository $addressRepository;

    public function __construct(UserRepository $userRepository,
                                ContactRepository $contactRepository,
                                PhoneNumberRepository $phoneNumberRepository,
                                AddressRepository $addressRepository)
    {
        $this->userRepository = $userRepository;
        $this->contactRepository = $contactRepository;
        $this->phoneNumberRepository = $phoneNumberRepository;
        $this->addressRepository = $addressRepository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ContactResource::collection($this->contactRepository->index());
    }

    /**
     * @param ContactRequest $request
     * @return ContactResource|JsonResponse
     */
    public function store(ContactRequest $request): JsonResponse|ContactResource
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // create user
            $userData = [
                "name" => $data['user']['name'],
                "email" => $data['user']['email'],
            ];

            $user = $this->userRepository->store($userData);

            // create Contact
            $contact = $this->contactRepository->store(['user_id' => $user->id]);

            // Saving phone numbers
            $this->phoneNumberRepository->createMany($user, $data['user']['phone_numbers']);

            // Saving addresses
            $this->addressRepository->createMany($user, $data['user']['addresses']);

            DB::commit();

            return ContactResource::make($contact->fresh());
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 409);
        }
    }

    public function update(Contact $contact, ContactUpdateRequest $request): ContactResource|JsonResponse
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            // update user
            $userData = [
                "name" => $data['user']['name'],
                "email" => $data['user']['email'],
            ];

            // update user
            $this->userRepository->update($contact->user, $userData);

            // update phone numbers
            $this->phoneNumberRepository->updateOrCreate($contact->user, $data['user']['phone_numbers']);

            // Saving addresses
            $this->addressRepository->updateOrCreate($contact->user, $data['user']['addresses']);

            DB::commit();

            return ContactResource::make($contact->fresh());
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 409);
        }
    }

}