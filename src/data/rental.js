import {getRequest} from '../lib/api-request.js';

let RentalData = {};

RentalData.fetchForSixMonth = async function () {
    let data = await getRequest("rental?param=rentalsixmonth")
    return data;
};
RentalData.fetchGenrePerMonth = async function() {
    let data = await getRequest('rental?param=rentalgenremonth');
    let sortedData = data.sort((a, b) => a.genre.localeCompare(b.genre));

    return sortedData;
};
RentalData.listMapsByGenre = async function() {
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
RentalData.fetchCountryPerMonth = async function() {
    let data = await getRequest('rental?param=rentalpercountry');
    let sortedData = data.sort((a, b) => a.country.localeCompare(b.country));

    return sortedData;
};
RentalData.listMapsByCountry = async function() {
    let data = await this.fetchCountryPerMonth();
    let countryMap = new Map();

    data.forEach(item => {
        if (!countryMap.has(item.country)) {
            countryMap.set(item.country, []);
        }
        countryMap.get(item.country).push(item);
    });

    return countryMap;
};


export {RentalData};