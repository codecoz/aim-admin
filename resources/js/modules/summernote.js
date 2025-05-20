import 'admin-lte/plugins/summernote/summernote-bs4.css'
import 'admin-lte/plugins/summernote/summernote-bs4.js'

// Wait for DOM to be fully loaded
$(document).ready(function () {
    // Check if elements with .editor class exist
    const $editorElements = $('.editor');

    if ($editorElements.length > 0) {
        // Initialize Summernote on all editor elements
        $editorElements.summernote({
            height: 150
        });
    }
});
