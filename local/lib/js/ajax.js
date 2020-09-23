function sendWithAjax(thisId, output, templatePath) {
    BX.ajax({
        url: templatePath + '/component_epilog.php',
        data: {'complaint':'Y', 'id':thisId},
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