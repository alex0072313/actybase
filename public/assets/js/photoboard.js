document.addEventListener('DOMContentLoaded', function () {

    var grid = null;
    var upload_input = document.getElementById('pro-image');
    var gridElement = document.querySelector('.grid');

    function initGrid() {
        return new Muuri('.grid', {
            dragEnabled: true,
            layout: {
                fillGaps: true
            }
        })
        .on('move', initSort)
        .on('sort', initSort);
    }

    function initUpload() {
        upload_input.addEventListener('change', getPhotos);
    }

    function initRemove() {
        gridElement.addEventListener('click', function (e) {
            if (elementMatches(e.target, '.remove, .remove i')) {
                removePhoto(e);
            }
        });
    }
    
    function initSort() {
        grid.getItems().forEach(function (item, i) {
            var input = $(item.getElement()).find('[name*=\"images_pos\"]');
            var filename = $(item.getElement()).data('filename');

            input.replaceWith('<input type="hidden" name="images_pos['+filename+']" value="'+ (i + 1) +'">');

        });
    }

    function getPhotos() {
        if (window.File && window.FileList && window.FileReader) {
            var files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                var file = files[i];
                var file_name = i + '-' +file.name;

                if (!file.type.match('image')) continue;
                var picReader = new FileReader();
                picReader.addEventListener('load', function (event) {
                    addPhoto(event.target, i, files[i].name);
                });
                picReader.readAsDataURL(file);
            }
        } else {
            console.log('Browser not support');
        }
    }

    function addPhoto(picFile, i, file_name){
        var photo = document.createElement('div');
        photo.className = 'item';
        photo.setAttribute('data-filename', file_name);
        photo.innerHTML = '<div class="item-content">' +
            '<input type="hidden" name="images_pos[]" value="'+ file_name +'">' +
            '<a href="javascript:;" class="remove text-danger" title="Удалить">' +
                '<i class="fas fa-fw fa-times"></i>' +
            '</a>' +
            '<div class="image" style="background-image: url(' + picFile.result + ');"></div>' +
        '</div>';

        grid.add(photo);
        initSort();
    }

    function removePhoto(e) {
        var elem = elementClosest(e.target, '.item');
        var id = elem.getAttribute('data-for');
        var remove_link = $(elem).find('.remove');
        var file_name = $(elem).attr('data-imgname');
        var files = $("#pro-image")[0].files;

        var ar = $("#pro-image")[0].files;

        for (let i = 0; i < ar.length; i++) {
            if(ar[i].name == file_name){
                ar.splice(i, 1);
            }
        }

        console.log(ar);

        $("#pro-image")[0].files = ar;

        remove_link.html('<i class="fas fa-spinner fa-spin"></i>');

        if(!id){
            grid.hide(elem, {
            onFinish: function (items) {
                var item = items[0];
                grid.remove(item, {removeElements: true});
            }});
        }else{
            removeFromServer(id,
                function (text) {
                    remove_link.html('<i class="fas fa-fw fa-times"></i>');
                    $.gritter.add({
                        title:"Ошибка при удалении изображения",
                        text:text,
                        //image:"{!!session('gritter.img') !!}",
                        //sticky: true,
                        time:8000,
                        //class_name:"gritter-error gritter-light"
                    });
                },
                function () {
                    grid.hide(elem, {
                        onFinish: function (items) {
                            var item = items[0];
                            grid.remove(item, {removeElements: true});
                        }});
                }
            );
        }
        initSort();
    }
    function elementMatches(element, selector) {
        var p = Element.prototype;
        return (p.matches || p.matchesSelector || p.webkitMatchesSelector || p.mozMatchesSelector || p.msMatchesSelector || p.oMatchesSelector).call(element, selector);
    }
    function elementClosest(element, selector) {
        if (window.Element && !Element.prototype.closest) {
            var isMatch = elementMatches(element, selector);
            while (!isMatch && element && element !== document) {
                element = element.parentNode;
                isMatch = element && element !== document && elementMatches(element, selector);
            }
            return element && element !== document ? element : null;
        }
        else {
            return element.closest(selector);
        }
    }

    function removeFromServer(id, $error_call, $success_call){

        $.ajax(
            {
                url: "/owners_images_destroy/"+id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "_method": 'DELETE',
                    "_token": document.getElementsByName("_token")[0].value,
                },
                success: function (result)
                {
                    if(result['error'] !== undefined){
                        $error_call(result['error']);
                    }

                    if(result['success'] !== undefined){
                        $success_call();
                    }
                }
            });
    }

    grid = initGrid();
    initUpload();
    initRemove();
    initSort();
});