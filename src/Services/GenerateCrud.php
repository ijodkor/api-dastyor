<?php

namespace Uzinfocom\Dastyor\Services;

use Illuminate\Support\Str;

class GenerateCrud extends AllGenerator {

    public function __construct() {
        $this->stab = 'advanced-api-controller.stub';
        $this->list_stab = 'list-request.stub';
        $this->group = ".php";
    }

    public function generate(array $form): void {
        $this->stab = ((intval($form['crudType']) === 1) ? 'advanced-api-controller.stub' : 'advanced-controller.stub');

        $stub = $this->getStub();
        $listStub = $this->getListStub();
        $modelName = Str::afterLast($form['model'], '\\');
        $modelInfo = ['name' => $modelName, 'namespace' => $form['model']];
        $namespace = Str::beforeLast(($form['controllerPrefix'] . $form['controllerName']), '\\');
        $controllerName = Str::afterLast($form['controllerName'], '\\') . $form['controllerSuffix'];

        if ($form['isListRequest']) {
            $this->requestListGenerate($form, $modelInfo, $listStub);
        }
        $this->requestCreateGenerate($form, $modelInfo, $stub);
        $this->requestUpdateGenerate($form, $modelInfo, $stub);
        $this->serviceGenerate($form, $modelInfo, $stub);
        $this->resourceGenerate($form, $modelInfo, $stub);

        $modelNameSingular = Str::lcfirst($modelName);
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
                '{{ modelNameSpace }}'
        ], [
                $namespace,
                $controllerName,
                $form['baseController'],
                $modelName,
                $modelNamePlural,
                $modelNameSingular,
                $modelKebabName,
                $form['model']
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$controllerName
        $this->make($location, $controllerName, $stub);
    }

    private function serviceGenerate(array $form, array $modelInfo, &$stub): void {
        $serviceName = Str::afterLast($form['serviceName'], '\\') . $form['serviceSuffix'];
        $useService = Str::beforeLast($form['serviceName'], '\\') . '\\' . $serviceName;

        $stub = str_replace([
                '{{ serviceName }}',
                '{{ useService }}'
        ], [
                $serviceName,
                $useService
        ], $stub);

        $generator = new ServiceBuilder();
        $generator->generate(
                $modelInfo,
                Str::afterLast($form['serviceName'], '\\'),
                $form['servicePrefix'] . Str::beforeLast($form['serviceName'], '\\')
        );
    }

    private function resourceGenerate(array $form, array $modelInfo, &$stub): void {
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

            $generator = new GenerateResource();
            $generator->generate(
                    $modelInfo,
                    Str::afterLast($form['resourceName'], '\\'),
                    $form['resourcePrefix'] . Str::beforeLast($form['resourceName'], '\\')
            );
        }
    }

    private function requestListGenerate(array $form, array $modelInfo, &$stub): void {
        if ($form['isListRequest']) {
            $listRequest = (Str::afterLast($form['listRequestName'], '\\') . $form['listRequestSuffix']);
            $useListRequest = 'use ' . $form['listRequestPrefix'] . Str::beforeLast($form['listRequestName'], '\\') . '\\' . $listRequest . ';';

            $generator = new GenerateRequest();
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

    private function requestCreateGenerate(array $form, array $modelInfo, &$stub): void {
        if ($form['isCreateRequest']) {
            $createRequest = (Str::afterLast($form['createRequestName'], '\\') . $form['createRequestSuffix']);
            $useCreateRequest = 'use ' . $form['createRequestPrefix'] . Str::beforeLast($form['createRequestName'], '\\') . '\\' . $createRequest . ';';

            $generator = new GenerateRequest();
            $generator->generateCreate(
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

    private function requestUpdateGenerate(array $form, array $modelInfo, &$stub): void {
        if ($form['isUpdateRequest']) {
            $updateRequest = Str::afterLast($form['updateRequestName'], '\\') . $form['updateRequestSuffix'];
            $useUpdateRequest = 'use ' . $form['updateRequestPrefix'] . Str::beforeLast($form['updateRequestName'], '\\') . '\\' . $updateRequest . ';';

            $generator = new GenerateRequest();
            $generator->generateUpdate(
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
