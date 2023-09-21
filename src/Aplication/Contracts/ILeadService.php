<?php

namespace Src\Aplication\Contracts;

use Illuminate\Http\Request;

interface ILeadService
{
    public function index();

    public function store(Request $request);

    public function show(int $id);
}
