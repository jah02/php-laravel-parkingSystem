function calculateCurrentCostAndHours(vehicleType, arrivalTime) {
    let types = {
        'CAR': 1.0,
        'BUS': 1.1,
        'TRUCK': 1.5,
        'MOTORCYCLE': 0.7
    };
    let pricePerHour = 2.0;

    let arrivalDate = new Date(arrivalTime);
    let nowDate = new Date();

    let hours = Math.ceil(Math.abs(nowDate - arrivalDate) / 36e5);

    return {
        'cost': (hours * pricePerHour * types[`${vehicleType}`]).toFixed(2),
        'hours': hours,
    };
}

function calculateHours(arrivalTime, departureTime) {
    if(departureTime === arrivalTime) {
        return 1;
    } else {
        return Math.ceil(Math.abs(new Date(departureTime) - new Date(arrivalTime)) / 36e5);
    }
}
