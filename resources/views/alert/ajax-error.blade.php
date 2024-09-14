@props(['errors'])
@if (!empty($errors))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        @foreach ($errors->all() as $error)
            {!!  $error !!} <br>
        @endforeach
    </div>
@endif
