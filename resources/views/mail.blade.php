<div>
{!! nl2br($obsah) !!}
</div>
<footer>
  <small>
  <p>Pre odhlásenie sa z odberu kliknite na nasledujúci link<br>
  <a href="{{asset('newsletter/unsubscribe'.'/'.$user_id.'/'.$unsubscribe)}}">{{asset('newsletter/unsubscribe'.'/'.$user_id.'/'.$unsubscribe)}}</a>
  </p>
  </small>
</footer>