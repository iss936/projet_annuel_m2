$(document).ready(function() {
    $('.table-responsive table').each(function(){
        var labels = [];
        $(this).find('thead th').each(function(){
            labels.push($.trim($(this).text()));
        });
        // console.log(labels)
        $(this).find('tbody tr').each(function(){
            $(this).find('td').each(function(index){
                $(this).attr('data-title', labels[index]);
            });
        });
    });
});
