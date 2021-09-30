<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 9/21/2020
 * Time: 6:04 PM
 */

namespace App\Repositories;

use App\Form;
use App\FormField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class FormFieldRepository extends BaseRepository
{
    public function __construct(FormField $form)
    {
        $this->model = $form;
    }
    public function index($formId)
    {
        $formId = Form::findByUUIDOrFail($formId)->id;
        $search = \request('query');
        $perPage = \request('perPage') ?? null;
        $query = $this->model->query();
        $query->with('form');
        $query->where('form_id', $formId);


        if ($search)
        {
            $query->where('name', 'like', "%$search%");
        }

        $query->orderBy('sort_order','asc');
        return $query->paginate($perPage);
    }
    public function updateOrCreate(array $attributes)
    {
        return $this->model->updateOrCreate(
            [
                'uuid' => $attributes['id'] ?? null,
                'form_id' => $attributes['form_id']
            ],
            [
                'name' => $attributes['name'],
                'placeholder' => $attributes['placeholder'],
                'type' => $attributes['type'],
                'options' => $attributes['options'],
                'class' => $attributes['class'],
                'validation' => $attributes['validation'],
                'error_message' => $attributes['error_message'],
                'tooltip' => $attributes['tooltip'],
                'status' => $attributes['status'],
                'value' => $attributes['value'],
                'sort_order' => $attributes['sort_order'] ?? $this->model::sortOrderNumber($attributes['form_id']),

            ]
        );
    }
    public function sort(array $attributes)
    {
        foreach ($attributes as $key => $resource)
        {
            logger($this->model->getTable());
            DB::table($this->model->getTable())->where('uuid', $resource['id'])->update(['sort_order' => ++$key]);
        }
    }
    public function getFields($formId)
    {
        $formId = Form::findByUUIDOrFail($formId)->id;

        $query = $this->model->query();
        $query->with('form');
        $query->where('form_id', $formId);

        $query->orderBy('sort_order','asc');
        return $query->get();
    }
}