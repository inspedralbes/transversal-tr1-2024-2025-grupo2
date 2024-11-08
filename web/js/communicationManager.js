let laravel = { URL: 'http://localhost:8000'}

export async function getData() {
  const URL = `${laravel.URL}/api/getProducts`;
  const response = await fetch(URL);
  if (!response.ok) {
    throw new Error("Error en la solicitud");
  }
  const json = await response.json();
  return json;
}

export async function getCategories() {
  const URL = `${laravel.URL}/api/getCategories`;
  const response = await fetch(URL);
  if (!response.ok) {
    throw new Error("Error en la solicutd de categorías");
  }
  const json = await response.json();
  
  return json;
}

export async function getSizes() {
  const URL = `${laravel.URL}/api/getSizes`;
  const response = await fetch(URL);
  if (!response.ok) {
    throw new Error("Error en la solicutd de categorías");
  }
  const json = await response.json();
  return json;
}

