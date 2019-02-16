@extends('layout.app')

@section('content')
<div class="container">
    <div class="row" style="margin: 0 250px 0 250px;">
        <form style="width:100%;">
            <div class="form-row">
                <div class="form-group col-md-6 container text-center content">
                    <input type="text" class="form-control" name="e-mail" required>
                    <label for="e-mail">E-mail *</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="password" required>
                    <label for="password">Name *</label>
                </div>
            </div>
            <div class="form-row" style="text-align: center;">
                <div class="col text-center">
                    <input type="submit" name="Odoslať" class="btn">
                </div>
            </div>
        </form>
    </div>
</div>

@endsection