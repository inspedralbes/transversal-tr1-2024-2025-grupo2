export async function getData() {
    URL = 'https://fakestoreapi.com/products';
    const response = await fetch(URL);
    
    if(!response.ok) {
        throw new Error("Error en la solicitud");
    }
    const data = await response.json();
  
    return data;
  }