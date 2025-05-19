<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            @csrf

            <!-- Model -->
            <div class="mb-3">
                <label class="form-label" for="form.model">Model Name</label>
                <select
                    wire:model="form.model"
                    wire:change="modelChoose()"
                    class="form-select"
                >
                    <option value="">Select model</option>
                    @foreach($models as $model)
                        <option value="{{ $model->namespace }}">
                            {{ $model->name }} ({{ $model->namespace }})
                        </option>
                    @endforeach
                </select>

                @error('form.model')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Controller Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Controller Name</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light">{{ $form->controllerPrefix }}</span>
                    <input type="text" wire:model="form.controllerName" class="form-control" autocomplete="off">
                    <span class="input-group-text bg-light">{{ $form->controllerSuffix }}</span>
                </div>

                @error('form.controllerName')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Controller type -->
            <div class="mb-3">
                <label class="form-label" for="crud_type">Resource Type</label>
                <select wire:model="form.crudType" class="form-select">
                    <option value="">Select type</option>

                    <option value="1">Api resource controller</option>
                    <option value="2">Resource controller</option>
                </select>

                @error('form.crudType')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <!-- List Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">List Request Nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <input class="form-check-input" type="checkbox" wire:model="form.isListRequest"
                                       checked/>
                            </span>
                            <span class="input-group-text bg-light">{{ $form->listRequestPrefix }}</span>
                            <input type="text" wire:model="form.listRequestName" class="form-control"
                                   autocomplete="off">
                            <span class="input-group-text bg-light">{{ $form->listRequestSuffix }}</span>
                        </div>

                        @error('form.listRequestName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Create Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Create Request Nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <input class="form-check-input" type="checkbox" wire:model="form.isCreateRequest"
                                       checked/>
                            </span>
                            <span class="input-group-text bg-light">{{ $form->createRequestPrefix }}</span>
                            <input type="text" wire:model="form.createRequestName" class="form-control"
                                   autocomplete="off">
                            <span class="input-group-text bg-light">{{ $form->createRequestSuffix }}</span>
                        </div>

                        @error('form.createRequestName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Update Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Update Request Nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <input class="form-check-input" type="checkbox" wire:model="form.isUpdateRequest"
                                       checked/>
                            </span>
                            <span class="input-group-text bg-light">{{ $form->updateRequestPrefix }}</span>
                            <input type="text" wire:model="form.updateRequestName" class="form-control"
                                   autocomplete="off">
                            <span class="input-group-text bg-light">{{ $form->updateRequestSuffix }}</span>
                        </div>

                        @error('form.updateRequestName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Service Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Service Name</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light">{{ $form->servicePrefix }}</span>
                    <input type="text" wire:model="form.serviceName" class="form-control" autocomplete="off">
                    <span class="input-group-text bg-light">{{ $form->serviceSuffix }}</span>
                </div>

                @error('form.serviceName')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Resource -->
            @if($form->crudType === 1)
                <div class="mb-3">
                    <label class="form-label" for="name">Resource Name</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light">{{ $form->resourcePrefix }}</span>
                        <input type="text" wire:model="form.resourceName" class="form-control" autocomplete="off">
                        <span class="input-group-text bg-light">{{ $form->resourceSuffix }}</span>
                    </div>

                    @error('form.resourceName')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <!-- Base Controller Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Base Controller Name</label>
                <div class="input-group mb-3">
                    <input type="text" wire:model="form.baseController" class="form-control" autocomplete="off">
                </div>

                @error('form.baseController')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="button" wire:click="preview()" class="btn btn-primary">Preview</button>

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</div>
