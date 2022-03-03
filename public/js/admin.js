const csrf = document.head.querySelector('meta[name="csrf-token"]');
$(document).ready(function() {
    $('.table').on('click', '.delete', function () {
        console.log('clicked');
        $(this).closest('tr').addClass('remove');
        $('#deletePopup').attr('data-url', $(this).data('url'));
    });

    $('#deletePopup').on('click', 'button', function () {
        if ( $(this).hasClass('delete-item') ) {
            let url = $('#deletePopup').data('url');

            $.ajax({
                method: 'DELETE',
                url: url,
                data: {
                    _token: csrf.content
                },
                success: function(response){
                    if (response.status === 'success') {
                        $('#success #respMsg').text(response.message);
                        $('#success').modal('show');
                        $('.table tr.remove').remove();
                    }
                }
            })
        } else {
            $('.table tr.remove').removeClass('remove');
        }

    });
})
