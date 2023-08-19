$(document).ready(function(){
    var $monthly_consumption_category = $('#monthly_consumption_category');
    var $monthly_consumption_token = $('#monthly_consumption__token');
    
    $monthly_consumption_category.change(function (e) { 
        e.preventDefault();
        var $form = $(this).closest('form');
    
        var data = {};
    
        data[$monthly_consumption_token.attr('name')] = $monthly_consumption_token.val();
        data[$monthly_consumption_category.attr('name')] = $monthly_consumption_category.val();
        
        $.post($form.attr('action'), data).then(function (res) {
            console.log($(res).find('#monthly_consumption_sub_category'));
            $('#monthly_consumption_sub_category').replaceWith(
                $(res).find('#monthly_consumption_sub_category')
            );
          });
   });
});
