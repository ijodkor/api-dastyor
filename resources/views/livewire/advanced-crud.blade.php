<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route($meta['route']) }}" method="post">
            @csrf

            <!-- Model -->
            <div class="mb-3">
                <label class="form-label" for="model">Model Name</label>
                <select wire:model="modelNamespace" wire:click="modelChoose" name="model[name]" id="model"
                        class="form-select">
                    <option value="">Select model</option>
                    @foreach($models as $model)
                        <option value="{{ $model->namespace }}"
                            {{ $model->namespace == old('modelNamespace')? 'selected' : '' }} >
                            {{ $model->name }} ({{ $model->namespace }})
                        </option>
                    @endforeach
                    @error('model.name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
                <!-- Model namespace -->
                <input type="hidden" name="model[namespace]" value="{{ $modelNamespace }}">

                @error('model.name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Controller Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Controller Name</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light">{{ $controllerPrefix }}</span>
                    <input type="text" name="controller[name]" id="controller_name" class="form-control"
                           value="{{ old('controller.name', $controllerName) }}" autocomplete="off">
                    <span class="input-group-text bg-light">{{ $controllerSuffix }}</span>
                </div>
                <!-- Controller Namespace -->
                <input type="hidden" name="controller[prefix]" value="{{ $controllerPrefix  }}">
                <input type="hidden" name="controller[suffix]" value="{{ $controllerSuffix  }}">
                @error('controller.name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Create Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Create Request Nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">{{ $createRequestPrefix }}</span>
                            <input type="text" name="request[create]" id="controller_name" class="form-control"
                                   value="{{ $createRequestName }}" autocomplete="off">
                            <span class="input-group-text bg-light">{{ $createRequestSuffix }}</span>
                        </div>
                        <!-- Create Request Namespace -->
                        <input type="hidden" name="request[create][prefix]" value="{{ $createRequestPrefix  }}">
                        <input type="hidden" name="request[create][suffix]" value="{{ $createRequestSuffix  }}">
                        @error('request.create.name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Update Request Name -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Update Request Nomi</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">{{ $updateRequestPrefix }}</span>
                            <input type="text" name="controller[name]" id="controller_name" class="form-control"
                                   value="{{ $updateRequestName }}" autocomplete="off">
                            <span class="input-group-text bg-light">{{ $updateRequestSuffix }}</span>
                        </div>
                        <input type="hidden" name="request[update][prefix]" value="{{ $updateRequestPrefix  }}">
                        <input type="hidden" name="request[update][suffix]" value="{{ $updateRequestSuffix  }}">
                        @error('request.update.name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Base Controller Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Base Controller Name</label>
                <div class="input-group mb-3">
                    <input type="text" name="controller[base]" id="controller_name" class="form-control"
                           value="{{ $baseController }}" autocomplete="off">
                </div>
                @error('controller.name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Model -->
            <div class="mb-3">
                <label class="form-label" for="model">Crud Type</label>
                <select name="crud[type]" id="model"
                        class="form-select">
                    <option value="">Select type</option>

                    <option value="1">Api uchun</option>
                    <option value="2">Blade uchun</option>

                    @error('model.crud_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
                <!-- Model namespace -->
                <input type="hidden" name="model[namespace]" value="{{ $modelNamespace }}">

                @error('model.name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <button class="btn btn-primary @if($hasError) disabled @endif">Saqlash</button>
        </form>
    </div>
</div>
