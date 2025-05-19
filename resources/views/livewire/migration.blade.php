<div class="card mb-4">
    <form wire:submit.prevent="save" method="post">
        <div class="card-header">
            <h5 class="card-tile mb-0">
                {{ $meta['description'] }}
            </h5>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible mt-2" role="alert">
                    <h5 class="alert-heading mb-2">{{ session('success') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <h5 class="alert-heading mb-2">Tekshiruv bo&#8216;yicha xatoliklar!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row mt-3">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name" class="form-label @error('name') text-danger @enderror">Jadval nomi</label>
                        <input type="text" wire:model="name"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="scheme" class="form-label">Sxema nomi</label>
                        <select name="scheme" id="scheme" class="form-select">
                            <option value="">Sxemani tanlang</option>
                            @foreach($schemas as $schema)
                                <option value="{{ $schema }}">{{ $schema }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="scheme" class="form-label">Bazadagi jadvallar</label>
                        <select name="scheme" id="scheme" class="form-select">
                            <option value="">Jadvalni tanlang</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->name }}">{{ $table->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-group mt-3">
                        <input type="checkbox" id="softDelete"
                               wire:model="softDelete"
                               class="form-check-input @error("softDelete") is-invalid @enderror" value="1">
                        <label for="softDelete">Soxta o&#8216;chirish qo&#8216;shilsinmi (<strong>Soft delete</strong>)?</label>
                        @error("softDelete")
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="alert alert-primary mt-3" role="alert">
                <span>Id va sanalar kerak emas!</span>
            </div>
        </div>

        <div class="card-body">
            @csrf
            <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4 text-end">
                    <button type="button" class="btn btn-info" wire:click="addColumn">
                        <i class="ti ti-plus"></i>
                        <span>Qo&#8216;shish</span>
                    </button>
                </div>
            </div>
            <br>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                    <tr>
                        <th>Ustun nomi</th>
                        <th>Ustun turi</th>
                        <th>Uzunligi</th>
                        <th>Boshlang&#8216;ich</th>
                        <th>Bo&#8216;sh</th>
                        <th>Indekslangan</th>
                        <th>Bog&#8216;lanish</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($columns as $key => $column)
                        @php $name = "columns[$key]"; @endphp

                        <tr>
                            <td class="px-1">
                                <input name="{{$name}}[name]" id="{{$name}}[name]"
                                       wire:model="columns.{{$key}}.name"
                                       class="form-control @error("columns.$key.name") is-invalid @enderror"
                                       autocomplete="off">
                                @error("columns.$key.name")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="px-1">
                                <select name="{{$name}}[type]" id="{{$name}}[type]"
                                        wire:model="columns.{{$key}}.type"
                                        class="form-select select2 @error("columns.$key.type") is-invalid @enderror">
                                    <option value="">Turi tanlang</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error("columns.$key.type")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="px-1">
                                <input type="number" name="{{$name}}[length]" id="{{$name}}[length]"
                                       wire:model="columns.{{$key}}.length"
                                       class="form-control @error("columns.$key.length") is-invalid @enderror"
                                       autocomplete="off">
                                @error("columns.$key.length")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="">
                                <input type="text" name="{{$name}}[default]" id="{{$name}}[default]"
                                       wire:model="columns.{{$key}}.default"
                                       class="form-control @error("columns.$key.default") is-invalid @enderror"
                                       autocomplete="off">
                                @error("columns.$key.default")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="px-1">
                                <input type="checkbox" name="{{$name}}[nullable]" id="{{$name}}[nullable]"
                                       wire:model="columns.{{$key}}.nullable" value="1"
                                       class="form-check-input @error("columns.$key.length") is-invalid @enderror">
                            </td>
                            <td class="px-1">
                                <input type="checkbox" name="{{$name}}[index]" id="{{$name}}[index]"
                                       wire:model="columns.{{$key}}.index"
                                       class="form-check-input @error("columns.$key.index") is-invalid @enderror">
                                @error("columns.$key.index")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="px-1">
                                <select name="{{$name}}[constrained]" id="{{$name}}[constrained]"
                                        wire:model="columns.{{$key}}.constrained"
                                        class="form-select">
                                    <option value="">Jadvalni tanlang</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->name }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                                @error("columns.$key.constrained")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="px-1">
                                <button type="button" wire:click="remove({{ $key }})" class="btn btn-danger px-2">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


            <div class="mt-3">
                @if($this->columns->isEmpty())
                    <div class="fw-bold text-center">Ustunlar shu yerda yaratiladi!</div>
                @endif
            </div>

            <div class="row mt-5">
                <label class="form-label" for="package">Joylashuv - Papka (Namespace)</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light">{{ $prefix }}</span>
                    <input type="text" id="package" wire:model="package" wire:keyup="change"
                           class="form-control" placeholder="Nomi" aria-describedby="basic">
                </div>
            </div>

            <!-- Namespace -->
            <input type="hidden" name="namespace" value="{{ $namespace }}">

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
    </form>
</div>