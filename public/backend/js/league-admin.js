var LeagueAdmin = {

    init: function() {
        this.bindUIActions();
    },
    bindUIActions: function() {
        // Add new Input item
        $(document).on('click', '#delete_btn', function (e) {
            var thisObj = $(this);
            e.preventDefault();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = $(this).attr('href');
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        '_token': CSRF_TOKEN,
                        '_method': 'DELETE'
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        thisObj.closest('tr').remove();
                    }
                });
            }
            return false;
        });
    },
};