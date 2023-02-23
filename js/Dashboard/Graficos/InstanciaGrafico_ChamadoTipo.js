function InstanciaGrafico_ChamadoStatus(id){
    var ctx = document.getElementById(id).getContext("2d");
    var data = {
        datasets: [{
            data: [10, 20, 30],
            backgroundColor: [
                "rgb(134, 144, 145)",
                "rgb(0, 132, 255)",
                "#df2d2d",
                "rgb(255, 94, 0)",
                "rgb(255, 153, 0)",
            ]
        }],
        labels: [
            "Novo",
            "Aguardando Cliente",
            "Pendente",
            "Em Analise",
            "Aguardando ATT",
        ]
    };
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        title: {
            display: true,
            text: 'Status dos Chamados'
        },
        animation: {
            animateRotate: true,
            animateScale: true
        },
        legend: {
            display: false,
            position: 'top'
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                    var total = meta.total;
                    var currentValue = dataset.data[tooltipItem.index];
                    var percentage = parseFloat((currentValue/total*100).toFixed(1));
                    return currentValue + ' (' + percentage + '%)';
                },
                title: function(tooltipItem, data) {
                    return data.labels[tooltipItem[0].index];
                }
            }
        }
    };
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });
}