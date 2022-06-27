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
        $(this).unbind('submit').submit();
        console.log("click");
        var fieldData = formBuilder.actions.getData('json', true);
        //fieldData = "defaultFields: " + fieldData;

        console.log("half-n-half");
        delay(600).then(() => $("#content").val(fieldData));
        delay(1200).then(() => $("#post, #save").submit());
    });

    //$("#submitdiv").after("<a id = 'smash-to-content'>Save VForm to Content</a>");
    //$("#smash-to-content").click(function(){});
});

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}

