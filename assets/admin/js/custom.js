$(document).ready(function (){
    $('#dataTable').DataTable();
    $(document).on('change', '#role-filter', function () {
        window.location.href = $(this).find(':selected').data('url');
    });
});