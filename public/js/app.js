$(document).ready(function () {
    // loadApp();
})

function loadApp() {
    Chart.defaults.global.defaultFontFamily = 'Lato';
    // Chart.defaults.global.defaultFontSize = '12';
    Chart.defaults.global.defaultFontColor = '#777';
    loadGraph('graph1');
}

function loadGraph(id) {
    $('#' + id).html('loading...');
    $.ajax({
        url: '/chart',
        cache: false,
        dataType: "json",
    }).done(function (data) {
        let myChart = document.getElementById(id).getContext('2d');
        let masPopChart = new Chart(myChart, data);
        // $('#' + id).html(data);
    });

}
