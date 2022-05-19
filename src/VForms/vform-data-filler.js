/*global jQuery*/
/*global vFormData*/

console.log("vform-data-filler.js active");

//console.log("DATADATA:");
//console.log(typeof vFormData);
//console.log(vFormData);
//console.log(JSON.parse(vFormData));

const VFormDataFiller = {};

VFormDataFiller.doFill = function() {
    vFormDataJSON = JSON.parse(vFormData);
    var data = VFormDataFiller.getDataEntries(vFormDataJSON);
    console.log(data);
    var keys = VFormDataFiller.getDataKeys(vFormDataJSON);
    keys.forEach((key) => {
        var selector = "#" + key;
        //console.log(selector);
        var checkboxSelector = "input[name='" + key + "[]" + "']";
        console.log(checkboxSelector);

        if(jQuery(checkboxSelector).attr('type') == "checkbox"){
            console.log("CHECKBOX: ");
            console.log(selector);
            console.log(data[key]);
            jQuery.each(data[key], function(i, val){
                jQuery("input[value='" + val + "']").prop('checked', true);
            });
        }

        var radioSelector = "input[name='" + key + "'][value='" + data[key] + "']";
        console.log(radioSelector);
        //console.log(checkboxSelector);
        if(jQuery(radioSelector).attr('type') == "radio"){
            console.log("RADIO GROUP: ");
            console.log(key);
            console.log(data[key]);
            jQuery(radioSelector).prop('checked', true);
        }


        jQuery(selector).val(data[key]);
    });
}

VFormDataFiller.getDataKeys = function(data){
    var result = [];

    data.forEach((element) => {
        const propertyNames = Object.keys(element);
        result.push(propertyNames[0]);
    });

    return (result);
}

VFormDataFiller.getDataEntries = function(data){
    //console.log(data[0]);
   // var x = (data[0]);
    //console.log(x['vform-rec-id']);

    var keys = VFormDataFiller.getDataKeys(data);
    var counter = 0;
    var finalData = [];
    keys.forEach((element) => {
        //console.log("KEY " + element);
        //console.log("DATA ");
        var x = data[counter];
       // console.log(x[element]);
        finalData[element] = (x[element]);
        counter = counter + 1;
    });
    return (finalData);
}