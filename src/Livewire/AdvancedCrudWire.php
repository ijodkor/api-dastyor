<?php

namespace Ijodkor\Dastyor\Livewire;


use Ijodkor\Dastyor\Livewire\Form\AdvancedCrudForm;
use Ijodkor\Dastyor\Services\GenerateCrud;

class AdvancedCrudWire extends GeneratorWire {

    public AdvancedCrudForm $form;

    // Props
    public array $meta = [
        'description' => "Crud yaratuvchi",
        'route' => "advanced.crud.store"
    ];

    protected string $view = "livewire.advanced-crud";


    public function modelChoose(): void {
        $model = $this->models->filter(function($model) {
            return $model->namespace == $this->form->model;
        })->first();

        $path = $model ? ($model->folder ? $model->folder . $model->name : $model->name) : '';

        $this->form->controllerName = $path;
        $this->form->createRequestName = $path;
        $this->form->updateRequestName = $path;
        $this->form->serviceName = $path;
        $this->form->resourceName = $path;
    }

    public function preview(): void {
        $this->form->validate();
    }

    public function save(GenerateCrud $service) {
        $this->form->store($service);
    }
}
