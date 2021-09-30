<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemplateRequest;
use App\Http\Resources\TemplateCollection;
use App\Http\Resources\TemplateResource;
use App\Repositories\TemplateRepository;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    private $templateRepo;
    public function __construct(TemplateRepository $repository)
    {
        $this->templateRepo = $repository;
    }

    public function index()
    {
        return new TemplateCollection($this->templateRepo->index());
    }
    public function store(StoreTemplateRequest $request)
    {
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;

        return $this->templateRepo->updateOrCreate($data);
    }
    public function show($uuid): TemplateResource
    {
        return new TemplateResource($this->templateRepo->show($uuid));
    }
    public function destroy($uuid)
    {
        $this->templateRepo->destroy($uuid);
        return response()->json(['message' => __('api.OPERATION_SUCCESS')]);
    }
    public function getAll()
    {
        return new TemplateCollection($this->templateRepo->all());
    }
}
