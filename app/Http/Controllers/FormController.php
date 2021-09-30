<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Resources\FormCollection;
use App\Http\Resources\FormResource;
use App\Repositories\FormRepository;
use Illuminate\Http\Request;

class FormController extends Controller
{
    private $repo;
    public function __construct(FormRepository $repository)
    {
        $this->repo = $repository;
    }
    public function index()
    {
        return new FormCollection($this->repo->index());
    }
    public function show($uuid)
    {
        return new FormResource($this->repo->show($uuid));
    }
    public function store(StoreFormRequest $request)
    {
        $authUser = auth()->user();
        $data = $request->all();
        $data['company_id'] = $authUser->company_id;

        return new FormResource($this->repo->updateOrCreate($data));
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return json_response(__('api.FORM_DELETED'));
    }
}
