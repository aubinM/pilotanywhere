// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTable').DataTable({

        "language": {

            "sProcessing": "Traitement en cours...",
            "sSearch": "Rechercher&nbsp;:",
            "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix": "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            },
            "oAria": {
                "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            },
            buttons: {
                selectAll: "Tout séléctionné",
                selectNone: "Tout Désélectionné"
            },
            select: {
            rows: {
                _: "%d lignes séléctionnées",
                0: "Cliquer sur une ligne pour séléctionné",
                1: "1 ligne séléctionnée"
            }
        }
        },
        "bDeferRender": true,
        fixedHeader: {
            header: true,
            headerOffset: -10
        },
        select: {
            style: 'multiple'
        },
        colReorder: true,

        "dom": "<'row'<'col-md-5'B><'col-md-4'l><'col-md-4'f>><'row'<'col-md-12't>><'row'<'col-md-3'i><'col-md-6'><'col-md-3'p>>",
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    rows: {selected: true}
                }
            },
            'excel',
            {
                text: "Selection page",
                action: function (e, dt, button, config) {
                    dt.rows({page: 'current'}).select();
                }
            },
            'selectAll',
            'selectNone'
        ],
        "lengthMenu": [25, 10, 50, 75, 100],
        scrollY:        400,
        scrollCollapse: true,
        scroller:       true


    });
});

