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
        $('.gfirem_webcam').each(function () {

            var field_container = $(this).find("[data-action=store-snapshot]"),
                identifier = field_container.attr('id');
            id = identifier.replace('field_', '');
            var submit_photo =  gfirem_webcam.config[identifier].submmit_photo == "true" ? true : false;
            if(submit_photo){
                $('#webcam_button_' + id).click();
			}

		})
    });

	$('.gfirem_webcam').each(function () {

        var current = $(this),
            id = current.attr('id'),
            height = current.attr('height'),
			width = current.attr('width'),
			fps = current.attr('fps'),
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
		/*if (gfirem_webcam.action && (gfirem_webcam.action === 'edit' || gfirem_webcam.action === 'update')) {
			$('#my_camera_' + id).hide();
		}*/
		$('#webcam_button_' + id).click(function (e) {

			/*if (gfirem_webcam.action && (gfirem_webcam.action === 'edit' || gfirem_webcam.action === 'update')) {
				$('#snap_container_'+id).hide();
				$('#my_camera_' + id).show();
			}*/


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
		$('#webcam_take_another_' + id).click(function (e) {

			// cancel preview freeze and return to live camera feed
			Webcam.unfreeze();

			// swap buttons back
			document.getElementById('pre_take_buttons').style.display = '';
			document.getElementById('post_take_buttons').style.display = 'none';
		});

	});
});
