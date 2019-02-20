@if(count($errors)>0)
@foreach($errors->all() as $error)
<div class="alert alert-danger col-md-6 message">
    {{$error}}
</div>
@endforeach
@endif

@if(session('success'))
<div class="alert alert-success col-md-6 message">
    {{session('success')}}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger col-md-6 message">
    {{session('error')}}
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning col-md-6 message">
    {{session('warning')}}
</div>
@endif
