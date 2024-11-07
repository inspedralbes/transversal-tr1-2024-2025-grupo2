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

export async function sendDataProducts(dataProducts) {
  console.log("Payload a enviar:", JSON.stringify(dataProducts));

  const URL = `http://localhost:8000/api/ordersApi`;
  try {
    const response = await fetch(URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(dataProducts)
    });

    const responseData = await response.json(); 
    console.log("Respuesta del servidor:", responseData);

  } catch (error) {
    console.error("Error al enviar los datos de los productos:", error);
  }
}

