function check_delete() {
    if (window.confirm("Do you want to delete it? Can't recover data ")) {
        return true;
    }

    return false;
}

new DataTable('#adminServiceTable');

$('#hideModalThongTin').click(function() {
    $('#exampleModal').modal('hide');
})