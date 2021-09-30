<?php

namespace App\Http\Controllers;

use App\CompanyGroup;
use App\Enums\UserType;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        return new UserCollection($this->userRepository->index());
    }
    public function show($uuid)
    {
        return new UserResource($this->userRepository->show($uuid));
    }
    public function updateOrCreate(StoreUserRequest $request)
    {
        $authUser = auth()->user();
        $data = $request->all();
        $data['company_id'] = $authUser->company_id;
        $data['user_type'] = $request->user_type;
//        $groupIds = CompanyGroup::whereIn('uuid', $request->company_group_ids)->get()->pluck('id')->toArray();
//        $data['company_group_ids'] = $groupIds;

        return new UserResource($this->userRepository->updateOrCreate($data));
    }
    public function destroy($uuid)
    {
        $this->userRepository->destroy($uuid);
        return response()->json(['message' => __('api.USER_DELETED')]);
    }
    public function search($query)
    {
        $users = User::where(function ($q)use($query){
            $q->where('first_name', 'like', "%$query%");
            $q->orWhere('last_name', 'like', "%$query%");
            $q->orWhere('email', 'like', "%$query%");
        })
            ->where('company_id', auth()->user()->company_id)
            ->paginate(10);

        return new UserCollection($users);
    }
    public function udpateDashboardSettings(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'meta->dashboard_modules' => $request->all()
        ]);

        return (new UserResource($user))->additional(['message' => __('api.SETTING_UPDATED')]);
    }
    public function all()
    {
        return new UserCollection($this->userRepository->index());
    }
}
