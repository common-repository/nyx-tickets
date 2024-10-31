jQuery(document).ready(function ($) {
    $(".my-color-field").spectrum();


    $(document).on('click', '#make-connection', function () {

        var data = {
            'action': 'nyx_fetch_data',
            //'nyx-refresh-interval' : $("#nyx-refresh-interval").val(),
            'nyx-api-key': $("#nyx-api-key").val(),
        };

        jQuery.post(ajaxurl, data, function (response) {

            //We passsed
            if ( response == 200 ) {

                Swal.fire({
                    title: 'Established connection!',
                    text: 'Connection to NYX Api was established, and events was fetched.',
                    icon: 'success',
                    confirmButtonColor: "#00d6d8",
                    confirmButtonText: 'OK',
                    toast: true
                })

            } else {

                Swal.fire({
                    title: 'Error on connection!',
                    text: 'There was an error connecting to the NYX API. Please try again or contact support.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: "#00d6d8",
                    toast: true
                })

            }

        });
    })
});