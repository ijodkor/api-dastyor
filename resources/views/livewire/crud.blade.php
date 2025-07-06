<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible mt-2" role="alert">
            <h5 class="alert-heading mb-2">{{ session('success') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-body">
        <form wire:submit="save">
            @csrf

            <!-- Model -->
            <div class="mb-3">
                <label class="form-label" for="form.model">Model nomi</label>
                <select
                        wire:model="form.model"
                        wire:change="modelChoose()"
                        class="form-select"
                >
                    <option value="">Modelni tanlang</option>
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
                <label class="form-label" for="name">Kontroller nomi</label>
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
                <label class="form-label" for="crud_type">Resurs turi</label>
                <select wire:model="form.crudType" class="form-select">
                    <option value="">Turini tanlang</option>
                    @foreach($resourceTypes as $rs)
                        <option value="{{ $rs['value'] }}">{{ $rs['name'] }}</option>
                    @endforeach
                </select>

                @error('form.crudType')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row overflow-scroll">
                <div class="col-md-4">
                    <!-- Create Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Yaratuvchi so&#8216;rov nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <input class="form-check-input" type="checkbox" wire:model="form.isCreateRequest"
                                       checked/>
                            </span>
                            <span class="input-group-text bg-light">{{ $form->createRequestPrefix }}</span>
                            <input type="text" wire:model="form.createRequestName" class="form-control"
                                   autocomplete="off">
                            <span class="input-group-text bg-light suffix-badge">{{ $form->createRequestSuffix }}</span>
                        </div>

                        @error('form.createRequestName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Update Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Yangilovchi so‘rov nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <input class="form-check-input" type="checkbox" wire:model="form.isUpdateRequest"
                                       checked/>
                            </span>
                            <span class="input-group-text bg-light">{{ $form->updateRequestPrefix }}</span>
                            <input type="text" wire:model="form.updateRequestName" class="form-control"
                                   autocomplete="off">
                            <span class="input-group-text bg-light suffix-badge">{{ $form->updateRequestSuffix }}</span>
                        </div>

                        @error('form.updateRequestName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- List Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Ro&#8216;yxatli so&#8216;rov nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <input class="form-check-input" type="checkbox" wire:model="form.isListRequest"
                                       checked/>
                            </span>
                            <span class="input-group-text bg-light">{{ $form->listRequestPrefix }}</span>
                            <input type="text" wire:model="form.listRequestName" class="form-control"
                                   autocomplete="off">
                            <span class="input-group-text bg-light suffix-badge">{{ $form->listRequestSuffix }}</span>
                        </div>

                        @error('form.listRequestName')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Service Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Servis nomi</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light">{{ $form->servicePrefix }}</span>
                    <input type="text" wire:model="form.service.name" class="form-control" autocomplete="off">
                    <span class="input-group-text bg-light">{{ $form->serviceSuffix }}</span>
                </div>

                @error('form.service[name]')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Resource -->
            @if($form->crudType === 1)
                <div class="mb-3">
                    <label class="form-label" for="name">Resurs nomi</label>
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
                <label class="form-label" for="name">Asos kontroller nomi</label>
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
