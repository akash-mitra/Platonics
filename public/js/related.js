/*
 * Supporting script for the "related" module
 * 
 */ 

 var populateRelatedPagesModule = function (data)
 {
     var target = $('.related-module'), 
        html = '', cnt = data.count, pages = data.pages;

     for (var i=0; i<cnt; i++) {
         html += '<li class="list-group-item"><a href="' + pages[i].url + '">' + pages[i].title + '</a></li>';
     }

     target.html('<ul class="list-group list-group-flush">' + html + '</ul>')
 }


 $(document).ready(function () {
     var mod = $('.related-module');
     var category = mod.data('category-id'), count = mod.data('max-count'),
        param = {
         "to": "/api/v1/get/pages/related/" + category + '/' + count,
         "before": function () {},
         "success": function (data) { populateRelatedPagesModule (data) },
         "error": function (data) { console.log(data) }
     };

     makeAjaxRequest(param);
 });