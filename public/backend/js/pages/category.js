var Category = {

    addCategoryBtn: $('#add_cat_btn'),
    completeCategoryBtn: $('.Category-complete-btn'),
    CategoryTemplate: '<div class="col-sm-4 m-b input-wrap"> \
                            <input type="text" class="form-control rounded input-lg" name="name[]"> \
                            <a href="#" id="delete_cat_btn" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> \
                       </div>',

    init: function() {
        this.bindUIActions();
    },
    bindUIActions: function() {
        // Add new Category item
        this.addCategoryBtn.click(function () {
            $('div.input-wrap:last').after(Category.CategoryTemplate);
            var newCategory = $('div.input-wrap:last');
            newCategory.find('input[type=text]:first').focus();
            return false;
        });
        $(document).on('click', '#delete_cat_btn', function (e) {
            if($(this).parent().is(':first-child')){
                $(this).parent().find('input[type=text]').val('');
                return;
            };
            $(this).parent().remove();
            return false;
        });
        // Set Category as complete via AJAX
        this.completeCategoryBtn.change(function () {
            var h3 = $(this).parent().parent().parent().parent().find('h3');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = '/schedules/update-Category';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: $(this).attr('id'),
                    complete: $(this).is(':checked')? 1 : 0,
                    '_token': CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function (data) {
                    h3.find('span').remove();
                    h3.append(data.status_label);
                }
            });
            return false;
        });
        // Delete Category via AJAX
        $(document).on('click', '#delete_btn', function (e) {
            e.preventDefault();
            var categoryWrapper = $(this).closest('tr');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = $(this).attr('href');
            if (confirm('Are you sure you want to delete this Category?')) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        '_token': CSRF_TOKEN,
                        '_method': 'DELETE'
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        categoryWrapper.remove();
                    }
                });
            }
            return false;
        });
    },
};