/**
 * Gives the readable error message
 * @param error
 * @returns {string}
 */
export default function getRealErrorMessage(error){
    return error.response ? error.response.data.detail : error.toString();
}
