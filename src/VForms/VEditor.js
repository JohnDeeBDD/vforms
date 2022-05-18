console.log("VEditor.js");
jQuery(function($) {
    $("#titlewrap").after('<div id = "linebr"><br /></div><div id="fb-editor"></div>');
    var fbEditor = document.getElementById('build-wrap');
    console.log("Form data from server:");
    console.log("formData:");
    console.log(formData);
    if(!(formData.length === 0)){
        console.log("inside block");
        formData = JSON.parse(formData);
        formData = {defaultFields: formData};
    }
    console.log(formData);
    $(document.getElementById('fb-editor')).formBuilder(formData);
    var formBuilder = $(fbEditor).formBuilder();
    $(document).submit(function(e) {
        e.preventDefault();
        var fieldData = formBuilder.actions.getData('json', true);
        //fieldData = "defaultFields: " + fieldData;
        $("#content").val(fieldData);
        $(this).unbind('submit').submit();
        $("#post, #save").submit();
    });
});