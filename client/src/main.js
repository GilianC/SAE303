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

}

let V = {
    header: document.querySelector("#header"),
    graph1: document.querySelector("#graph1"),
   
};

V.init = function(){
    V.renderHeader();
    V.renderGraph1();
    // V.renderGraph2Rental();
    // V.renderGraph2Sales();
    // V.renderGraph3Sales();
    // V.renderSelect();
    // V.renderGraph4Sales();
    // V.renderSelectRental();
    // V.renderGraph4Rental();
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
// V.renderGraph2Rental = async function( ){

//     let rental = await RentalData.listMapsByGenre();

//     let template =  Graph2View.render();
//     V.graph2Rental.innerHTML = template;  
//      Graph2View.renderChart( rental);
 

// }
// V.renderGraph2Sales = async function( ){

//     let sales = await SalesData.listMapsByGenre();
//     let template =  Graph2View.render();
//     V.graph2Sales.innerHTML = template;  
//      Graph2View.renderChart( sales);

// }
// V.renderGraph3Sales = async function( ){

//     let sales = await SalesData.listMapsByCountry();
//     let template =  Graph3View.render();
//     V.graph3.innerHTML = template;  
//      Graph3View.renderChart( sales);


// }
// V.renderSelect = async function( ){
//     let movies = await SalesData.fetchAllMovie();
//     let test =  SelectMovieView.render(movies);
//     V.graph4select.innerHTML = test;
// }
// V.renderGraph4Sales = async function( id ){
//     let movies = await SalesData.fetchMoviePerStat(id);
//     let template =  Graph4View.render();
//     V.graph4sales.innerHTML = template;  
//      Graph4View.renderChart( movies);
// }
// V.renderSelectRental = async function( ){
//     let movies = await RentalData.fetchAllMovie();
//     let test =  SelectMovieView.render(movies);
//     console.log(movies);
//     V.selectRental.innerHTML = test;  
// }
// V.renderGraph4Rental = async function( id ){
//     console.log(id);
//     let movies = await RentalData.fetchMoviePerStat(id);
//     let template =  Graph4View.render();
//     V.graph4rental.innerHTML = template;  
//      Graph4View.renderChart(movies);
// }


C.init(
    
);

