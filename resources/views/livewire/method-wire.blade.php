<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route($meta['route']) }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="namespace">Kontrollerlar</label>
                <select name="namespace" id="namespace" wire:model="namespace"
                        class="form-select">
                    <option value="">Kontroller tanlang</option>
                    @foreach($controllers as $controller)
                        <option value="{{ $controller->namespace }}">
                            {{ $controller->name }} ({{ $controller->namespace }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nomi (ort qo&#8216;shimchasiz)</label>
                <input type="text" name="name" id="name" class="form-control"/>
            </div>
            <button class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</div>