/*!
    * Start Bootstrap - SB Admin v6.0.1 (https://startbootstrap.com/templates/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    (function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

        var $sortableList = $('.audio-files-table-body');

        var sortEventHandler = function(event, ui){
            var listElements = $sortableList.children();
            var book_id = $sortableList.data('book-id');
            var token = $sortableList.find('input[name="_token"]').val();
            var listValues = [];

            listElements.each(function(element){
                if($(this).prop('tagName') === 'TR'){
                    listValues.push($(this).data('id'));
                }
            });

            $.ajax({
                url: "/admin/sort_audio/"+book_id,
                dataType: "json",
                type:'post',
                data: {
                    audio_file_ids: listValues,
                    _token: token
                }
            });
        };

        $sortableList.sortable({
            stop: sortEventHandler
        });
        $sortableList.on("sortchange", sortEventHandler);

        $('.remove-audio-file').click(function() {
            let id = $(this).data('id');
            let token = $(this).closest('form').find('input[name="_token"]').val();
            let tr = $(this).closest('tr');
            let $this = $(this);
            if (confirm('Are you sure remove this audio?')) {
                console.log(id);
                console.log(token);
                $.post({
                    url: "/admin/remove_audio/"+id,
                    data: {
                        _token: token
                    },
                    success: function(data)
                    {
                        tr.remove();
                    }
                });
            }
        });
    $('#modalBlocks .row').hover(function () {
        if($(this).find('.block-info').length === 0){
            $(this).append('<div class="block-info justify-content-center align-items-center">\n' +
                '                                <div>\n' +
                '                                    <button type="button" class="btn btn-primary">Добавить</button>\n' +
                '                                </div>\n' +
                '                            </div>');
        }else{
            $(this).find('.block-info').remove();
        }
    });
    let body = $('body');
    $('#page-blocks .row').css('position','relative');

    $('#page-blocks .row').hover(function () {
        if($(this).find('.block-info').length === 0){
            $(this).append('<div class="block-info justify-content-center align-items-center">\n' +
                '                                <div>\n' +
                '                                    <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>\n' +
                '                                </div>\n' +
                '                            </div>');
        }else{
            $(this).find('.block-info').remove();
        }
    });
    let count = $('#page-blocks .container-fluid').find('.row');
    count = count.length;
    body.on('click','#modalBlocks .row .block-info button', function () {

        console.log(count);
        let element = $(this).closest('.row').clone();
        element.find('.block-info').remove();
        element.removeClass('mt-5 p-2 bg-light text-dark border border-dark rounded');
        element.addClass('mb-3');
        element.attr('data-index', count);
        element.attr('data-type', element.data('id'));
        element.off();
        switch (element.data('id')) {
            case 'block-title':
                element.append('<input type="hidden" name="data['+count+'][type]" value="'+element.data('id')+'">');
                element.append('<input type="hidden" name="data['+count+'][status]" value="1">');
                element.append('<input type="hidden" name="data['+count+'][content][title]" data-type="input" value="title">');
                break;
            case 'block-title-text':
                element.append('<input type="hidden" name="data['+count+'][type]" value="'+element.data('id')+'">');
                element.append('<input type="hidden" name="data['+count+'][status]" value="1">');
                element.append('<input type="hidden" name="data['+count+'][content][title]" data-type="input" value="title">');
                element.append('<input type="hidden" name="data['+count+'][content][text]" data-type="textarea" value="text">');
                break;
            case 'block-text-image':
                element.append('<input type="hidden" name="data['+count+'][type]" value="'+element.data('id')+'">');
                element.append('<input type="hidden" name="data['+count+'][status]" value="1">');
                element.append('<input type="hidden" name="data['+count+'][content][title]" data-type="input" value="title">');
                element.append('<input type="hidden" name="data['+count+'][content][text]" data-type="textarea" value="text">');
                element.append('<input type="hidden" name="data['+count+'][content][image]" data-type="file" value="image">');
                break;
            case 'block-image-text':
                element.append('<input type="hidden" name="data['+count+'][type]" value="'+element.data('id')+'">');
                element.append('<input type="hidden" name="data['+count+'][status]" value="1">');
                element.append('<input type="hidden" name="data['+count+'][content][title]" data-type="input" value="title">');
                element.append('<input type="hidden" name="data['+count+'][content][text]" data-type="textarea" value="text">');
                element.append('<input type="hidden" name="data['+count+'][content][image]" data-type="file" value="image">');
                break;
            case 'block-text':
                element.append('<input type="hidden" name="data['+count+'][type]" value="'+element.data('id')+'">');
                element.append('<input type="hidden" name="data['+count+'][status]" value="1">');
                element.append('<input type="hidden" name="data['+count+'][content][text]" data-type="textarea" value="text">');
                break;
            case 'block-media':
                element.append('<input type="hidden" name="data['+count+'][type]" value="'+element.data('id')+'">');
                element.append('<input type="hidden" name="data['+count+'][status]" value="1">');
                element.append('<input type="hidden" name="data['+count+'][content][0][title]" data-type="input" value="title">');
                element.append('<input type="hidden" name="data['+count+'][content][0][text]" data-type="textarea" value="text">');
                element.append('<input type="hidden" name="data['+count+'][content][0][image]" data-type="file" value="image">');
                break;
        }
        element.css('position','relative');
        element.hover(function () {
            console.log('fgg');
            if($(this).find('.block-info').length === 0){
                $(this).append('<div class="block-info justify-content-center align-items-center">\n' +
                    '                                <div>\n' +
                    '                                    <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>\n' +
                    '                                </div>\n' +
                    '                            </div>');
            }else{
                $(this).find('.block-info').remove();
            }
        });
        element.appendTo('#page-blocks .container-fluid');
        $('#modalBlocks').modal('hide');
        count++;
    });
    var block_element;
    body.on('click','#page-blocks .row .block-info button', function () {
        block_element = $(this).closest('.row');
        // $('#modalBlocksEdit').find('.modal-body').append('<input type="hidden" name="block_index" value="'+block_element.data('index')+'">');
        // $('#modalBlocksEdit').find('.modal-body').append('<input type="hidden" name="block_type" value="'+block_element.data('type')+'">');
        $('#modalBlocksEdit').modal('show');
    });

    $('#modalBlocksEdit').on('hide.bs.modal', function () {
        console.log('close');
    });

    $('.search-vip').on('input',function () {
        let value = $(this).val();
        let token = $(this).siblings('input[name="_token"]').val();
        let tbody = $(this).closest('div').siblings('table');
        if(value.length > 3){
            $.post({
                url: "/admin/search_vip",
                data: {
                    name: value,
                    _token: token
                },
                success: function(data)
                {
                    tbody.html(data);
                    tbody.show();
                }
            });
        }
        console.log(value);
    });

    $('.vip-search-results').on('click','tr', function () {
        let id = $(this).data('id');
        let text = $(this).find('td:last-child').text().trim();
        $(this).closest('.row').find('.search-vip').val(text);
        $(this).closest('.row').find('input[name="object_id"]').val(id);
    });

    $('.generate-code').on('click', function () {
        let object_id = $(this).closest('.row').find('input[name="object_id"]').val();
        let user_id = $(this).closest('.row').find('input[name="user_id"]').val();
        let token = $(this).closest('.row').find('input[name="_token"]').val();
        let tbody = $(this).closest('.modal-body').find('.table tbody');
        if(object_id && user_id){
            $.post({
                url: "/admin/generate_vip_code",
                data: {
                    object_id: object_id,
                    user_id: user_id,
                    _token: token
                },
                success: function(data)
                {

                    tbody.append(data);
                }
            });
        }else{
            alert('Выберите видео');
        }
    });

    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'));
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);

        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show()
        })
    });

    var triggerLessonMaterialTabList = [].slice.call(document.querySelectorAll('#lessonMaterialTab a'));
    triggerLessonMaterialTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);

        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show()
        })
    });

    $('#modal_save_edit_block').on('click', function () {
        let modal = $(this).closest('#modalBlocksEdit');
        let block_type = block_element.data('type');
        let block_index = block_element.data('index');

        let title = modal.find('input[name="title"]').val();
        let text = modal.find('textarea[name="text"]').val();
        let file = document.getElementById("blocks-edit-image").files[0];

        let token = modal.find('input[name="_token"]').val();
        switch (block_type) {
            case 'block-title':
                block_element.find('input[name="data['+block_element.data('index')+'][content][title]"]').val(title);
                block_element.find('h1').text(title);
                break;
            case 'block-title-text':
                block_element.find('input[name="data['+block_element.data('index')+'][content][title]"]').val(title);
                block_element.find('input[name="data['+block_element.data('index')+'][content][text]"]').val(text);
                block_element.find('h3').text(title);
                block_element.find('div.text').text(text);
                break;
            case 'block-text':
                block_element.find('input[name="data['+block_element.data('index')+'][content][text]"]').val(text);
                block_element.find('div.text').text(text);
                break;
            default:
                if(title.length > 0){
                    block_element.find('input[name="data['+block_element.data('index')+'][content][title]"]').val(title);
                    block_element.find('h3').text(title);
                }

                if(text.length > 0){
                    block_element.find('input[name="data['+block_element.data('index')+'][content][text]"]').val(text);
                    block_element.find('div.text').text(text);
                }
                if (typeof file !== 'undefined') {
                    let req = new XMLHttpRequest();
                    let formData = new FormData();

                    formData.append("file", file);
                    formData.append("_token", token);
                    req.open("POST", '/admin/upload/file');
                    req.send(formData);
                    req.onload =function () {
                        console.log(req.response, req.status);
                        if(req.status === 200){
                            if(req.response.length > 0){
                                let data = JSON.parse(req.response);
                                block_element.find('input[name="data['+block_element.data('index')+'][content][image]"]').val(data.url);
                            }
                        }
                    };
                }

                break;
        }
        modal.modal('hide');
    });
    body.on('click', '.add-more-video, .add-more-file', function () {

        let lesson_detail = $(this).closest('.lesson-detail');

        let index = lesson_detail.data('index');
        let files = lesson_detail.find('.video-files');
        let title = 'Загрузите видео';
        let input_name = 'video_link';

        if($(this).hasClass('add-more-file')){
            files = lesson_detail.find('.lesson-files');
            title = 'Загрузите файл';
            input_name = 'file_link';
        }

        files.append('<div class="row file-row">\n' +
        '                                                <div class="col-xs-6 col-sm-6 col-md-6">\n' +
        '                                                    <div class="form-group">\n' +
        '                                                        <div class="custom-file">\n' +
        '                                                            <input type="file" class="custom-file-input" name="lessons[' + index + '][' + input_name + '][]" >\n' +
        '                                                            <label class="custom-file-label">' + title + '</label>\n' +
        '                                                        </div>\n' +
        '                                                    </div>\n' +
        '                                                </div>\n' +
        '                                                <div class="col-xs-3 col-sm-3 col-md-3">\n' +
        '                                                    <a href="javascript:;" class="btn btn-success add-more-video">добавить еще ...</a>\n' +
        '                                                    <a href="javascript:;" class="btn btn-danger remove-video"><i class="fa fa-trash"></i></a>\n' +
        '                                                </div>\n' +
        '                                                <div class="col-xs-3 col-sm-3 col-md-3">\n' +
        '                                                    <a href="javascript:;" class="btn btn-light set-as-external">Указать на внешний ресурс</a>\n' +
        '                                                </div>' +
        '                                            </div>');
    });
    body.on('click', '.remove-video', function () {
        $(this).closest('.file-row').remove();
    });
    body.on('click', '.set-as-external, .set-as-external-file', function () {
        let title = 'Укажите ссылку на видео';

        if($(this).hasClass('set-as-external-file')){
            title = 'Укажите ссылку на файл';
        }
        let form_group = $(this).closest('.row').find('.form-group');
        let input_name = form_group.find('input[type="file"]').attr('name');
        form_group.html('<input type="text" class="form-control" placeholder="' + title + '" name="' + input_name + '">');
    });
    body.on('click', '.add-more-lesson', function () {
        let index = $(this).closest('.lesson-detail').data('index');
        index++;
        $('#lesson-accordion').append('<div class="card">\n' +
            '                            <div class="card-header" id="heading_' + index + '">\n' +
            '                                <h2 class="mb-0">\n' +
            '                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse_' + index + '" aria-expanded="true" aria-controls="collapse_' + index + '">\n' +
            '                                        Новый урок' +
            '                                    </button>\n' +
            '                                </h2>\n' +
            '                            </div>\n' +
            '\n' +
            '                            <div id="collapse_' + index + '" class="collapse show" aria-labelledby="heading_' + index + '" data-parent="#lesson-accordion">\n' +
            '                                <div class="card-body">\n' +
            '                                    <div class="row mt-5 lesson-detail" data-index="' + index + '">\n' +
            '                                        <div class="col-xs-12 col-sm-12 col-md-12">\n' +
            '                                            <div class="form-group">\n' +
            '                                                <input type="text" name="lessons[' + index + '][name]" class="form-control" placeholder="Название">\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                        <div class="col-xs-12 col-sm-12 col-md-12">\n' +
            '                                            <div class="form-group">\n' +
            '                                <textarea class="form-control tiny_editor" style="height:150px" name="lessons[' + index + '][lesson]"\n' +
            '                                          placeholder="Описание курса"></textarea>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                        <div class="col-md-12 video-files">\n' +
            '                                            <div class="row">\n' +
            '                                                <div class="col-xs-6 col-sm-6 col-md-6">\n' +
            '                                                    <div class="form-group">\n' +
            '                                                        <div class="custom-file">\n' +
            '                                                            <input type="file" class="custom-file-input" name="lessons[' + index + '][video_link][]">\n' +
            '                                                            <label class="custom-file-label">Загрузите видео</label>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                                <div class="col-xs-3 col-sm-3 col-md-3">\n' +
            '                                                    <a href="javascript:;" class="btn btn-success add-more-video">добавить еще ...</a>\n' +
            '                                                </div>\n' +
            '                                                <div class="col-xs-3 col-sm-3 col-md-3">\n' +
            '                                                    <a href="javascript:;" class="btn btn-light set-as-external">Указать на внешний ресурс</a>\n' +
            '                                                </div>' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                        <div class="col-md-12">\n' +
            '                                            <a href="javascript:;" class="btn btn-success add-more-lesson">добавить еще один урок</a>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>');
        if (typeof tinymce !== 'undefined') {
            tinymce.init({selector:'.tiny_editor'});
        }
    });
    body.on('click','.remove-lesson-video, .remove-lesson-file', function(){
        let id = $(this).data('id');
        let div = $(this).closest('div');
        let token = $('input[name="_token"]').val();
        let type = 'video';
        if($(this).hasClass('remove-lesson-file')){
            type = 'file'
        }
        if(confirm('Действительно хотите удалить?')){
            $.post({
                url: "/admin/remove_lesson_video",
                data: {
                    id: id,
                    type: type,
                    _token: token
                },
                success: function(data)
                {
                    div.remove();
                }
            });
        }
    });

})(jQuery);
window.onload = function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({selector:'.tiny_editor'});
    }
};