$("#form_recherche").submit(function(){
    var motcle = $("#search-bar-text").val();
    $.ajax({
        type: "POST",
        url: "/ads/search/",
        data: { ajax: "on", title: motcle},
        cache: false,
        success: function(data){
           $('.ajxrfrsh').html(data);
        }
    });
    return false;
});
