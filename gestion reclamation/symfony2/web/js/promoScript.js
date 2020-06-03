$(document).ready(function () {
    $('#submit3').click(function () {

        var date = $('#huntkingdombundle_promotion_dateDebut').val();
        var date1 = $('#huntkingdombundle_promotion_dateFin').val();


        var d1 = new Date(date);
        var d2 = new Date(date1);
        var d3=new Date();

        if (date.length==0)
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


        else {

            swal({
                title: 'Congratulations!',
                text: 'ajout valide',
                icon: 'success',

            })
            return true;


        }
    });

})