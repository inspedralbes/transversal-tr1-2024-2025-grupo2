export async function getData() {
  const URL = "http://localhost:8000/api/getProducts";
  const response = await fetch(URL);
  if (!response.ok) {
    throw new Error("Error en la solicitud");
  }
  const json = await response.json();
  return json;
}

export async function getCategories() {
  const URL = "http://localhost:8000/api/getCategories";
  const response = await fetch(URL);
  if (!response.ok) {
    throw new Error("Error en la solicutd de categorías");
  }
  const json = await response.json();

  return json;
}

export async function getSizes() {
  const URL = "http://localhost:8000/api/getSizes";
  const response = await fetch(URL);
  if (!response.ok) {
    throw new Error("Error en la solicutd de categorías");
  }
  const json = await response.json();
  return json;
}

