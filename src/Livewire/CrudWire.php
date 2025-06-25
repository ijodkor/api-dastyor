<?php

namespace Ijodkor\Dastyor\Livewire;


use Ijodkor\Dastyor\Livewire\Form\CrudForm;
use Ijodkor\Dastyor\Services\CrudBuilderService;
use Illuminate\Validation\ValidationException;

class CrudWire extends BuilderWire {

    public CrudForm $form;

    // Props
    public array $meta = [
        'description' => "CRUD yaratuvchi",
        'route' => "advanced.crud.store"
    ];

    protected string $view = "livewire.crud";


    public function modelChoose(): void {
        $model = $this->models->filter(function($model) {
            return $model->namespace == $this->form->model;
        })->first();

        $path = $model ? ($model->folder ? $model->folder . $model->name : $model->name) : '';

        $this->form->controllerName = $path;
        $this->form->listRequestName = $path;
        $this->form->createRequestName = $path;
        $this->form->updateRequestName = $path;
        $this->form->service = [
            'name' => $path,
        ];

        $this->form->resourceName = $path;
    }

    /**
     * @throws ValidationException
     */
    public function preview(): void {
        $this->form->validate();
    }

    /**
     * @throws ValidationException
     */
    public function save(CrudBuilderService $service): void {
        try {
            $this->form->validate();
        } catch (\Exception $exception) {
            dd($exception);
        }

        $service->create($this->form->all());
    }
}
