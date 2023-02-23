function InstanciaGrafico_ProjetosStatus(id){
    var ctx = document.getElementById(id).getContext("2d");
    var data = {
        datasets: [{
            data: [10, 20, 30],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
            ]
        }],
        labels: [
            "Nova",
            "Doc. Analise",
            "Ag. Aprovação Analise",
            "Triagem/Análise",
            "Execução",
            "Pronta para Teste",
            "Em Teste",
            "Aguardando Commit",
            "Atualizando Manuais"
        ]
    };
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        title: {
            display: true,
            text: 'Projetos Status'
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