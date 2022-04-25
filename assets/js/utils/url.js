/**
 * Set an url param and update the url
 * @param name
 * @param value
 */
export function setUrlParam(name, value)
{
    if ('URLSearchParams' in window) {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set(name, value);
        const newRelativePathQuery = window.location.pathname + '?' + searchParams.toString();
        history.pushState(null, '', newRelativePathQuery);
    }
}

/**
 * Delete an url param and update the url
 * @param name
 */
export function deleteUrlParam(name)
{
    if ('URLSearchParams' in window) {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.delete(name);
        let newRelativePathQuery = window.location.pathname;
        if(searchParams.entries().length > 0){
            newRelativePathQuery = newRelativePathQuery + '?' + searchParams.toString();
        }
        history.pushState(null, '', newRelativePathQuery);
    }
}
