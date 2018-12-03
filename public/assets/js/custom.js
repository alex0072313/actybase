
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

    if($('.dropzone').length){
        Dropzone.options.myDropzone = {
            // Prevents Dropzone from uploading dropped files immediately
            autoProcessQueue : false,
            maxFiles: 5,
            init : function() {
                var submitButton = document.querySelector("#submit-all")
                myDropzone = this;
                submitButton.addEventListener("click", function() {
                    myDropzone.processQueue();  // Tell Dropzone to process all queued files.
                });
                // to handle the added file event
                this.on("addedfile", function(file) {
                    var removeButton = Dropzone.createElement("<button> Remove file </button>");
                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });
                    file.previewElement.appendChild(removeButton);
                });
                this.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                });
            }
        };

        $(".dropzone").sortable({
            items:'.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '.dropzone',
            distance: 15,
            tolerance: 'pointer'
        });

    }

});

