<?php $types = ['success', 'info', 'warning', 'danger'];?>

@foreach($types as $type)
    @if(Session::has($type))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ $type }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get($type) }}
                </div>
            </div>
        </div>
    @endif
@endforeach
