$(document).ready(function () {

    $('#submit').click(function () {

        var date = $('#Eventbundle_evenement_dateDebutEvent').val();
        var date1 = $('#Eventbundle_evenement_dateFinEvent').val();

        var titre =$('#Eventbundle_evenement_titreEvent').val();

        var d1 = new Date(date);
        var d2 = new Date(date1);
        var d3=new Date();
        var image=$('#Eventbundle_evenement_file').val();
        var nb=$('#Eventbundle_evenement_nbPlaceEvent').val();
        if (titre.length===0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ titre',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if (image.length===0)
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
            });
            return false;

        }
        else if (date.length===0)
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
            });
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
            });
            return false;

        }
        else if (date1.length===0)
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
            });
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
            });
            return false;
        }

        else if (nb.length===0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ nombre de place',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else {

            swal({
                title: 'Congratulations!',
                text: 'ajout valide',
                icon: 'success',

            });
            return true;


        }
    });

});