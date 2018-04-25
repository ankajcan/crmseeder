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

    if(data['id'] != undefined) { // UPDATE USER
        axios.put(base_api +'/users/'+ data['id'], data)
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
                errors.record(error.response.data.details);
                errors.show();
                Helper.endLoading();
                toastr.error('Something went wrong')
            });
    } else { // NEW USER
        axios.post(base_api +'/users', data)
            .then(function (response) {
                window.location.href = '/users';
            })
            .catch(function (error) {
                errors.record(error.response.data.details);
                errors.show();
                Helper.endLoading();
                toastr.error('Something went wrong')
            });
    }

    event.preventDefault();
});

/**
 * Delete user
 */
$("#btn-delete-entity").on('click', function(evt) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this user!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            let entity_id = $(this).attr("data-entity-id");

            axios.delete(base_api + '/users/'+entity_id, {})
                .then(function (response) {
                    window.location.href = '/users';
                })
                .catch(function (error) {
                    console.log(error);
                    toastr.error('Something went wrong')
                });
        }
    });

});

/**
 * Search
 */
let inputTypingTimer;
$('#search-form input[name="search"]').on('keyup', function () {
    clearTimeout(inputTypingTimer);
    inputTypingTimer = setTimeout(function() {
        submitSearchForm({reset_pagination: true});
        },300);
});
$('#search-form input[name="search"]').on('keydown', function () {
    clearTimeout(inputTypingTimer);
});

$("#search-form").submit(function( event ) {
    Helper.startLoading();
    let data = Helper.getFormResults(this);
    let query = Helper.encodeQueryData(data);

    window.history.pushState("ajax", "Search", base_api + '?'+query);

    axios.get(base_api + '/users/search?'+query)
        .then(function (response) {
            $('.list-container').html(response.data);
            Helper.endLoading();
        })
        .catch(function (error) {
            Helper.endLoading();
        });

    event.preventDefault();
});

function submitSearchForm(options = {}) {

    if(options.reset_pagination) {
        updatePage(1);
    }

    $( "#search-form").submit();
}

function updatePage(page) {
    $("#search-form input[name='page']").val(page);
}

/**
 * Pagination
 */
$(document).on('click', 'ul.pagination a', function(event){
    updatePage($(this).attr('data-page'));
    submitSearchForm();

    event.preventDefault();
});



/**
 * Invite user
 */
$("#invite-entity").submit(function( event ) {
    errors.clear();
    let data = Helper.getFormResults(this);
    Helper.startLoading();

    axios.post(base_api +'/users/invite', data)
        .then(function (response) {
            window.location.href = '/users';
        })
        .catch(function (error) {
            errors.record(error.response.data.details);
            errors.show();
            Helper.endLoading();
            toastr.error('Something went wrong')
        });

    event.preventDefault();
});