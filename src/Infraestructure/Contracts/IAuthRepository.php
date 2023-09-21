<?php

namespace Src\Infraestructure\Contracts;

use Illuminate\Http\Request;

interface IAuthRepository
{
    public function login(Request $request);
}
