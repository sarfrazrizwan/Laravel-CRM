<?php

namespace App\Http\Controllers;

use App\Form;
use App\Http\Requests\StoreFormFieldRequest;
use App\Http\Resources\ExternalFormFieldCollection;
use App\Http\Resources\FormFieldCollection;
use App\Http\Resources\FormFieldResource;
use App\Repositories\FormFieldRepository;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    private $repo;
    public function __construct(FormFieldRepository $repository)
    {
        $this->repo = $repository;
    }
    public function index($formId)
    {
        return new FormFieldCollection($this->repo->index($formId));
    }
    public function show($uuid)
    {
        return new FormFieldResource($this->repo->show($uuid));
    }
    public function store(StoreFormFieldRequest $request, $formId)
    {
        $data = $request->all();
        $formId = Form::findByUUIDOrFail($formId)->id;
        $data['form_id'] = $formId;

        return new FormFieldResource($this->repo->updateOrCreate($data));
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return json_response(__('api.FORM_DELETED'));
    }
    public function sort(Request $request)
    {
        $this->repo->sort($request->all());
        return json_response();
    }
    public function getFields($formId)
    {
        return new ExternalFormFieldCollection($this->repo->getFields($formId));
    }
}
