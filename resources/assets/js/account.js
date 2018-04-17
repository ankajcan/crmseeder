window.base_api = '';
import Helper from './helper.js';
import Errors from './classes/Errors';
import swal from 'sweetalert';
let errors = new Errors();

/**
 * Update/create user
 */
$("#update-entity").submit(function( event ) {
    errors.clear();
    let data = Helper.getFormResults(this);
    Helper.startLoading();

    axios.put(base_api +'/account/update', data)
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            errors.record(error.response.data.details);
            errors.show();
            Helper.endLoading();
            toastr.error('Something went wrong')
        });

    event.preventDefault();
});

/**
 * Open user avatar upload dialog
 */
$("#btn-avatar-upload").on('click', function(evt) {
    $("#input-avatar-upload").click();
});

/**
 * Upload user avatar
 */
$("#input-avatar-upload").on('change', function(evt) {
    let files = evt.target.files;
    let formData = new FormData();
    formData.append('file',files[0]);
    let config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    };
    Helper.startLoading();
    axios.post(base_api + '/account/avatar-upload', formData, config)
        .then(response => {
            console.log(response.data);
            $("#avatar-container").html(response.data);
            Helper.endLoading();
        }).catch(function (error) {
        console.log(error);
        Helper.endLoading();
        toastr.error('Something went wrong')
    })

});
