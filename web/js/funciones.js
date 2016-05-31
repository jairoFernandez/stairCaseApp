/*
 * Menu
 */


$(document).ready(function () {
    var menuPress = localStorage.getItem("menuLateral");
    
    if(menuPress != null){
        //alert("hay uno " + menuPress)
        $(".menu-lateral-item").removeClass("active");
        $("#" + menuPress + "").addClass("active");
        $("#" + menuPress + "").find("a").find("span.sr-only").html("(current)");
        
        $(".menulateral li").each(function(){ 
            var liactual = $(this);
            if(liactual.attr("id") != menuPress){
                liactual.removeClass("active");
                liactual.parent().find("span.sr-only").html(""); 
            }else{
                
            }
        })
    }else{
        $(".menulateral li:first").addClass("active");
        $(".menulateral li:first").find("a").find("span.sr-only").html("(current)");
    }
    
  /*  $('.menulateral li').each(function () {
        var menuActual = $(this);
        
        if (menuPress == null) {
            alert("nada")
        } else {
            menuActual.removeClass("active");
            if (menuActual.attr("id") == menuPress) {
                menuActual.addClass("active");
            }
        }
    })*/
})

$('.menu-lateral-item').click(function () {
    var id = $(this).attr("id");
    AsignarMenu(id);
})

function AsignarMenu(idMenu){
    localStorage.setItem("menuLateral", idMenu);
    
    $(".menulateral li").each(function(){
        $(this).removeClass("active");
    })
  
    $("#" + idMenu + "").addClass("active");
    $("#" + idMenu + "").parent().find("a").append("<span class='sr-only'>(current)</span>")
}

