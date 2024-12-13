import { HeaderView } from "./ui/header/index.js";
import { Graph1View } from "./ui/Graph1/index.js";
import { Graph2View } from "./ui/Graph2/index.js";
import { Graph3View } from "./ui/Graph3/index.js";
import { Graph4View } from "./ui/Graph4/index.js";
import {SelectMovieView} from "./ui/Select-Ite8/index.js";
import { SalesData } from "./data/sales.js";
import { RentalData } from "./data/rental.js";
import './index.css';


let C = {

};

C.init = async function(){
    V.init();
    addEventListener("change", async function(e){
        if(e.target.id === "select"){
            let id = e.target.value;
            V.renderGraph4Sales(id);
        }
    });
    addEventListener("changeRent", async function(e){
        if(e.target.id === "selectrental"){
            let id = e.target.value;
            V.renderGraph4Rental(id);
        }
    });
}

let V = {
    header: document.querySelector("#header"),
    graph1: document.querySelector("#graph1"),
    graph2Rental: document.querySelector("#graph2rental"),
    graph2Sales: document.querySelector("#graph2sales"),

};

V.init = function(){
    V.renderHeader();
    V.renderGraph1();
    V.renderGraph2Rental();
    V.renderGraph2Sales();

}

V.renderHeader= function(){
    V.header.innerHTML = HeaderView.render();
   
}
V.renderGraph1 = async function( ){
        let sales = await SalesData.fetchForSixMonth();
        let rental = await RentalData.fetchForSixMonth();
        let template =  Graph1View.render();
        V.graph1.innerHTML = template;    
        Graph1View.renderChart(sales, rental);
    
}
V.renderGraph2Rental = async function( ){

    let rental = await RentalData.listMapsByGenre();

    let template =  Graph2View.render();
    V.graph2Rental.innerHTML = template;  
     Graph2View.renderChart( rental);
 

}
V.renderGraph2Sales = async function( ){

    let sales = await SalesData.listMapsByGenre();
    let template =  Graph2View.render();
    V.graph2Sales.innerHTML = template;  
     Graph2View.renderChart( sales);

}



C.init(
    
);

