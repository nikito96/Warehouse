function deleteFunc(id) {
    var db = confirm("This product will be deleted. Would you like to continue?");
    if (db == true) {
        window.location.replace("delete.php?id="+id);
    }
}
