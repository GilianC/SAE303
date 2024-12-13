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

export {RentalData};