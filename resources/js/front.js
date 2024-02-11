require('./bootstrap');
require('select2');
window.Swal = require('sweetalert2');
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
$(function() {

    $(document).on('click', '.dropdown-menu', function (e) {
      e.stopPropagation();
    });

    $('.js-check :radio').on('change', function () {
        var check_attr_name = $(this).attr('name');
        if ($(this).is(':checked')) {
            $('input[name='+ check_attr_name +']').closest('.js-check').removeClass('active');
            $(this).closest('.js-check').addClass('active');

        } else {
            item.removeClass('active');
        }
    });

    $('.js-check :checkbox').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.js-check').addClass('active');
        } else {
            $(this).closest('.js-check').removeClass('active');
        }
    });

	if($('[data-toggle="tooltip"]').length>0) {
		$('[data-toggle="tooltip"]').tooltip()
	}

});

