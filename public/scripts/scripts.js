$(".menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
    if ($('#sidebar-button-icon').hasClass('glyphicon-arrow-left'))
    {
        $('#sidebar-button-icon').removeClass('glyphicon-arrow-left');
        $('#sidebar-button-icon').addClass('glyphicon-arrow-right');
    }
    else
    {
        $('#sidebar-button-icon').removeClass('glyphicon-arrow-right');
        $('#sidebar-button-icon').addClass('glyphicon-arrow-left');
    }
});

if($(window).width()<762){
    if ($('#sidebar-button-icon').hasClass('glyphicon-arrow-left'))
    {
        $('#sidebar-button-icon').removeClass('glyphicon-arrow-left');
        $('#sidebar-button-icon').addClass('glyphicon-arrow-right');
    }
    else
    {
        $('#sidebar-button-icon').removeClass('glyphicon-arrow-right');
        $('#sidebar-button-icon').addClass('glyphicon-arrow-left');
    }
}

$('.datepicker').datetimepicker(
    {
        timepicker: false,
        format: 'Y/m/d'
    }
);
$('.timepicker').datetimepicker(
    {
        datepicker:false,
        format: 'H:i'
    }
);


