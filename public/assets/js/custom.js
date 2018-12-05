
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
        $(".default-select2").select2({
            minimumResultsForSearch: function(){
                if($(this).data('search')){
                    return true;
                }else {
                    return -1;
                }
            },
            placeholder: function(){
                $(this).data('placeholder');
            }
        })
    }

    if($('.image_uploads').length){
       
        $(document).ready(function() {
            document.getElementById('pro-image').addEventListener('change', readImage, false);
            
            $( ".preview-images-zone" ).sortable();
            
            $(document).on('click', '.image-cancel', function() {
                let no = $(this).data('no');
                $(".preview-image.preview-show-"+no).remove();
            });
        });


        var num = 4;
        function readImage() {
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files; //FileList object
                var output = $(".preview-images-zone");

                for (let i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (!file.type.match('image')) continue;
                    
                    var picReader = new FileReader();
                    
                    picReader.addEventListener('load', function (event) {
                        var picFile = event.target;
                        var html =  '<div class="preview-image preview-show-' + num + '">' +
                                    '<div class="image-cancel" data-no="' + num + '">x</div>' +
                                    '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                                    '<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num + '" class="btn btn-light btn-edit-image">edit</a></div>' +
                                    '</div>';

                        output.append(html);
                        num = num + 1;
                    });

                    picReader.readAsDataURL(file);
                }
                //$("#pro-image").val('');
            } else {
                console.log('Browser not support');
            }
        }

    }

});

