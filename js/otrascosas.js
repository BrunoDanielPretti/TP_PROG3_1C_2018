function hacerPeticionAjax(url, callback){
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: callback,
        error: function(jqXHR, textStatus, errorThrown){
            console.log("Error" + errorThrown);
        }
    });
}


function alRecibirInfo(result){
              //usas lo que recibis del ajax
}
hacerPeticionAjax('http://www.pepito.com', alRecibirInfo);