/**
 * Created by Victor on 19/03/2018.
 */

function changeHeigthRatio(id){

        var height = jQuery("#height_"+id).val();
        if(height> 450)
        {
            height = 450;
            jQuery("#height_"+id).val(450);
            alert(" Heigth value must be less than 500");
        }
        var result = Math.ceil((height/1.5)*2);
        jQuery("#width_"+id).val(result);


}

function changeWidthRatio(id){

        var width = jQuery("#width_"+id).val();
        if(width > 450)
        {
            width = 450;
            jQuery("#width_"+id).val(450);
            alert(" Width value must be less than 500");
        }
        var result = Math.ceil((width/2)* 1.5);
        jQuery("#height_"+id).val(result);
}

