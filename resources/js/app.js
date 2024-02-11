require('./bootstrap');

/**
 * Vendor
 */
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
window.Dropzone = require('dropzone');
require('datatables.net-bs4');
require('datatables.net-buttons-bs4');
require('select2');
require('summernote');

require('./stisla/stisla');
require('./stisla/scripts');
require('./stisla/custom');
