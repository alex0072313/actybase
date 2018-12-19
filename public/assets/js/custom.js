$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $('[data-click="swal-warning"]').click(function (e) {
        var title = $(this).data('title') ? $(this).data('title') : 'Подтвердите действие',
            type = $(this).data('type') ? $(this).data('type') : 'warning',
            confirm_btn = $(this).data('actionbtn') ? $(this).data('actionbtn') : 'Ok',
            class_btn = $(this).data('classbtn') ? $(this).data('classbtn') : 'green',
            url = $(this).attr('href'),
            options = {};
        e.preventDefault();
        options = {
            title: title,
            icon: type,
            buttons: {
                cancel: {
                    text: 'Отмена',
                    value: !0,
                    visible: !0,
                    className: "btn btn-default", closeModal: !0,
                    value: "cancel"
                },
                confirm: {
                    text: confirm_btn,
                    value: !0,
                    visible: !0,
                    className: "btn btn-" + class_btn, closeModal: !0,
                    value: "confirm"
                }
            }
        };

        if($(this).data('text')){
            options.text = $(this).data('text');
        }

        swal(options).then((value) => {
            switch (value) {
                case "confirm":
                    window.location = url;
                    break;
            }
        });
    });

    if($('.date').length){
        $.fn.datepicker.dates['ru'] = {
            days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            daysShort: ["Вск", "Пнд", "Втр", "Срд", "Чтв", "Птн", "Суб"],
            daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
            today: "Сегодня",
            clear: "Очистить",
            format: "dd.mm.yyyy",
            weekStart: 1,
            monthsTitle: 'Месяцы'
        };

        $(".datepicker-disabled-past").datepicker({
            todayHighlight:!0,
            language: 'ru'
        });
    }

    if($('.default-select2').length){

        $(".default-select2").each(function(){
            var select = $(this),
                search = select.data('search') ? true : - 1;

                select.select2({
                    minimumResultsForSearch: search,
                    placeholder: function(){
                        $(this).data('placeholder');
                    }
                });
        });
    }

});

