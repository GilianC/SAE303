


const templateFile = await fetch("./src/ui/Graph4/template.html");
const template = await templateFile.text();


let Graph4View = {
    render : function(){
        
        return  template;
    },
    renderChart: function( data1) {
        console.log(data1);
        let name ;
        let month= [];
        let chiffre= [];
        for(let obj of data1){
            month.push(obj.month);
        name = obj.movie_title;
        chiffre.push(parseFloat(obj.total));
    }
    console.log(name);
    // const monthValues = data1.get("Action").map(e => e.month);
    Highcharts.chart(document.querySelector("#container3"), {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Vente par film',
            align: 'left'
        },
        xAxis: {
            categories: data1.map(e=>e.month)

        },
        yAxis: {
            title: {
                text: 'Nombre de ventes'
            }
        },
        tooltip: {
            pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>' +
                'warheads in {point.x}'
        },
        plotOptions: {
            area: {
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
        },
        series: [{
            name:name,
            data: chiffre
        }, ]
    }).container;
        console.log(chiffre);
        // console.log(data1.movie_title[1]);
    }
};




export {Graph4View};


  