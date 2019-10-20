@extends('layout.app_admin')

@section('content')

<div class="row" style="margin-left:0px; margin-right: 0px;">
    <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
        <div style="font-size: 18px; font-weight: 400;color: fff;">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emails as $key => $email)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{{$email->email}}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $emails->links() }}
    </div>
</div>

@endsection
