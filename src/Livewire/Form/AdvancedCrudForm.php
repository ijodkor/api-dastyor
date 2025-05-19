<?php

namespace Uzinfocom\Dastyor\Livewire\Form;

use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Uzinfocom\Dastyor\Helpers\StorageManager;
use Uzinfocom\Dastyor\Services\GenerateCrud;

class AdvancedCrudForm extends Form {
    use StorageManager;

    #[Validate('required|string')]
    public $model = '';

    #[Validate('required|string')]
    public $baseController = 'App\Http\Controllers\Controller';

    //-------------- Controller -------------
    #[Validate('required|string')]
    public $controllerPrefix = 'App\Http\Controllers\\';

    #[Validate('required|string')]
    public $controllerName = '';

    #[Validate('required|string')]
    public $controllerSuffix = 'Controller';

    //-------------- Create Request -------------
    #[Validate('required|boolean')]
    public $isCreateRequest = true;

    #[Validate('boolean')]
    public $isListRequest = true;


    #[Validate('required|string')]
    public $createRequestPrefix = 'App\Http\Requests\\';

    #[Validate('string')]
    public $listRequestPrefix = 'App\Http\Requests\\';

    #[Validate('required|string')]
    public $listRequestName = '';

    #[Validate('string')]
    public $listRequestSuffix = 'ListRequest';

    #[Validate('required|string')]
    public $createRequestName = '';

    #[Validate('required|string')]
    public $createRequestSuffix = 'CreateRequest';

    //-------------- Update Request -------------
    #[Validate('required|boolean')]
    public $isUpdateRequest = true;

    #[Validate('required|string')]
    public $updateRequestPrefix = 'App\Http\Requests\\';

    #[Validate('required|string')]
    public $updateRequestName = '';

    #[Validate('required|string')]
    public $updateRequestSuffix = 'UpdateRequest';

    //-------------- Service -------------
    #[Validate('required|string')]
    public $servicePrefix = 'App\Services\\';

    #[Validate('required|string')]
    public $serviceName = '';

    #[Validate('required|string')]
    public $serviceSuffix = 'Service';

    //-------------- Service -------------
    #[Validate('required|string')]
    public $resourcePrefix = 'App\Http\Resources\\';

    #[Validate('required|string')]
    public $resourceName = '';

    #[Validate('required|string')]
    public $resourceSuffix = 'Resource';

    // other
    #[Validate('required|numeric')]
    public $crudType = 1;


    /**
     * @throws ValidationException
     */
    public function store(GenerateCrud $service): void {
        $this->validate();
        $service->create($this->all());
    }
}