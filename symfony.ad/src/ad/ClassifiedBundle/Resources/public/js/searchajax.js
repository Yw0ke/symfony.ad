$("#form_recherche").submit(function(){
    var motcle = $("#search-bar-text").val();
    var category = $("#search-bar-category").val();
    $.ajax({
        type: "POST",
        url: "/ads/search/",
        data: { ajax: "on", title: motcle, category: category},
        cache: false,
        success: function(data){
           $('.ajxrfrsh').html(data);
        }
    });
    return false;
});
