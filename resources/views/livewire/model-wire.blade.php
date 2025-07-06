<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route($meta['route']) }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="table[name]">Jadval nomi</label>
                <select name="table[name]" id="table[name]"
                        wire:model="tableName" wire:change="choose"
                        class="form-select">
                    <option value="">Jadvalni tanlang</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->name }}">{{ $table->name }} ({{ $table->migration }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nomi (ort qo&#8216;shimchasiz)</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $name }}"/>
            </div>

            <label class="form-label" for="package">Papka (Namespace)</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-light" id="">App\Models\</span>
                <input type="text" name="package" id="package" wire:model="package" wire:keyup="change"
                       class="form-control" placeholder="Nomi" aria-describedby="basic"
                       autocomplete="off">
            </div>

            <!-- Namespace -->
            <input type="hidden" name="namespace" value="{{ $namespace }}">

            <button class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</div>