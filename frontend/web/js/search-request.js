$(document).ready(function () {
    $(document).on('change', '#ingredient-select', function () {
        var searchResult = $('#search-result');
        var selectedIds = $(this).val();
        if(selectedIds.length < 2){
            searchResult.html('<p class="text-warning">Выберите больше 2-x ингредиентов</p>');
            return;
        }

        $.ajax({
            url: '/site/search',
            type: 'post',
            data: {'selected': selectedIds},
            dataType: 'JSON',
            success: function(data){
                console.log(data.result);
                if (data.status === 'ok') {
                    $('#search-result').html(data.result);
                } else {
                    $('#search-result').html('<p class="text-danger">Возникла ошибка</p>');
                }
            }
        });
    });
});