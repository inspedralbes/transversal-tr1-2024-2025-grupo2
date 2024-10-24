export async function getData() {
    const URL = '../back/data.json';
    const response = await fetch(URL);    
    if(!response.ok) {
        throw new Error("Error en la solicitud");
    }
    const json = await response.json();
    return json;
  }