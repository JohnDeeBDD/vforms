console.log("VEditor.js v 7.0");
jQuery(function($) {
    $("#titlewrap").after('<div id = "linebr"><br /></div><div id="fb-editor"></div>');
    var fbEditor = document.getElementById('build-wrap');
    console.log("Form data from server:");
    console.log("formData:");
    console.log(formData);
    if(!(formData.length === 0)){
        console.log("conditional passed line 8 [there is data]");
        formData = JSON.parse(formData);
        formData = {defaultFields: formData};
    }
    console.log(formData);
    $(document.getElementById('fb-editor')).formBuilder(formData);
    var formBuilder = $(fbEditor).formBuilder();
    $(document).submit(function(e) {
        e.preventDefault();
        $(this).unbind('submit').submit();
        console.log("click VEditor.js line 19");

        var fieldData = formBuilder.actions.getData('json', true);
        console.log(fieldData);

        delay(600).then(() => $("#content").val(fieldData));
        delay(600).then(() => tinymce.activeEditor.setContent(fieldData));

        delay(1200).then(() => $("#post, #save").submit()); console.log("1.2 sec delay VEditor.js line 24");

    });
});

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}


