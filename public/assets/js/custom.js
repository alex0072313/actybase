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

    if($('.fields_upload_widzet').length){
        $('.fields_upload_widzet').each(function () {
            var widzet = $(this),
                fileupload = widzet.find('.fileupload'),
                fileupload_btn = fileupload.next('button'),
                rm_exist = widzet.find('.rm_exist');

            // Удаление файлов
            rm_exist.each(function () {
                var link = $(this),
                    href = link.attr('href'),
                    link_box = link.parents('.list-group-item');

                link.click(function () {
                    widzet.addClass('loader');
                    $.ajax({
                        url: href,
                        type: 'POST',
                        dataType: 'JSON',
                        success: function (response) {
                            widzet.removeClass('loader');
                            if(response.success){
                                link_box.remove();

                                $.gritter.add({
                                    title:"Удаление файла",
                                    text:"Файл "+response.success.filename+" был успешно удален!",
                                    time:8000,
                                });

                            }else{
                                $.gritter.add({
                                    title:"Удаление файла",
                                    text:"Ошибка при удалении файла!",
                                    time:8000,
                                });
                            }
                        }
                    });
                    return false;
                });
            });
            //
            fileupload_btn.click(function(){
                fileupload.click();
                return false;
            });

            fileupload.change(function (event) {
                field_getfiles(event, widzet)
            });

        });
    }

});

function field_getfiles(event, widzet) {
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            var file = files[i];
            var file_name = i + '-' +file.name;

            if (!file.type.match('image')) continue;
            var picReader = new FileReader();
            picReader.addEventListener('load', function (event) {
                field_add_file(widzet, files[i].name);
            });
            picReader.readAsDataURL(file);
        }
    } else {
        console.log('Browser not support');
    }
}

function field_add_file(widzet, file_name){

    if(!widzet.find('.files_list').next('.files_load').length){
        widzet.find('.files_list').after('<div class="files_load"></div>');
    }

    widzet.find('.files_load').append(file_name);

    console.log(file_name);
}

