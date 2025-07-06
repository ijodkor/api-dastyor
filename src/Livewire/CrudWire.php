<?php

namespace Ijodkor\Dastyor\Livewire;


use Exception;
use Ijodkor\Dastyor\Livewire\Form\CrudForm;
use Ijodkor\Dastyor\Services\CrudBuilderService;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CrudWire extends BuilderWire {

    public CrudForm $form;

    // Props
    public array $meta = [
        'description' => "YO‘YO‘ (CRUD) yaratuvchi",
        'route' => "advanced.crud.store"
    ];

    protected string $view = "livewire.crud";

    public Collection $resourceTypes;

    public function __construct() {
        $this->resourceTypes = collect([
            [
                'value' => 1,
                'name' => "Apiga moslashgan"
            ],
            [
                'value' => 2,
                'name' => "An’anaviy kontroller"
            ]
        ]);
    }

    public function modelChoose(): void {
        $model = $this->models
            ->filter(function($model) {
                return $model->namespace == $this->form->model;
            })
            ->first();

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
     * @param CrudBuilderService $service
     */
    public function save(CrudBuilderService $service): void {
        try {
            $this->form->validate();
        } catch (Exception $ex) {
            session()->flash('err', $ex->getMessage());
            return;
        }

        $service->create($this->form->all());

        session()->flash('success', "YO‘YO‘ muvaffaqiyatli yaratildi!");
    }
}
