
export async function getData() {
    const URL = `https://fakestoreapi.com/products`
    const response = await fetch(URL)
    const json = await response.json()
    return json
}