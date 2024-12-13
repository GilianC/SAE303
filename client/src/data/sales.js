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

export {SalesData};
