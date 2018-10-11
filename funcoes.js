function trocar(n) {
    if (n === true) {
        $(".Login").show(300);
        $(".Register").hide(300);  
    }
    else{
        $(".Login").hide(300);
        $(".Register").css({"visibility":"visible"});
        $(".Register").show(300);
    }                                        
}