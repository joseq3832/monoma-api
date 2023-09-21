<?php

namespace Src\Infraestructure\Contracts;

use Illuminate\Http\Request;

interface ILeadRepository
{
    public function index();

    public function store(Request $request);

    public function show(int $id);
}
