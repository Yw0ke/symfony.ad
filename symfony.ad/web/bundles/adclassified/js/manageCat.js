$('.tree li').each(function(){
        if($(this).children('ul').length > 0){	//Ajoute l'icone "+" aux parents.
                $(this).addClass('parent');
        }
});

$('.gclink li > a').click(function(){
	var attr = $(this).attr('href');
   	if(attr.length < 18){
	   		alert('Veuillez selectionner une catégorie avant !');	//Si un lien est clicé sans avoir au préalable sélectionner une catégorie
	   		return false;
       }
});

$('.tree li.parent > a').click(function(){
        $(this).parent().toggleClass('active');
        $(this).parent().children('ul').slideToggle('fast');	//Un clic sur un parent déclenche le slidetoggle de ses enfants.
});

var hrefs = [];
$('.gclink li > a').each(function(index){
	hrefs[index] =  $(this).attr("href").split('/');	//explosion des urls (liens de gestion de catégorie)
});

$('.treeLink li > a').click(function(){
	$('.treeLink li > a').each(function(){	//On retire le style "selected" de tout les liens.
		$(this).removeAttr("id");
	});
	$(this).attr('id', 'selected');		//Et on le rajoute sur celui sur lequel on viens de clicé.
	var txt = $(this).attr('data-slug');	//Ajout du slug pour le controller.
	$('.gclink li > a').each(function(index){
		$(this).attr('href', '/'+hrefs[index][1]+'/'+hrefs[index][2]+'/'+txt);	//recréation du lien.
	});
});