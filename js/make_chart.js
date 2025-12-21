
function CreaChartStat(chart_id, json_p1, json_p2, legend) {

    const ctx = document.getElementById(chart_id);

    var datasets = [];

    if (json_p1 != undefined) {
        datasets.push(
            {
                label: json_p1.player.nome,
                data: [
                    getValore(json_p1.statistiche, "Precisione"),
                    getValore(json_p1.statistiche, "Colpo Critico"),
                    getValore(json_p1.statistiche, "Letalita`"),
                    getValore(json_p1.statistiche, "Astuzia"),
                    getValore(json_p1.statistiche, "Penetrazione"),
                    getValore(json_p1.statistiche, "Armatura"),
                    getValore(json_p1.statistiche, "Vitalita`")
                ],
                fill: true,
                backgroundColor: 'rgba(184, 177, 115, 0.2)',
                borderColor: 'rgb(184, 177, 115)',
                pointBackgroundColor: 'rgb(184, 177, 115)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(184, 177, 115)'
            }
        );
    }

    if (json_p2 != undefined) {
        datasets.push(
            {
                label: json_p2.player.nome,
                data: [
                    getValore(json_p2.statistiche, "Precisione"),
                    getValore(json_p2.statistiche, "Colpo Critico"),
                    getValore(json_p2.statistiche, "Letalita`"),
                    getValore(json_p2.statistiche, "Astuzia"),
                    getValore(json_p2.statistiche, "Penetrazione"),
                    getValore(json_p2.statistiche, "Armatura"),
                    getValore(json_p2.statistiche, "Vitalita`")
                ],
                fill: true,
                backgroundColor: 'rgba(120, 151, 197, 0.2)',
                borderColor: 'rgb(120, 151, 197)',
                pointBackgroundColor: 'rgb(120, 151, 197)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(120, 151, 197)'
            }
        );
    }

    const dataChart = {
        labels: [
            'Precisione',
            'Colpo Critico',
            'Letalità',
            'Astuzia',
            'Penetrazione',
            'Armatura',
            'Vitalità'
        ],
        datasets: datasets
    }

    return new Chart(ctx, {
        type: 'radar',
        data: dataChart,
        options: {
            responsive: false,
            elements: {
                line: {
                    borderWidth: 2
                }
            },
            plugins: {
                legend: {
                    display: legend,
                },
            },
            scales: {
                r: {
                    ticks: {
                        stepSize: 50,
                        textStrokeColor: 'rgb(54, 162, 235)',
                        color: 'rgba(240, 240, 240, 0.5)',
                        //callback: function () { return "" },
                        backdropColor: "rgba(0, 0, 0, 0)"
                    },
                    angleLines: {
                        color: 'rgba(240, 240, 240, 0.2)',
                    },
                    grid: {
                        color: 'rgba(240, 240, 240,0.2)',
                    },
                    suggestedMin: 0,
                    //suggestedMax: 500,
                },
            }
        }
    });
}

function CreaChartDmg(chart_id, json_p1, json_p2) {

    const ctx = document.getElementById(chart_id);

    var datasets = [];

    if (json_p1 != undefined && json_p2 != undefined) {
        datasets.push(
            {
                data: [
                    parseFloat($("#arma_princ_1").text()) + parseFloat(isNull($("#arma_sec_1").text(), '0')),
                    parseFloat($("#arma_princ_2").text()) + parseFloat(isNull($("#arma_sec_2").text(), '0')),
                ],
                backgroundColor: ['rgba(184, 177, 115, 0.2)', 'rgba(120, 151, 197, 0.2)'],
                fill: true,
                borderColor: ['rgb(184, 177, 115)', 'rgb(120, 151, 197)'],
                hoverOffset: 0
            }
        );
    }

    const dataChart = {
        labels: [
            json_p1.player.nome, json_p2.player.nome
        ],
        datasets: datasets
    }

    return new Chart(ctx, {
        type: 'bar',
        data: dataChart,
        options: {
            elements: {
                bar: {
                    borderWidth: 2
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Danni',
                    position: 'bottom',
                    font: {
                        size: 16,
                        family: "'DejaVu Sans Mono', monospace",
                    },
                },
            },
            scales: {
                display: false,
                x: {
                    border: {
                        display: false
                    },
                    grid: {
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                },
                y: {
                    border: {
                        display: false
                    },
                    grid: {
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                }
            }
        }
    });
}
