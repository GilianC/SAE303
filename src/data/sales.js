import { getRequest } from '../lib/api-request.js';

let SalesData = {};

SalesData.fetchForSixMonth = async function () {
    let data = await getRequest("sales?param=salessixmonth")
    
    return data;
};
SalesData.fetchGenrePerMonth = async function() {
    let data = await getRequest('sales?param=salesgenremonth');
    let sortedData = data.sort((a, b) => a.genre.localeCompare(b.genre));

    return sortedData;
}
SalesData.listMapsByGenre = async function() {
    let data = await this.fetchGenrePerMonth();
    let genreMap = new Map();

    data.forEach(item => {
        if (!genreMap.has(item.genre)) {
            genreMap.set(item.genre, []);
        }
        genreMap.get(item.genre).push(item);
    });

    return genreMap;
};
SalesData.fetchCountryPerMonth = async function() {
    let data = await getRequest('sales?param=salespercountry');
    let sortedData = data.sort((a, b) => a.type.localeCompare(b.type));

    return sortedData;
}
SalesData.listMapsByCountry = async function() {
    let data = await this.fetchCountryPerMonth();
    let TypeMap = new Map();

    data.forEach(item => {
        if (!TypeMap.has(item.type)) {
            TypeMap.set(item.type, []);
        }
        TypeMap.get(item.type).push(item);
    });

    return TypeMap;
};

SalesData.fetchAllMovie = async function() {
    let data = await getRequest('sales?param=salesmoviestat');
    return data;
};
SalesData.fetchMoviePerStat = async function(id) {
    let data = await getRequest('sales?id='+id);
    return data;
};

export {SalesData};