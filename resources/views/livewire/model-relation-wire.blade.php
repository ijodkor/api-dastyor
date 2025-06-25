<div class="card mb-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>

    <div class="card-body">
        <form wire:submit.prevent="submit">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="namespace">Model</label>
                <select name="namespace" id="namespace"
                        wire:model="namespace"
                        wire:change="selectModel()"
                        class="form-select">
                    <option value="">Modelni tanlang</option>
                    @foreach($models as $model)
                        <option value="{{ $model->namespace }}">
                            {{ $model->name }} ({{ $model->namespace }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md mb-2">
                @if($namespace)
                    <small class="text-light fw-medium">Available
                        relations: {{ count($relationships) === 0 ? "No relationships for this model" : '' }}</small>
                @endif

                <div class="accordion mt-3 accordion-bordered" id="accordionStyle1">
                    @foreach($relationships as $key => $relationship)
                        <div class="accordion-item card">
                            <h2 class="accordion-header">
                                <div class="d-flex align-items-center">
                                    <input
                                        style="width: 25px; height: 25px; margin-left: 0.5rem;"
                                        class="form-check-input ml-2"
                                        type="checkbox"
                                        id="defaultCheck3"
                                        wire:model="relationships.{{$key}}.selected"
                                    />
                                    <button
                                        type="button"
                                        class="accordion-button collapsed"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#accordionStyle1-{{ $loop->index }}"
                                        aria-expanded="false">
                                        <label class="form-check-label ml-2"
                                               for="defaultCheck1"> {{ $relationship['relation_model'] }}
                                            ({{ $relationship['relation_type'] }}) </label>
                                    </button>
                                </div>
                            </h2>

                            <div id="accordionStyle1-{{ $loop->index }}" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionStyle1">
                                <div class="accordion-body">
                                    <div class="card mb-4">
                                        <h5 class="card-header">Relation info:</h5>
                                        <div class="card-body p-0">
                                            <div class="mb-3 row">
                                                <label for="html5-text-input" class="col-md-4 col-form-label">Relation
                                                    name</label>
                                                <div class="col-md-8">
                                                    <input class="form-control"
                                                           wire:model="relationships.{{$key}}.relation_name" type="text"
                                                           id="html5-text-input"/>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-search-input" class="col-md-4 col-form-label">Relation
                                                    type</label>
                                                <div class="col-md-8">
                                                    <select
                                                        wire:model="relationships.{{$key}}.relation_type"
                                                        class="form-select"
                                                    >
                                                        @if($relationship['type'] === \Ijodkor\Dastyor\Livewire\ModelRelationWire::RELATION_TYPE_BELONGS)
                                                            @foreach($belongsToOptions as $belongsToOption)
                                                                <option value="{{$belongsToOption['key']}}">
                                                                    <span>{{$belongsToOption['value']}}</span>
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach($hasManyOptions as $hasManySelect)
                                                                <option value="{{$hasManySelect['key']}}">
                                                                    <span>{{$hasManySelect['value']}}</span>
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-search-input" class="col-md-4 col-form-label">Foreign
                                                    key</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text"
                                                           wire:model="relationships.{{$key}}.foreign_key"
                                                           id="html5-search-input"/>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="html5-search-input" class="col-md-4 col-form-label">Own
                                                    key</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text"
                                                           wire:model="relationships.{{$key}}.own_key"
                                                           id="html5-search-input"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('defaultCheck1').addEventListener('click', function (event) {
        event.preventDefault();
        alert('Checkbox click prevented!');
    });
</script>