@extends('layout.app_admin')

@section('content')
<div class="container">
<div class="w3-content w3-padding" style="text-align:center;margin-top:80px;max-width:1564px">
    
    <div style="width:70%;margin:auto">
    {{ Form::open(array('url' => asset("admin/carousel"),'files' => true)) }}@csrf
    <div class="form-group text-center">
            <div class="text-center">
            @if($photo_1)
                <img style="max-width:400px;" src="{{asset('carousel/1.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_1" id="file_1" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.1:&nbsp<input name="file_1" id="file_1" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_2)
                <img style="max-width:400px;" src="{{asset('carousel/2.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_2" id="file_2" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.2:&nbsp<input name="file_2" id="file_2" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif        
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_3)
                <img style="max-width:400px;" src="{{asset('carousel/3.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_3" id="file_3" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.3:&nbsp<input name="file_3" id="file_3" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_4)
                <img style="max-width:400px;" src="{{asset('carousel/4.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_4" id="file_4" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.4:&nbsp<input name="file_4" id="file_4" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_5)
                <img style="max-width:400px;" src="{{asset('carousel/5.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_5" id="file_5" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.5:&nbsp<input name="file_5" id="file_5" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_6)
                <img style="max-width:400px;" src="{{asset('carousel/6.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_6" id="file_6" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.6:&nbsp<input name="file_6" id="file_6" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_7)
                <img style="max-width:400px;" src="{{asset('carousel/7.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_7" id="file_7" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.7:&nbsp<input name="file_7" id="file_7" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
            <hr><hr>
            <div class="text-center">
            @if($photo_8)
                <img style="max-width:400px;" src="{{asset('carousel/8.jpg')}}" class="avatar" alt="article_photo"><br><br><input name="file_8" id="file_8" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @else
                <br><br>
                Fotka č.8:&nbsp<input name="file_8" id="file_8" style="margin:auto" type="file"
                    accept="image/x-png,image/jpeg" />
            @endif
            </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <button  type="submit" class="btn btn-info show-more">Uložiť</button>
        </div>
    </div>
    {{ Form::close() }}
</div>
</div>
</div>   
  @endsection