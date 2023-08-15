var $district = $('#product_district');
var $token = $('#product__token');

$district.change(function (e) { 
    e.preventDefault();
    var $form = $(this).closest('form');

    var data = {};

    data[$token.attr('name')] = $token.val();
    data[$district.attr('name')] = $district.val();
    
    $.post($form.attr('action'), data).then(function (res) {
        $('#product_village').replaceWith(
            $(res).find('#product_village')
        );
      });
});