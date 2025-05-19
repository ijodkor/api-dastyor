<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Support\Arr;

class GeneratorService {
    public function __construct(
        private readonly ServiceBuilder           $service,
        private readonly ModelBuilderService      $model,
        private readonly ResourceBuilderService   $resource,
        private readonly RequestBuilderService    $request,
        private readonly RouteBuilderService      $route,
        private readonly ControllerBuilderService $controller,
        private readonly GenerateCrud             $crud
    ) {
    }

    public function generate(array $data): void {
        $tableName = Arr::get($data, 'table_name');

        /** Model class **/
        $modelName = Arr::get($data, 'model_name');
        $modelNamespace = Arr::get($data, 'model_namespace');
        $this->model->generate($tableName, $modelName, $modelNamespace);

        /** Service class **/
        $serviceName = Arr::get($data, 'service_name');
        $serviceNamespace = Arr::get($data, 'service_namespace');
        $this->service->generate($serviceName, $serviceNamespace, "");

        /** Resource class **/
        $resourceName = Arr::get($data, 'resource_name');
        $resourceNamespace = Arr::get($data, 'resource_namespace');
        $this->resource->generate($tableName, $resourceName, $resourceNamespace);

        /** Request class **/
        $requestName = Arr::get($data, 'request_name');
        $requestNamespace = Arr::get($data, 'request_namespace');

        /** Request create **/
        $this->request->generateCreate($tableName, $requestName, $requestNamespace);
        /** Request update **/
        $this->request->generateUpdate($tableName, $requestName, $requestNamespace);

        /** Request list **/
        $this->request->generateList($tableName, $requestName, $requestNamespace);

        /** Controller class **/
        $controllerName = Arr::get($data, 'controller_name');
        $controllerNamespace = Arr::get($data, 'controller_namespace');
        $this->controller->generate($controllerName, $requestNamespace, $controllerNamespace);

        /** Route **/
        $this->route->generate($tableName, $modelName);
    }

    public function crud(array $attributes): void {
        /** Crud **/
        $this->crud->create($attributes);
    }
}
