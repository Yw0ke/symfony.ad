$("#form_recherche").submit(function(){
    var motcle = $("#adsSearch_motcle").val();
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
