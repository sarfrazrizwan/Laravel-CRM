<?php

namespace App\Http\Controllers;


use App\CompanyGroup;
use App\Http\Requests\StoreCompanyGroupRequest;
use App\Http\Resources\CompanyGroupCollection;
use App\Http\Resources\CompanyGroupResource;
use App\Repositories\CompanyGroupRepository;
use Illuminate\Http\Request;

class CompanyGroupController extends Controller
{
    private $companyGroupRepo;
    public function __construct(CompanyGroupRepository $repository)
    {
        $this->companyGroupRepo = $repository;
    }

    public function index()
    {
        return new CompanyGroupCollection($this->companyGroupRepo->index());
    }
    public function all()
    {
        return new CompanyGroupCollection($this->companyGroupRepo->all());
    }
    public function updateOrCreate(StoreCompanyGroupRequest $request)
    {
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        return new CompanyGroupResource($this->companyGroupRepo->updateOrCreate($data));
    }
    public function show($uuid)
    {
        return new CompanyGroupResource($this->companyGroupRepo->show($uuid));
    }
    public function destroy($uuid)
    {
        $this->companyGroupRepo->destroy($uuid);
        return response()->json(['message' => __('api.GROUP_DELETED')]);
    }
}
