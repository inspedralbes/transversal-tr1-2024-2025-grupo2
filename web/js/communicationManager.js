let laravel = { URL: 'http://localhost:8000' }

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

export async function sendPayment(itemsToSend) {

  console.log(itemsToSend);

  const URL = `${laravel.URL}/api/create-payment`
  const response = await fetch(URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(itemsToSend),
  });

  // console.log(response);

  if (!response.ok) {
    console.error("Error al crear la sesión de pago:", response.statusText);
    return;
  }

  return response
}

