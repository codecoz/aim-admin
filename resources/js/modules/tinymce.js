import '../plugins/tinymce/tinymce';

window.tinymceEditorsMap = window.tinymceEditorsMap || {};

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.initTinyMCE = (elements) => {
    elements.forEach((editorElement, index) => {
        // Assign a unique ID if the element doesn't already have one
        if (!editorElement.id) {
            editorElement.id = `dynamic-tinymce-${Date.now()}-${index}`;
        }
        tinymce.init({
            selector: `#${editorElement.id}`,
            theme: 'modern',
            theme_url: `${window.base_url}/js/themes/modern/theme.js`,
            height: "250",
            skin_url: `${window.base_url}/js/skins/lightgray`,
            external_plugins: {
                'textcolor': `${window.base_url}/js/plugins/textcolor/plugin.js`,
                'media': `${window.base_url}/js/plugins/media/plugin.js`,
                'charmap': `${window.base_url}/js/plugins/charmap/plugin.js`,
                'preview': `${window.base_url}/js/plugins/preview/plugin.js`,
                'powerpaste': `${window.base_url}/js/plugins/powerpaste/plugin.js`,
                'print': `${window.base_url}/js/plugins/print/plugin.js`,
                'table': `${window.base_url}/js/plugins/table/plugin.js`,
                'lists': `${window.base_url}/js/plugins/lists/plugin.js`,
                'link': `${window.base_url}/js/plugins/link/plugin.js`,
                'autolink': `${window.base_url}/js/plugins/autolink/plugin.js`,
                'autoresize': `${window.base_url}/js/plugins/autoresize/plugin.js`,
                'image': `${window.base_url}/js/plugins/image/plugin.js`,
                'imagetools': `${window.base_url}/js/plugins/imagetools/plugin.js`,
                'code': `${window.base_url}/js/plugins/code/plugin.js`,
                'codesample': `${window.base_url}/js/plugins/codesample/plugin.js`,
                'emoticons': `${window.base_url}/js/plugins/emoticons/plugin.js`,
                'help': `${window.base_url}/js/plugins/help/plugin.js`,
                'insertdatetime': `${window.base_url}/js/plugins/insertdatetime/plugin.js`,
                'pagebreak': `${window.base_url}/js/plugins/pagebreak/plugin.js`,
                'searchreplace': `${window.base_url}/js/plugins/searchreplace/plugin.js`,
                'spellchecker': `${window.base_url}/js/plugins/spellchecker/plugin.js`,
                'wordcount': `${window.base_url}/js/plugins/wordcount/plugin.js`,
            },
            toolbar: 'styleselect, formatselect, fontselect, fontsizeselect, bullist, numlist, outdent, indent, blockquote, searchreplace, spellchecker, wordcount, pagebreak, removeformat | image, imagetools, code, codesample, emoticons, bold, media, table, insertdatetime, italic, underline, strikethrough, link, forecolor backcolor, alignleft, aligncenter alignright, alignjustify, help',
            menubar: 'file edit view',
            image_title: true,
            convert_urls: false,
            automatic_uploads: true,
            images_upload_url: `${window.base_url}/editor-file-upload?_token=${csrfToken}`,
            file_picker_types: 'image',
            document_base_url: window.base_url,
            images_upload_handler: image_upload,
            setup: (editor) => {
                editor.on('init', () => {
                    editorElement.setAttribute('tinymce-id', editor.id);
                    window.tinymceEditorsMap[editor.id] = tinymce;
                })
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    });
};

function image_upload(blobInfo, success, failure) {
    const formData = new FormData();
    formData.append('upload', blobInfo.blob(), 'upload'); // Set file name to 'upload'
    $.ajax({
        url: `${window.base_url}/editor-file-upload?_token=${csrfToken}`,
        type: 'POST',
        data: formData,
        processData: false, // Prevents jQuery from converting the data into a query string
        contentType: false, // Must be false to prevent jQuery from adding a Content-Type header
        success: function (response) {
            success(response.url);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            let errorMessage = 'An error occurred';
            try {
                let responseJson = JSON.parse(jqXHR.responseText);
                errorMessage = responseJson.message || "Bad Request";
            } catch (e) {
                errorMessage = "Bad Request with invalid JSON response";
            }
            // Call the failure function with the custom error message
            failure('HTTP Error: ' + jqXHR.status + '. ' + errorMessage);
        }
    });
}

const ready = (callback) => {
    if (document.readyState !== "loading") callback();
    else document.addEventListener("DOMContentLoaded", callback);
};

ready(() => {
    const editorElements = document.querySelectorAll('.editor');
    initTinyMCE(editorElements);
});

