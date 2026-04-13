<div style="width: 602px; margin: 0 auto;">
    <div style="background-color: #f1f1f1; padding: 5px 0;">
        <p style="font-size: 28px; text-align: center; font-weight: 300;">Форма обратной связи<a
                href="{{env('APP_URL')}}" target="_blank"> {{env('APP_NAME')}}</a></p>
    </div>
    <div style="clear:both"></div>
    <div style="width: 90%; margin: 0 auto; padding-bottom: 5%; font-family: 'Open Sans', sans-serif;">
        <div style="font-size: 18px;">
            @if(isset($data['name']))
                <p><strong>Имя: </strong>{{$data['name']}}</p>
                <hr>
            @endif
            @if(isset($data['phone']))
                <p><strong>Телефон: </strong>{{$data['phone']}}</p>
                <hr>
            @endif
            @if(isset($data['email']))
                <p><strong>Email: </strong>{{$data['email']}}</p>
                <hr>
            @endif
            @if(isset($data['message']))
                <p><strong>Сообщение: </strong>{{$data['message']}}</p>
                <hr>
            @endif
        </div>
    </div>
    <div
        style="background-color: #f1f1f1; padding-top: 1px; padding-bottom: 1px; font-family: 'Open Sans', sans-serif; font-size: 14px;">
        <div style="width: 90%;  margin: 0 auto;">
            <p>Сообщение отправлено с сайта <a href="{{env('APP_URL')}}" target="_blank">{{env('APP_NAME')}}</a></p>
        </div>
    </div>
</div>

