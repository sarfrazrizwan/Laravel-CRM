<?php

namespace App\Http\Controllers;

use App\CompanyGroup;
use App\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerRepo;
    public function __construct(CustomerRepository $repository)
    {
        $this->customerRepo = $repository;
    }

    public function index()
    {
        return new CustomerCollection($this->customerRepo->index());
    }

    public function updateOrCreate(StoreCustomerRequest $request)
    {
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;

        $groupIds = CompanyGroup::whereIn('uuid', $request->company_group_ids)->get()->pluck('id')->toArray();
        $data['company_group_ids'] = $groupIds;

        return new CustomerResource($this->customerRepo->updateOrCreate($data));
    }
    public function destroy($uuid)
    {
        $this->customerRepo->destroy($uuid);
        return response()->json(['message' => __('api.CUSTOMER_DELETED')]);
    }
    public function show($uuid)
    {
        $customer = $this->customerRepo->show($uuid);
        return new CustomerResource($customer);
    }
}
