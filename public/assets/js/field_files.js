function fields_init() {
    var file_widzets = $('.fields_upload_widzet');
    file_widzets.each(function () {
        var widzet = $(this),
            file_field = widzet.find('input[type=\"file\"]'),
            btn = file_field.next('button'),
            files_load = widzet.find('.files_load'),
            cancel = widzet.find('.cancel'),
            rm_exist = widzet.find('.rm_exist');

        function initUpload() {
            btn.click(function () {
                file_field.click();
                return false;
            });
            file_field.change(getFiles);

            cancel.click(function () {
                files_load.addClass('d-none');
                files_load.find('.list-group').html('');
                file_field.val('');
            });
        }

        function initRemove() {

        }

        function initRemoveExistFiles() {
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
                            if (response.success) {
                                link_box.remove();

                                $.gritter.add({
                                    title: "Удаление файла",
                                    text: "Файл " + response.success.filename + " был успешно удален!",
                                    time: 8000,
                                });

                            } else {
                                $.gritter.add({
                                    title: "Удаление файла",
                                    text: "Ошибка при удалении файла!",
                                    time: 8000,
                                });
                            }
                        }
                    });
                    return false;
                });
            });
        }

        function getFiles() {
            if (window.File && window.FileList && window.FileReader) {
                var files = event.target.files;

                if (files.length) {
                    files_load.removeClass('d-none');
                    files_load.find('.list-group').html('');
                }

                for (let i = 0; i < files.length; i++) {
                    var file = files[i];

                    //if (!file.type.match('image')) continue;
                    var picReader = new FileReader();
                    picReader.addEventListener('load', function (event) {
                        addFile(files[i].name);
                    });
                    picReader.readAsDataURL(file);
                }
            } else {
                console.log('Browser not support');
            }
        }

        function addFile(filename) {
            var item = '<li class="list-group-item bg-grey-transparent-1 f-s-12 py-0 pr-0 d-flex justify-content-between">' +
                '<div class="name">' + filename + '</div>' +
                '</li>';

            files_load.find('.list-group').append(item);
        }

        initRemoveExistFiles();
        initUpload();

    });
}

fields_init();