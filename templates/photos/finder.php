<script>
    $(function () {
        $('#search').keyup(function (event) {
            findPhotos($('#search').val());
        });
    });
    function findPhotos(title_to_find) {
        var url = '<?php echo $this->generateUrl('photo', 'find_photos'); ?>';
        $.ajax({
                url: url,
                type: "get",
                data: {'title': title_to_find},
                dataType: 'html'
            })
            .done(function (response) {
                $('#data').html(response);
            })
            .fail(function (xhr) {
                $('#data').text('Wystąpił problem przy ładowaniu obrazków');
            });
    }

</script>

Title: <input type="text" id="search" placeholder="type here to find photos"/>
<br/>
Photos:
<div id="data">

</div>