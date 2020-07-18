$(document).ready(function(){
    $(".menus").click(function (){
        let p = AjaxParams();
            p.accion="listblock.php";
            p.data = {"btn": $(this).attr("id")};
            p.lista = "CuadroListas";

        getAjax(p,function(response){
            console.log(response);
            $("."+p.lista).html("<pre style='color:white;'>"+response+"</pre>");
        });
    });

    $("#enviar").click(function (){
        let p = AjaxParams();
            p.accion="listblock.php";
            p.data = {
                    "btn": "MinerBlock",
                    "data":JSON.stringify({
                        amount: $("#amount").val(),
                        recipient: $("#recipient").val()
                    })
                };
            p.lista = "CuadroListas";
            console.log(p);
            postAjax(p,function(response){
                $("."+p.lista).html("<pre style='color:white;'>"+response+"</pre>");
            });

    });
    
})

function postAjax(p, success) {
    var params = typeof p.data == 'string' ? p.data : Object.keys(p.data).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(p.data[k]) }
        ).join('&');
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open(p.metodo, p.accion,true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) { 
            $(".blocker").hide();
            success(xhr.responseText); 
        }
        
    };
    xhr.upload.onprogress = function (event) {
        $(".blocker").show();
    };

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
}

function getAjax(p,success){
    jQuery.get(p.accion,p.data).done(function(data){
        success(data);
    })
}

function AjaxParams(){
    return {
        accion:'',
        metodo:'POST',
        form:'',
        mensaje:'',
        data:'',
        lista:'CuadroListas'
    }
}
