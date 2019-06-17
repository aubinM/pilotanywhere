/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var comment = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body #comment').val(comment)

})


$('#exampleModal').on('show.bs.modal', function (event) {
    var my_id_value = $(event.relatedTarget).data('id');
    $(".modal-body #hiddenValue").val(my_id_value);
})

