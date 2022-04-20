/**
 * gives a formatted string to display date
 * @param date
 * @returns {string}
 */
export function getDateString(date){
    if(!(date instanceof Date)) return '';
    return `${getRealNumber(date.getDate())}/${getRealNumber(date.getMonth() + 1)}/${getRealNumber(date.getFullYear())} ${getRealNumber(date.getHours())}:${getRealNumber(date.getMinutes())}:${getRealNumber(date.getSeconds())}`;
}

function getRealNumber(number){
    return number >= 10 ? number : `0${number}`;
}
