<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route($meta['route']) }}" method="post">
            @csrf
            <!-- Model -->
            <div class="mb-3">
                <label class="form-label" for="model">Model</label>
                <select wire:model="modelName" wire:click="choose" name="model[name]" id="model" class="form-select">
                    <option value="">Modelni tanlang</option>
                    @foreach($models as $model)
                        <option value="{{ $model->name }}">{{ $model->name }} ({{ $model->namespace }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Model namespace -->
            <input type="hidden" name="model[namespace]" value="{{ $modelNamespace }}">

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label" for="name">Nomi (without suffix)</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $modelName }}"
                       autocomplete="off">
            </div>

            <label class="form-label" for="package">Joylashuvi (Namespace)</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-light" id="">{{ $prefix }}</span>
                <input type="text" id="package" class="form-control" wire:model="package" wire:keyup="change"
                       placeholder="Papka" aria-describedby="basic" autocomplete="off">
            </div>
            
            <!-- Namespace -->
            <input type="hidden" name="namespace" value="{{ $namespace }}">

            <button class="btn btn-primary @if($hasError) disabled @endif">Saqlash</button>
        </form>
    </div>
</div>
