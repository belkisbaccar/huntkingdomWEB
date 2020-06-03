$(document).ready(function () {
    $('#submit').click(function () {

        var date = $('#huntkingdombundle_publicite_dateDebut').val();
        var date1 = $('#huntkingdombundle_publicite_dateFin').val();

        var nom =$('#huntkingdombundle_publicite_nom').val();
        var prix =$('#huntkingdombundle_publicite_prix').val();
        var d1 = new Date(date);
        var d2 = new Date(date1);
        var d3=new Date();
        var image=$('#huntkingdombundle_publicite_file').val();
        var nomP=$('#huntkingdombundle_publicite_nomProprietaire').val();
        if (nom.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ nom',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else if (image.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ Image',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else if (date.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ date debut',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else if (d1<d3)
        {
            swal({
                title: 'Error!',
                text: 'date debut inferieur a date aujourd\'hui',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else if (date1.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ date fin',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else if (d1>d2)
        {

            swal({
                title: 'Error!',
                text: 'date debut superieur a date fin ',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;
        }

        else if (prix.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ prix',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else if (nomP.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ Nom Proprietaire',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            })
            return false;

        }
        else {

            swal({
                title: 'Congratulations!',
                text: 'ajout valide',
                icon: 'success',

            })
            return true;


        }
    });


    $('.editbtn').on('click',function () {
        $('#editModal').modal('show');
        var modalImg = document.getElementById("img01");
        modalImg.src = this.src;
        var $row = $(this).closest("tr");    // Find the row
        var $text = $row.find("#nom_pub").text();
        document.getElementById("descrip").innerText="Nom de la Publicite : "+$text;
    });
    $('.notification').on('click',function () {
        $('#supp1').modal('show');
    })
    $("#example2").DataTable({
        aLengthMenu: [
            [1, 50, 100, 200, -1],
            [1, 50, 100, 200, "All"]
        ],
        aaSorting: [],
        responsive: true,
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }]
    });
    $("#example1").DataTable({
        aLengthMenu: [
            [1,5, 50, 100, 200, -1],
            [1,5, 50, 100, 200, "All"]
        ],
        aaSorting: [],
        responsive: true,
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }]
    });
});