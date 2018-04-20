/*
 * @package WordPress
 * @subpackage Formidable, gfirem
 * @author GFireM
 * @copyright 2017
 * @link http://www.gfirem.com
 * @license http://www.apache.org/licenses/
 *
 */
jQuery(document).ready(function ($) {


    $( "form" ).submit(function( event ) {
        $('.buddyform_webcam').each(function () {

            var current = $(this),
				url = current.attr('url'),
                id = current.attr('id'),
                height = current.attr('height'),
                width = current.attr('width'),
                fps = current.attr('fps'),
                quality = current.attr('quality');

                //$('#buddyform_webcam_button_' + id).click();
                //$('#buddyform_webcam_button_' + id).click();
               // var field_value = $('#field_' + id).val();




		})

    });

	$('.buddyform_webcam').each(function () {

        var current = $(this),
            id = current.attr('id'),
            height = current.attr('height'),
			width = current.attr('width'),
			fps = current.attr('fps'),
			action = current.attr('action'),
			quality = current.attr('quality');



		//var autoscaling = Math.ceil( (gfirem_webcam.config[identifier].width/2) *1.5);
		Webcam.set({
			width: width,
			height: height,
			image_format: 'jpeg',
			jpeg_quality: quality,
			fps	: fps,
            flip_horiz: true
		});
		Webcam.attach('#my_camera_' + id);
		if (action && action === 'edit' ) {
			$('#my_camera_' + id).hide();
		}
		$('#buddyform_webcam_button_' + id).click(function (e) {

			if (action && action === 'edit' || action === 'update') {
				$('#snap_container_'+id).hide();
				$('#my_camera_' + id).show();
			}


			Webcam.snap(function (data_uri) {

				// display results in page
				$('#field_' + id).val(data_uri);
			});
			// freeze camera so user can preview pic
            Webcam.freeze();

			// swap button sets
			var tt = $("#pre_take_buttons");
			document.getElementById('pre_take_buttons').style.display = 'none';
			document.getElementById('post_take_buttons').style.display = '';
            $("#webcam_take_another_"+id).val('Take Another');
		});
		$('#buddyform_webcam_take_another_' + id).click(function (e) {

			// cancel preview freeze and return to live camera feed
			Webcam.unfreeze();

			// swap buttons back
			document.getElementById('pre_take_buttons').style.display = '';
			document.getElementById('post_take_buttons').style.display = 'none';
		});

	});
});
