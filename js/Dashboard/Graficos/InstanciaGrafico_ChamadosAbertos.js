function InstanciaGrafico_ChamadosAbertos(id){
    var ctx = document.getElementById(id).getContext("2d");
    var data = {
        labels: ["Gsat", "BrasilRisk", "Upper","TJ","CargoPolo","Atlas","Apisul"],
        datasets: [{
            label: ["Analise"],
            data: [12,32,7,6,2,1,0],
            backgroundColor: '#e32f21'
        },
        {
            label: ["Em Atendimento"],
            data: [3,3,2,1,0,0,0],
            backgroundColor: '#1b66ff'
        },
        {
            label: ["Projetos"],
            data: [7,2,6,1,0,0,0],
            backgroundColor: '#412a9c'
        },
        {
            label: ["Infraestrutura"],
            data: [0,0,0,0,0,1,0],
            backgroundColor: '#f76157'
        }],
    };
    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
    });
}