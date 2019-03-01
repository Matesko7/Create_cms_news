@extends('layout.app')

@section('content')

<head>
    {!! $map['js'] !!}
</head>
<div class="container">
    <div class="jumbotron">
        <div class="header">KM consult s.r.o.</div>
        <div class="title">Komplexné <font style="color:#0076ae">účtovníctvo</font>, <font style="color:#0076ae">mzdy</font>
            a poradenstvo</div>
    </div>
</div>

<div id="onas" class="container text-center content">
    <div style="margin: 30px 150px 0 150px;font-size:18px;font-weight: 400;color: #212121;">Externé vedenie
        jednoduchého a podvojného účtovníctva, mzdovej agendy, spracovanie daňových priznaní a závierok, finančného
        a účtovného poradenstva. Transparentné ceny. S nami sa nemusíte obávať žiadnych skrytých poplatkov. Flexibilita
        v doručovaní dokladov. V rámci Bratislavy a okolia ponúkame možnosť vyzdvihnutia dokladov priamo u Vás.</div>
</div>

<div class="container content">
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-6" style="background-color: #0076ae; padding: 10px 10px 0 10px;">
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <p>Každému jednotlivému klientovi venujeme individuálnu pozornosť a osobný prístup. V závislosti od
                    Vašich špecifických potrieb Vám ponúkneme riešenia šité na mieru.</p>
                <p>Našim klientom poskytujeme poradenstvo bezplatne. Odbremeníme Vás od nutnosti orientovania sa
                    v aktuálnych zákonoch a komunikácie s úradmi.</p>
                <p>S nami nestratíte prehľad o aktuálnom stave vášho účtovníctva. Doklady spracúvame priebežne.
                    Urobíme v dokladoch poriadok. Od nás sa k Vám doklady vrátia prehľadne zotriedené.
                    Myslíme na budúcnosť. Je pre nás dôležité udržať si Vašu dôveru a spokojnosť.</p>
            </div>
        </div>
        <div class="col-sm-6 right" style="padding:0px;"></div>
    </div>
</div>

<div class="container text-center content">
    <h2 style="font-size: 24px; font-weight: 600;color:#0076ae">SLUŽBY</h2>
    <div style="margin: 30px 150px 0 150px;font-size:18px;font-weight: 400;">S nami nestratíte prehľad o aktuálnom
        stave vášho účtovníctva. Doklady spracúvame priebežne.</div>
</div>

<div class="container content">
    <div class="row" style="margin: 0 150px 0 150px;">
        <div class="col-4 text-center">
            <div>
                <i class="fas fa-chart-bar icons"></i>
            </div>
            <div style="padding-top:10px;font-size: 18px; font-weight: 400;color:#696868">
                <a href="sluzby#ucto">Účtovníctvo a dane</a>
            </div>
            <div style="padding-top:10px;font-size: 16px; font-weight: 400;color:#949494">
                Kontrola správnosti účtovných dokladov, spracovanie a zaúčtovanie dokladov podľa postupov účtovania
            </div>
        </div>
        <div class="col-4 text-center">
            <div>
                <i class="fas fa-users icons"></i>
            </div>
            <div style="padding-top:10px;font-size: 18px; font-weight: 400;color:#696868">
                <a href="sluzby#mzdy">Mzdy a personalistika</a>
            </div>
            <div style="padding-top:10px;font-size: 16px; font-weight: 400;color:#949494">
                Registrácia zamestnávateľa, vedenie evidencie zamestnancov, mesačné spracovanie miezd
            </div>
        </div>
        <div class="col-4 text-center">
            <div>
                <i class="fas fa-euro-sign icons"></i>
            </div>
            <div style="padding-top:10px;font-size: 18px; font-weight: 400;color:#696868">
                <a href="sluzby#cennik">Cenník</a>
            </div>
            <div style="padding-top:10px;font-size: 16px; font-weight: 400;color:#949494">
                Môžete si vybrať medzi cenou za položku alebo paušálnou cenou.
            </div>
        </div>
    </div>
</div>

<div class="container content">
    <div class="jumbotron2">
        <div class="header text-center">ČO HOVORIA NAŠI KLIENTI</div>
        <div class="title text-center">
            <p>Vynikajúca úroveň služieb za korektnú cenu.</p>
            <p>Oceňujem flexibilné riešenia problémov, profesionálny a ľudský prístup, rýchle spracovanie dokladov.</p>
            <p>Služby spoločnosti KM consult nám maximálne vyhovujú a so spoločnosťou budeme spolupracovať aj naďalej.</p>
            <p>Celková spokojnosť. Vyzdvihujem prístup a dodržiavanie vopred dohodnutých termínov.</p>
        </div>
    </div>
</div>

<div id="kontakt" class="container text-center content">
    <h1>KONTAKT</h1>
</div>

<div class="container">
    <div class="row" style="margin: 0 250px 0 250px;">
        <form action="{{asset('feedback')}}" method="post" style="width:100%">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input v-model="form.name" class="form-control" :class="{ 'is-invalid': hasError('name') }" id="name"
                        type="text" name="name" required>
                    <div v-if="hasError('name')" class="invalid-feedback">@{{ getError('name') }}</div>
                    <label for="name">Name *</label>
                </div>

                <div class="form-group col-md-6">
                    <input v-model="form.email" class="form-control" :class="{ 'is-invalid': hasError('email') }" id="email"
                        type="text" name="email" required>
                    <div v-if="hasError('email')" class="invalid-feedback">@{{ getError('email') }}</div>
                    <label for="email">Email*</label>
                </div>

                <div class="form-group col-md-12">
                    <textarea v-model="form.message" name="message" id="message" class="form-control" :class="{ 'is-invalid': hasError('message') }"></textarea>
                    <div v-if="hasError('message')" class="invalid-feedback">@{{ getError('message') }}</div>
                    <label for="message">Správa...</label>
                </div>
            </div>

            <div class="form-row" style="text-align: center;">
                <div class="col text-center">
                    <div>
                        <div style="width:50%;margin: 0 auto;" class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY')  }}">
                        </div>
                    </div>
                    <input type="submit" value="Odoslať" name="Odoslať" class="btn">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container text-center content">
    {!! $map['html'] !!}
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    setTimeout(function () {
        google.maps.event.trigger(markers_map[0], 'click');
    }, 2000);

</script>
@endsection
