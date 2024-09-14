window.generateSlug = (text) => {
    return text
        .toString()
        .toLowerCase()                 // Convert text to lower case
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-\/]+/g, '')     // Remove all non-word chars except underscores, hyphens, and slashes
        .replace(/--+/g, '-')           // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

$(document).ready(function() {
    $("#select-all-checkbox-id").click(function() {
        // Toggle other checkboxes based on "select-all" state
        $("input[type=checkbox][id^='id-checkbox-']").prop("checked", this.checked);
    });

    $("input[type=checkbox]").click(function() {
        // Update "select-all" checkbox based on other checkboxes
        const allChecked = $("input[type=checkbox][id^='id-checkbox-']:not(:checked)").length === 0;
        $("#select-all-checkbox-id").prop("checked", allChecked);
    });
});
