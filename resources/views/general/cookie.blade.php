<section class="s-cookie _js-cookie-alert">
    <div class="w-cookie-alert">
        <div class="frame">
            <div class="text">
                Этот сайт использует cookies<br>
                <a @if(\App\Services\Support\TextService::getSettingValue('content', 'privacy')) href="{{ route('page', ['slug' => \App\Services\Support\TextService::getSettingValue('content', 'privacy') ]) }}"@endif class="__link">Политика в отношении обработки персональных данных</a>
            </div>
            <div class="w-button">
                <a href="" class="button _js-b-cookie-alert">Принять</a>
            </div>
        </div>
    </div>
</section>

<style>
    .s-cookie * {
        box-sizing: border-box;
    }
    .s-cookie {
        display: none;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        pointer-events: none;
        z-index: 50;
        box-sizing: border-box;
    }
    .s-cookie .w-cookie-alert {
        padding-left: 10px;
        padding-right: 10px;
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        width: 100%;
        transition: all 0.2s ease;
    }
    .s-cookie .w-cookie-alert>.frame {
        margin-left: auto;
        margin-right: auto;
        max-width: 400px;
        padding: 15px;
        background-color: #202020;
        color: #fff;
        font-size: 0;
        line-height: 0;
        pointer-events: all;
        border-radius: 4px 4px 0 0;
    }
    .s-cookie .w-cookie-alert>.frame>* {
        display: inline-block;
        vertical-align: middle;
        font-size: 13px;
        line-height: 16px;
    }
    .s-cookie .w-cookie-alert>.frame>.text {
        width: calc(100% - 150px);
    }
    .s-cookie .w-cookie-alert>.frame>.w-button {
        width: 150px;
    }
    .s-cookie .w-cookie-alert>.frame .button {
        display: block;
        text-decoration: none;
        padding: 5px 15px;
        color: #fff;
        border: 1px solid #fff;
        background: transparent;
        transition: all 0.2s ease;
        text-align: center;
    }
    .s-cookie .w-cookie-alert>.frame .button:hover {
        background-color: #fff;
        border-color: #fff;
        color: #202020;
    }
    .s-cookie .w-cookie-alert>.frame .__link {
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        opacity: 0.7;
        text-decoration: underline;
    }
    .s-cookie .w-cookie-alert>.frame a.__link:hover {
        opacity: 1;
        text-decoration: none;
    }
    .s-cookie.hide .w-cookie-alert {
        bottom: -500px;
    }
    @media (max-width: 575px) {
        .s-cookie .w-cookie-alert>.frame>.text {
            width: calc(100% - 90px);
        }
        .s-cookie .w-cookie-alert>.frame>.w-button {
            width: 90px;
        }
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cookieAlert = document.querySelector('._js-cookie-alert');
        const acceptButton = document.querySelector('._js-b-cookie-alert');

        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "; expires=" + date.toUTCString();
            document.cookie = name + "=" + value + expires + "; path=/";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length);
            }
            return null;
        }

        if (getCookie('cookieAccepted') !== 'true') {
            cookieAlert.style.display = 'block';
        }

        acceptButton.addEventListener('click', function(e) {
            e.preventDefault();
            cookieAlert.classList.add('hide');
            // Устанавливаем cookie на 1 год
            setCookie('cookieAccepted', 'true', 365);

            setTimeout(() => {
                cookieAlert.style.display = 'none';
            }, 200);
        });
    });
</script>

