/**
 * Created by Victor on 19/03/2018.
 */

jQuery(document).ready(function ($) {
    $('.gfirem_webcam_admin').each(function () {

        var field_container = $(this).find("[data-action=store-snapshot-admin]"),
            identifier = field_container.attr('id');
        id = identifier.replace('field_', '');

        $("#height_"+id).change(function () {

            var height = $("#height_"+id).val();
            if(height> 450)
            {
                height = 450;
                $("#height_"+id).val(450);
                alert(" Heigth value must be less than 500");
            }
            var result = Math.ceil((height/1.5)*2);
            $("#width_"+id).val(result);
        })

        $("#width_"+id).change(function () {

            var width = $("#width_"+id).val();
            if(width > 450)
            {
                width = 450;
                $("#width_"+id).val(450);
                alert(" Width value must be less than 500");
            }
            var result = Math.ceil((width/2)* 1.5);
            $("#height_"+id).val(result);
        })

        });
});
