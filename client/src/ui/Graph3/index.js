

const templateFile = await fetch("./src/ui/Graph3/template.html");
const template = await templateFile.text();


let Graph3View = {
    render : function(){
        
        return  template;
    },
    renderChart: function( data1) {
    // const monthValues = data1.get("Action").map(e => e.month);

    Highcharts.chart(document.querySelector("#container2"), {
        chart: {
            type: 'column',
            width:700,
            height:500
            
        },
        title: {
            text: 'Vente et location par pays',
            align: 'left'
        },
        xAxis: {
            categories: data1.get("Sales").map(e=>e.country),
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nombre de ventes et de locations'
            },
            stackLabels: {
                enabled: true
            }
        },
        legend: {
            width: 100,
            height: 100,
            align: 'left',
            x: 70,
            verticalAlign: 'top',
            y: 70,
            floating: true,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false,
            itemWidth: 120, // Largeur des éléments de la légende
            width: 500, // Largeur totale de la div légende
            maxHeight: 100 // Hauteur maximale
        },
        tooltip: {
            headerFormat: '<b>{category}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: "Rentals",
        data: data1.get("Rentals").map(e=>parseFloat(e.total))
    }, {
        name: "Sales",
        data: data1.get("Sales").map(e=>parseFloat(e.total))
    }
        ]
    }).container;
    console.log(data1.get("Sales").map(e=>parseFloat(e.total)));
    }
};




export {Graph3View};


  