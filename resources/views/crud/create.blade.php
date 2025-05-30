@extends(config('generator.layout'))
@section('content')
    <div class="content {{ request()->routeIs('advanced.*') ? 'active' : '' }}">
        <div class="row">
            <div class="col-12">
                <livewire:crud-wire/>
            </div>
        </div>
    </div>
@endsection