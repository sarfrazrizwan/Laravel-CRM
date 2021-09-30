<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCompanyRequest;
use App\Http\Resources\Admin\CompanyCollection;
use App\Http\Resources\Admin\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prophecy\Doubler\Generator\TypeHintReference;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin');
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = Company::query();
        if ($search)
            $query->where('title', 'like', "%$search%");

        $query->orderBy('created_at','desc');
        $companies = $query->paginate($perPage);
        return new CompanyCollection($companies);
    }
    public function updateOrCreate(StoreCompanyRequest $request)
    {
        $company = Company::updateOrCreate(
            [
                'uuid' => $request->id,
            ],
            [
                'title' =>  $request->title,
                'description' =>  $request->description
            ]
        );

        $message = __('api.COMPANY_CREATED');
        if ($request->id)
            $message = __('api.COMPANY_UPDATED');

        $data['message'] = $message;
        $data['data'] = new CompanyResource($company);
        return $data;
    }

    public function destroy($uuid)
    {
        $company = Company::findByUUIDOrFail($uuid);
        $company->delete();

        return response()->json(['message' => __('api.COMPANY_DELETED')]);
    }
    public function all()
    {
        $companies = Company::all();
        return new CompanyCollection($companies);
    }
}
