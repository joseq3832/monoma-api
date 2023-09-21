<?php

namespace Src\Infraestructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Aplication\Contracts\ILeadService;

class LeadController extends Controller
{
    protected $leadService;

    public function __construct(ILeadService $leadService)
    {
        $this->middleware('manager')->except('index');
        $this->leadService = $leadService;
    }

    public function index()
    {
        return $this->leadService->index();
    }

    public function store(Request $request)
    {
        return $this->leadService->store($request);
    }

    public function show(int $int)
    {
        return $this->leadService->show($int);
    }
}
