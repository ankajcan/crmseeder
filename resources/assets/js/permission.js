window.base_api = '';
import Helper from './helper.js';
import Errors from './classes/Errors';
import swal from 'sweetalert';
let errors = new Errors();

/**
 * Update/create entity
 */
$("#update-entity").submit(function( event ) {
    errors.clear();
    let data = Helper.getFormResults(this);
    Helper.startLoading();

    if(data['id'] !== undefined) { // UPDATE
        axios.put(base_api +'/permissions/'+ data['id'], data)
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
        axios.post(base_api +'/permissions', data)
            .then(function (response) {
                window.location.href = '/permissions';
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
 * Delete entity
 */
$("#btn-delete-entity").on('click', function(evt) {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this permission!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                let entity_id = $(this).attr("data-entity-id");

                axios.delete(base_api + '/permissions/'+entity_id, {})
                    .then(function (response) {
                        window.location.href = '/permissions';
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });

});




