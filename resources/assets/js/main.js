import Helper from './helper.js';
import Errors from './classes/Errors';
let errors = new Errors();
let preventable = false;

// LOGIN
$( "#login-form" ).submit(function( event ) {
    Helper.startLoading();
    errors.clear();
    let credentials = Helper.getFormResults(this);

    axios.post(base_api + '/login', credentials)
        .then(function (response) {
            console.log(response);
            Helper.endLoading();
            window.location.href = '/dashboard';
        })
        .catch(function (error) {
            Helper.endLoading();
            errors.record(error.response.data);
            errors.show();
        });

    event.preventDefault();

});

// LOGOUT
$("#btn-logout").on('click', function(evt) {
    $("#logout-form").submit();
});

$("#logout-form").submit(function(event) {

    let data = Helper.getFormResults(this);

    axios.post(base_api + '/logout', data)
        .then(function (response) {
            // window.location.href = '/';
        })
        .catch(function (error) {
            console.log(error);
        });

    event.preventDefault();

});

// SIGN UP
$( "#sign-up-form" ).submit(function( event ) {
    Helper.startLoading();
    errors.clear();
    let data = Helper.getFormResults(this);

    axios.post(base_api + '/register', data)
        .then(function (response) {
            Helper.endLoading();
            $('#sign-up-modal').modal('hide');
            window.location.href = '/';
        })
        .catch(function (error) {
            Helper.endLoading();
            errors.record(error.response.data.details);
            errors.show();

            console.log(errors);
        });

    event.preventDefault();

});

// INVITATION
$("#invitation-form").submit(function( event ) {
    Helper.startLoading();
    errors.clear();
    let data = Helper.getFormResults(this);

    axios.post(base_api + '/invitation/' + data['invitation'] + '/accept', data)
        .then(function (response) {
            Helper.endLoading();
            window.location.href = '/login';
        })
        .catch(function (error) {
            Helper.endLoading();
            errors.record(error.response.data.details);
            errors.show();

            console.log(errors);
        });
    event.preventDefault();
});



$('#login-modal').on('shown.bs.modal', function (e) {
    errors.clear();
});

$('#sign-up-modal').on('shown.bs.modal', function (e) {
    errors.clear();
});

/**
 * Clickable element
 */
$(document).on('click', '.clickable-row', function(){
    if(!preventable) {
        window.document.location = $(this).data("href");
    }
});

$(document).on('click', '.preventable', function(){
    preventable = true;
    setTimeout(function(){
        preventable = false;
    }, 100);
});




