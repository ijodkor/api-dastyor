<?php

namespace Ijodkor\Dastyor\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CrudBuilderService extends AllGenerator {

    public function __construct(
        private readonly RequestBuilderService $request,
        private readonly ServiceBuilder        $serviceBuilder
    ) {
        $this->stab = 'advanced-api-controller.stub';
        $this->list_stab = 'list-request.stub';
        $this->group = ".php";
    }

    public function create(array $form): void {
        $this->stab = Arr::get($form, 'crudType') == 1 ? 'advanced-api-controller.stub' : 'advanced-controller.stub';
        $stub = $this->getStub();

        // Model
        $model = [
            'name' => Str::afterLast($form['model'], '\\'),
            'namespace' => $form['model']
        ];

        // Controller
        $namespace = Str::beforeLast(($form['controllerPrefix'] . $form['controllerName']), '\\');
        $name = Str::afterLast($form['controllerName'], '\\') . $form['controllerSuffix'];

        // Service
        $srvName = Arr::get($form, 'service.name');
        $service = [
            'name' => Str::afterLast($srvName, '\\') . Arr::get($form, 'service.suffix'),
            'namespace' => Str::beforeLast($srvName, '\\') . '\\' . $srvName
            // $form['servicePrefix'] . Str::beforeLast($form['serviceName'], '\\')
        ];

        $listStub = $this->request->getListStub();
        if ($form['isListRequest']) {
            $this->request($form, $model, $listStub);
        }
        $this->requestCreate($form, $model, $stub);
        $this->requestUpdate($form, $model, $stub);

        $this->serviceBuilder->generate($model, $service['name'], $service['namespace']);

        $this->resource($form, $model, $stub);

        $modelNameSingular = Str::lcfirst($model['name']);
        $modelNamePlural = Str::plural($modelNameSingular);
        $modelKebabName = Str::kebab($modelNamePlural);

        $stub = str_replace([
            '{{ namespace }}',
            '{{ controllerName }}',
            '{{ baseController }}',
            '{{ modelName }}',
            '{{ modelNamePlural }}',
            '{{ modelNameSingular }}',
            '{{ modelKebabName }}',
            '{{ modelNameSpace }}',
            '{{ serviceName }}',
            '{{ useService }}'
        ], [
            $namespace,
            $name,
            $form['baseController'],
            $model['name'],
            $modelNamePlural,
            $modelNameSingular,
            $modelKebabName,
            $form['model'],
            $service['name'],
            $service['namespace'],
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$controllerName
        $this->make($location, $name, $stub);
    }

    private function resource(array $form, array $modelInfo, &$stub): void {
        if (intval($form['crudType']) === 1) {
            $resourceName = Str::afterLast($form['resourceName'], '\\') . $form['resourceSuffix'];
            $useResource = Str::beforeLast($form['resourceName'], '\\') . '\\' . $resourceName;

            $stub = str_replace([
                '{{ resourceName }}',
                '{{ useResource }}'
            ], [
                $resourceName,
                $useResource
            ], $stub);

            $generator = new ResourceBuilderService();
            $generator->generate(
                $modelInfo,
                Str::afterLast($form['resourceName'], '\\'),
                $form['resourcePrefix'] . Str::beforeLast($form['resourceName'], '\\')
            );
        }
    }

    private function request(array $form, array $modelInfo, &$stub): void {
        if ($form['isListRequest']) {
            $listRequest = (Str::afterLast($form['listRequestName'], '\\') . $form['listRequestSuffix']);
            $useListRequest = 'use ' . $form['listRequestPrefix'] . Str::beforeLast($form['listRequestName'], '\\') . '\\' . $listRequest . ';';

            $generator = new RequestBuilderService();
            $generator->generateList(
                $modelInfo,
                Str::afterLast($form['listRequestName'], '\\'),
                $form['listRequestPrefix'] . Str::beforeLast($form['listRequestName'], '\\')
            );
        } else {
            $listRequest = 'Request';
            $useListRequest = '';
        }

        $stub = str_replace([
            '{{ createRequest }}',
            '{{ useCreateRequest }}'
        ], [
            $listRequest,
            $useListRequest
        ], $stub);
    }

    private function requestCreate(array $form, array $modelInfo, &$stub): void {
        if ($form['isCreateRequest']) {
            $createRequest = (Str::afterLast($form['createRequestName'], '\\') . $form['createRequestSuffix']);
            $useCreateRequest = 'use ' . $form['createRequestPrefix'] . Str::beforeLast($form['createRequestName'], '\\') . '\\' . $createRequest . ';';

            $generator = new RequestBuilderService();
            $generator->creating(
                $modelInfo,
                Str::afterLast($form['createRequestName'], '\\'),
                $form['createRequestPrefix'] . Str::beforeLast($form['createRequestName'], '\\')
            );
        } else {
            $createRequest = 'Request';
            $useCreateRequest = '';
        }

        $stub = str_replace([
            '{{ createRequest }}',
            '{{ useCreateRequest }}'
        ], [
            $createRequest,
            $useCreateRequest
        ], $stub);
    }

    private function requestUpdate(array $form, array $modelInfo, &$stub): void {
        if ($form['isUpdateRequest']) {
            $updateRequest = Str::afterLast($form['updateRequestName'], '\\') . $form['updateRequestSuffix'];
            $useUpdateRequest = 'use ' . $form['updateRequestPrefix'] . Str::beforeLast($form['updateRequestName'], '\\') . '\\' . $updateRequest . ';';

            $generator = new RequestBuilderService();
            $generator->updating(
                $modelInfo,
                Str::afterLast($form['updateRequestName'], '\\'),
                $form['updateRequestPrefix'] . Str::beforeLast($form['updateRequestName'], '\\')
            );
        } else {
            $updateRequest = 'Request';
            $useUpdateRequest = '';
        }

        $stub = str_replace([
            '{{ updateRequest }}',
            '{{ useUpdateRequest }}'
        ], [
            $updateRequest,
            $useUpdateRequest,
        ], $stub);
    }
}
