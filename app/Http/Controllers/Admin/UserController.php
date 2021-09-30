<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Resources\Admin\UserCollection;
use App\Http\Resources\Admin\UserResource;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userRepo;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        return new UserCollection($this->userRepo->index());
    }

    public function updateOrCreate(StoreUserRequest $request)
    {
        $company = Company::findByUUIDOrFail($request->company_id);

        $data = $request->all();
        $data['company_id'] = $company->id;
        $data['user_type'] = $request->user_type;

        return new UserResource($this->userRepo->updateOrCreate($data));
    }
    public function destroy($uuid)
    {
        $this->userRepo->destroy($uuid);
        return response()->json(['message' => __('api.USER_DELETED')]);
    }
    public function show($uuid)
    {
        $user = User::findByUUIDOrFail($uuid);
        return new UserResource($user);
    }
}
