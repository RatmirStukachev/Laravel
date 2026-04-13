const defaultLatitude = 53.855367;
const defaultLongitude = 27.426311;
let mapCenterCords = [defaultLatitude, defaultLongitude];
let placemarkCords = [defaultLatitude, defaultLongitude];


if (typeof coordsMap !== 'undefined' && coordsMap && typeof coordsMap === 'string') {
    const parsed = coordsMap.split(',').map(function(c) { return parseFloat(c.trim()); });
    if (parsed.length === 2 && !isNaN(parsed[0]) && !isNaN(parsed[1])) {
        mapCenterCords = parsed;
        placemarkCords = parsed;
    } else {
        console.error('Error parsing coordsMap or invalid format:', coordsMap);
        // mapCenterCords and placemarkCords remain default
    }
}

let cords = [...mapCenterCords];

//map
ymaps.ready(function () {
    // Создание экземпляра карты и его привязка к созданному контейнеру.
    var myMap = new ymaps.Map('map', {
            center: cords, // координаты центра карты вынес наверх
            zoom: 12,
            behaviors: ['zoomControl', 'typeSelector', 'fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        });

    myMap.behaviors.disable('scrollZoom');
    myMap.behaviors.enable('drag');

    // Создание макета балуна на основе Twitter Bootstrap.
        MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="popover">' +
                '<a class="close" href="#">&times;</a>' +
                '<div class="popover-inner">' +
                    '$[[options.contentLayout]]' +
                '</div>' +
                '<div class="arrow"></div>' +
            '</div>', {
                /**
                 * Строит экземпляр макета на основе шаблона и добавляет его в родительский HTML-элемент.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#build
                 * @function
                 * @name build
                 */
                build: function () {
                    this.constructor.superclass.build.call(this);

                    this._$element = $('.popover', this.getParentElement());

                    this.applyElementOffset();

                    this._$element.find('.close')
                        .on('click', $.proxy(this.onCloseClick, this));
                },

                /**
                 * Удаляет содержимое макета из DOM.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#clear
                 * @function
                 * @name clear
                 */
                clear: function () {
                    this._$element.find('.close')
                        .off('click');

                    this.constructor.superclass.clear.call(this);
                },

                /**
                 * Сдвигаем балун, чтобы "хвостик" указывал на точку привязки.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name applyElementOffset
                 */
                applyElementOffset: function () {
                    this._$element.css({
                        left: -(this._$element[0].offsetWidth / 2),
                        top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                    });
                },

                /**
                 * Закрывает балун при клике на крестик, кидая событие "userclose" на макете.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name onCloseClick
                 */
                onCloseClick: function (e) {
                    e.preventDefault();

                    this.events.fire('userclose');
                },

                /**
                 * Проверяем наличие элемента (в ИЕ и Опере его еще может не быть).
                 * @function
                 * @private
                 * @name _isElement
                 * @param {jQuery} [element] Элемент.
                 * @returns {Boolean} Флаг наличия.
                 */
                _isElement: function (element) {
                    return element && element[0] && element.find('.arrow')[0];
                }
            }),


        MyBalloonLayout2 = ymaps.templateLayoutFactory.createClass(
            '<div class="popover _parking">' +
                '<a class="close" href="#">&times;</a>' +
                '<div class="popover-inner">' +
                    '$[[options.contentLayout]]' +
                '</div>' +
                '<div class="arrow"></div>' +
            '</div>', {
                /**
                 * Строит экземпляр макета на основе шаблона и добавляет его в родительский HTML-элемент.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#build
                 * @function
                 * @name build
                 */
                build: function () {
                    this.constructor.superclass.build.call(this);

                    this._$element = $('.popover', this.getParentElement());

                    this.applyElementOffset();

                    this._$element.find('.close')
                        .on('click', $.proxy(this.onCloseClick, this));
                },

                /**
                 * Удаляет содержимое макета из DOM.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#clear
                 * @function
                 * @name clear
                 */
                clear: function () {
                    this._$element.find('.close')
                        .off('click');

                    this.constructor.superclass.clear.call(this);
                },

                /**
                 * Сдвигаем балун, чтобы "хвостик" указывал на точку привязки.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name applyElementOffset
                 */
                applyElementOffset: function () {
                    this._$element.css({
                        left: -(this._$element[0].offsetWidth / 2),
                        top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                    });
                },

                /**
                 * Закрывает балун при клике на крестик, кидая событие "userclose" на макете.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name onCloseClick
                 */
                onCloseClick: function (e) {
                    e.preventDefault();

                    this.events.fire('userclose');
                },

                /**
                 * Проверяем наличие элемента (в ИЕ и Опере его еще может не быть).
                 * @function
                 * @private
                 * @name _isElement
                 * @param {jQuery} [element] Элемент.
                 * @returns {Boolean} Флаг наличия.
                 */
                _isElement: function (element) {
                    return element && element[0] && element.find('.arrow')[0];
                }
        }),

    // Создание вложенного макета содержимого балуна.
        MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="w-baloon">' +
                '<div class="wrapper">' +
                    '<div class="w-baloon-name">' +
                        '$[properties.balloonName]' +
                    '</div>' +
                '</div>' +
            '</div>'
            
        ),

    // Создание метки с пользовательским макетом балуна.
        myPlacemark = window.myPlacemark = new ymaps.Placemark(cords, {
            balloonName: coodsAddress,
            }, {
                    balloonShadow: false,
                    balloonLayout: MyBalloonLayout,
                    balloonContentLayout: MyBalloonContentLayout,
                    balloonPanelMaxMapArea: 0,
                    hideIconOnBalloonOpen: false,

                    iconLayout: 'default#image',
                    iconImageHref: 'assets/i/map_marker.png',
                    iconImageSize: [30, 50],
                    iconImageOffset: [-15, -50]
                });
        myMap.geoObjects.add(myPlacemark);

        

});