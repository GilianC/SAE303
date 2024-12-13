

const templateFile = await fetch("./src/ui/Graph2/template.html");
const template = await templateFile.text();


let Graph2View = {
    render : function(){
        
        return  template;
    },
    renderChart: function( data1) {
    var monthValues = data1.get("Action").map(e => e.month);
    

     Highcharts.chart(document.querySelector("#container1"), {
        title: {
            text: 'Vente et location par genre',
            align: 'left'
        },
        yAxis: {
            title: {
                text: 'Total'
            }
        },
        xAxis: {
            categories:monthValues
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                }
            }
        },
        series: [{
            name: 'Action',
            data: data1.get("Action").map(e => parseFloat(e.total))
        }
        ,{
            name: 'Animation',
            data: data1.get("Animation").map(e => parseFloat(e.total))
        }
        ,{
            name: 'Comedy',
            data: data1.get("Comedy").map(e => parseFloat(e.total))
        },{
            name: 'Drama',
            data: data1.get("Drama").map(e => parseFloat(e.total))
        },{
            name: 'Horror',
            data: data1.get("Horror").map(e => parseFloat(e.total))
        },{
            name: 'Romance',
            data: data1.get("Romance").map(e => parseFloat(e.total))
        },{
            name: 'Sci-Fi',
            data: data1.get("Sci-Fi").map(e => parseFloat(e.total))
        },{
            name: 'Thriller',
            data: data1.get("Thriller").map(e => parseFloat(e.total))
        }
    ],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        justify: 'space-between'
                    }
                }
            }]
        }
    }).container;
    console.log(data1.get("Action").map(e => parseFloat(e.total)));
    }
};




export {Graph2View};


  