function sendWithAjax(output, templatePath) {
    BX.ajax({
        url: templatePath,
        data: {'complaint':'Y'},
        method: 'POST',
        dataType: 'html',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: true,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function(data){
         output.insertAdjacentHTML('afterend', '<p>' + data + '</p>');
        },
        onfailure: function(){

        }
       }); 
}