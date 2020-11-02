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
    fileinput_params.uploadExtraData = function() {  // callback example
        var out = {}, key, i = 0;
        $('.kv-input:visible').each(function() {
            var $thumb = $(this).closest('.file-preview-frame'); // gets the thumbnail
            var fileId = $thumb.data('fileid'); // gets the file identifier for file thumb
            out[fileId] = $("#book_audio_files_input").val();
        });
        return out;
    };
    fileinput_params.previewThumbTags = {
        '{TAG_VALUE}': '',        // no value
        '{TAG_CSS_NEW}': '',      // new thumbnail input
        '{TAG_CSS_INIT}': 'kv-hidden'  // hide the initial input
    };
    $("#book_audio_files_input").fileinput(fileinput_params);
    //     var count=0;
    //     $("#fileuploader").uploadFile({
    //         // url:"YOUR_FILE_UPLOAD_URL",
    //         fileName:"audio_files",
    //         autoSubmit: false,
    //         uploadStr:"Выбрать",
    //         dragDropStr: "<span><b>Или перетащите файлы сюда</b></span>",
    //         extraHTML:function()
    //         {
    //             var html = "<div>Название главы: <input type='text' name='tags' value='' /> <br/>";
    //             html += "</div>";
    //             return html;
    //         },
    //         onSelect:function(files)
    //         {
    //             console.log(files);
    //             files[0].name;
    //             files[0].size;
    //             return true; //to allow file submission.
    //         },
    //         onLoad:function(obj)
    //         {
    //             $.ajax({
    //                 cache: false,
    //                 url: "/admin/audio_load/5",
    //                 dataType: "json",
    //                 success: function(data)
    //                 {
    //                     for(var i=0;i<data.length;i++)
    //                     {
    //                         obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
    //                     }
    //                 }
    //             });
    //         },
    //     });
})(jQuery);
window.onload = function() {
    tinymce.init({selector:'.tiny_editor'});
};