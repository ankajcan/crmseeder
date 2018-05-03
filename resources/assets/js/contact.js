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

    if(data['id'] !== undefined) { // UPDATE
        axios.put(base_api +'/contacts/'+ data['id'], data)
            .then(function (response) {
                console.log(response.data);
                location.reload();
            })
            .catch(function (error) {
                errors.record(error.response.data.details);
                errors.show();
                Helper.endLoading();
            });
    } else { // NEW
        axios.post(base_api +'/contacts', data)
            .then(function (response) {
                window.location.href = '/contacts';
            })
            .catch(function (error) {
                errors.record(error.response.data.details);
                errors.show();
                Helper.endLoading();
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
        text: "Once deleted, you will not be able to recover this contact!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                let entity_id = $(this).attr("data-entity-id");

                axios.delete(base_api + '/contacts/'+entity_id, {})
                    .then(function (response) {
                        window.location.href = '/contacts';
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });

});

/**
 * Type update
 */
$('select[name="type"]').on('change', function () {
    let input_first_name =  $('input[name="first_name"]');
    let input_name =  $('input[name="name"]');


    if($(this).val() == 2) { // If organisation
        $('.person-name-container').addClass('hidden');
        $('.organisation-name-container').removeClass('hidden');
        input_first_name.prop('required',false);
        input_name.prop('required',true);
    } else { // If person
        $('.person-name-container').removeClass('hidden');
        $('.organisation-name-container').addClass('hidden');
        input_first_name.prop('required',true);
        input_name.prop('required',false);
    }
});


/***********
 * File upload
 ************* /

/**
 * Open upload product photos dialog
 */
$("#btn-files-upload").on('click', function(evt) {
    $("#input-files-upload").click();
});

/**
 * Upload entity photo
 */
$("#input-files-upload").on('change', function(evt) {
    let files = evt.target.files;
    let formData = new FormData();
    formData.append('file',files[0]);
    let config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    };

    let entity_id = $(this).attr("data-entity-id");

    Helper.startLoading();
    axios.post(base_api + '/contacts/'+entity_id+'/file-upload', formData, config)
        .then(response => {

            $(".entity-photos").append(response.data);

            Helper.endLoading();
        }).catch(function (error) {
        console.log(error);
        Helper.endLoading();
    })
});

/**
 * Delete delete photo
 */
$(".btn-delete-file").on('click', function(evt) {

    let entity_id = $(this).attr("data-entity-id");

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                Helper.startLoading();
                axios.delete(base_api + '/assets/'+entity_id)
                    .then(response => {

                        $("#container-file-"+entity_id).remove();

                        Helper.endLoading();
                    }).catch(function (error) {
                    console.log(error);
                    Helper.endLoading();
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

    axios.get(base_api + '/contacts/search?'+query)
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


/**
 * Pagination
 */

function updatePage(page) {
    $("#search-form input[name='page']").val(page);
}

$(document).on('click', 'ul.pagination a', function(event){
    updatePage($(this).attr('data-page'));
    submitSearchForm();

    event.preventDefault();
});

/**
 * Checkbox
 */
let selected_entities = [];
$(document).on('change', 'input.entity-checkbox', function(event){
    updateSelectedEntities();
});

$(document).on('change', 'input.entity-checkbox-all', function(event){

    if($(this).is(':checked')) {
        $('input.entity-checkbox').prop('checked', true);
    } else {
        $('input.entity-checkbox').prop('checked', false);
    }

    updateSelectedEntities();

});

function updateSelectedEntities() {
    selected_entities = [];

    $('input.entity-checkbox').each(function () {
        if($(this).is(':checked')) {
            selected_entities.push($(this).attr('data-entity-id'));
        }
    });

    // UPDATE HTML
    $('.selected-entities').html(selected_entities.length);

    if(selected_entities.length > 0) {
        $('.checkbox-action').removeClass('hidden');
    } else {
        $('.checkbox-action').addClass('hidden');
    }
}

/**
 * Delete selected entities
 */

$(document).on('click', '#btn-entities-delete', function(){

    console.log(selected_entities);

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover selected contacts!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                Helper.startLoading();
                axios.put(base_api + '/contacts/delete', { ids: selected_entities})
                    .then(response => {
                        // location.reload();
                        Helper.endLoading();
                    }).catch(function (error) {
                    console.log(error);
                    toastr.error('Something went wrong');
                    Helper.endLoading();
                });
            }
        });

});


/**
 * Update/create note
 */
$("#update-note").submit(function( event ) {
    errors.clear();
    let data = Helper.getFormResults(this);
    Helper.startLoading();

    if(data['id'] !== undefined && data['id'] !== "") { // UPDATE
        axios.put(base_api +'/notes/'+ data['id'], data)
            .then(function (response) {
                $('#note-update-modal').modal('hide');
                $(".notes-container").html(response.data.data);
                Helper.endLoading();
            })
            .catch(function (error) {
                errors.record(error.response.data.details);
                errors.show();
                Helper.endLoading();
            });
    } else { // NEW
        axios.post(base_api +'/notes', data)
            .then(function (response) {
                $('#note-update-modal').modal('hide');
                $(".notes-container").html(response.data.data);
                Helper.endLoading();
            })
            .catch(function (error) {
                errors.record(error.response.data.details);
                errors.show();
                Helper.endLoading();
            });
    }

    event.preventDefault();
});

$("#btn-note-add").click(function() {
    // Clear modal
    $("#update-note [name='id']").val("");
    $("#update-note [name='title']").val("");
    $("#update-note [name='content']").val("");
    // Open modal
    $('#note-update-modal').modal('show');
});

$(document).on('click', '.btn-note-edit', function(){
    let entity = JSON.parse($(this).attr('data-entity'));
    // Fill modal
    $("#update-note [name='id']").val(entity.id);
    $("#update-note [name='title']").val(entity.title);
    $("#update-note [name='content']").val(entity.content);
    // Open modal
    $('#note-update-modal').modal('show');
});

$(document).on('click', '.btn-note-delete', function(){
    let entity_id = $(this).attr('data-entity-id');

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this note!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                Helper.startLoading();
                axios.delete(base_api + '/notes/'+entity_id)
                    .then(response => {
                        $("#container-note-"+entity_id).remove();
                        Helper.endLoading();
                    }).catch(function (error) {
                    console.log(error);
                    Helper.endLoading();
                });
            }
        });

});


