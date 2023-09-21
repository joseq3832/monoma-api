<?php

namespace Src\Aplication\Services;

use Illuminate\Http\Request;
use Src\Aplication\Contracts\ILeadService;
use Src\Infraestructure\Contracts\ILeadRepository;

class LeadService implements ILeadService
{
    protected $leadRepository;

    public function __construct(ILeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function index()
    {
        return $this->leadRepository->index();
    }

    public function store(Request $request)
    {
        return $this->leadRepository->store($request);
    }

    public function show(int $id)
    {
        return $this->leadRepository->show($id);
    }
}
