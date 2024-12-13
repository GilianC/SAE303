

const templateFile = await fetch("./src/ui/Graph1/template.html");
const template = await templateFile.text();


let Graph1View = {
    render : function(){

        return  template;
    },
    renderChart: function( data1,data2) {

    var dat1 = data1.map(e=>parseFloat(e.total));
        var dat2 = data2.map(e=>parseFloat(e.total));
    var month = data1.map(e=>e.purchase_month);


   
   Highcharts.chart(document.querySelector("#container"), {

        title: {
            text: 'Vente comparé à la location',
            align: 'left'
        
        },
    
        yAxis: {
            title: {
                text: 'Total'
            }
        },
    
        xAxis: {
            categories: month,
            accessibility: {
                rangeDescription: 'Range: 2010 to 2016'
            }
        },
    
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
    
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: true
                }
            }
        },
    
        series: [{
            name: 'Rental',
            data: dat1
        }, {
            name: 'Sales',
            data: dat2
        } ],
    
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
                        justify : 'space-between'
                    }
                }
            }]
        }
    
    }).container;
    console.log(dat1);
    console.log(dat2);
    console.log(month);
      
    }
};




export {Graph1View};


  