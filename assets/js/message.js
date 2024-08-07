var message = function(msg, type="OK") {
    $.alert({
        title: " ",
        content: `<b>${msg}</b>`,
        type: (type=="OK")?"blue":"red"
    });   
}