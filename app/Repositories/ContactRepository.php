<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    protected Contact $model;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }
}