$(document).ready(function () {
    var $region = $('#mcs_region');
    var $token = $('#mcs__token');

    $region.change(function (e) { 
        e.preventDefault();
        var $form = $(this).closest('form');
        var data = {};
        data[$token.attr('name')] = $token.val();
        data[$region.attr('name')] = $region.val();
        // console.log(data);
        $.post($form.attr('action'), data).then(function (res) {
            console.log(res);
            $('#mcs_location').replaceWith(
                $(res).find('#mcs_location')
            );
          });
    });
});