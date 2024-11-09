import {
  getData,
  getCategories,
  getSizes,
  sendPayment
} from "./communicationManager.js";

import {
  createApp,
  reactive,
  ref,
  computed,
  onBeforeMount,
  watch,
  watchEffect
} from "https://unpkg.com/vue@3/dist/vue.esm-browser.js";

createApp({
  setup() {
    let laravel = reactive({ URL: "http://localhost:8000" });
    let templateData = reactive({ products: [], categories: [], sizes: [] });
    let selectedProduct = reactive([]);
    let selectedCategory = ref(null);
    let selectedSize = ref(null);
    let visibleFilter = ref(false);
    let cartItems = reactive([]);
    let objectsInCart = cartItems.length;
    let visible = ref("page-cover");
    const visibleButtons = ref("");
    let cartVisible = ref(false);
    let showForm = ref(false);
    const isMenuOpen = ref(false);
    let searchQuery = ref("");

    watch(isMenuOpen, (newValue) => {
      if (newValue) {
        // Cuando el menú se abre, bloqueamos el scroll
        document.body.classList.add("menu-open");
      } else {
        // Cuando el menú se cierra, restauramos el scroll
        document.body.classList.remove("menu-open");
      }
    });

    function subTotalCart() {
      let total = 0;
      for (let i = 0; i < this.cartItems.length; i++) {
        total += this.cartItems[i].price * this.cartItems[i].quantity;
      }

      return total.toFixed(2);
    }

    function toggleFilterCategory() {
      visibleFilter.value = !visibleFilter.value;
    }

    function hiddenFilter() {
      visibleFilter.value = false;
    }

    function showCartFloat() {
      if (this.visible === "store" || this.visible === "productSelec") {
        this.cartVisible = true;
      } else {
        this.cartVisible = false;
      }
    }

    function itemCartEmpty(itemCart) {
      if (itemCart.quantity > 0) {
        return true;
      } else {
        deleteItemCart(itemCart);
      }
    }

    function incrementProduct(product) {
      const exsistProductCar = cartItems.find((item) => item.id == product.id);

      if (exsistProductCar) {
        exsistProductCar.quantity++;
        console.log(cartItems);
      }
    }

    function discountProduct(product) {
      console.log("El objeto que se quiere reducir es " + product.id);

      const exsistProductCar = cartItems.find((item) => item.id == product.id);

      if (exsistProductCar) {
        exsistProductCar.quantity--;
        console.log(cartItems);
        itemCartEmpty(exsistProductCar);
      }
    }

    function cancelPurchase() {
      console.log("Carrito compra rapida: ", cartItems);

      this.cleanCart();
      this.changeDiv("store");
    }

    function deleteItemCart(product) {
      console.log("Id del producto: ", product.id); // Mostrar el id del producto
      console.log(
        "Producto que se quiere eliminar",
        cartItems.find((item) => item.id === product.id)
      ); // Mostrar el producto que se quiere eliminar
      console.log("Productos totales que hay en el objeto", cartItems); // Mostrar todos los productos en el carrito

      const productIndex = cartItems.findIndex(
        (item) => item.id === product.id
      );

      if (productIndex !== -1) {
        console.log("Producto encontrado en el índice:", productIndex);
        cartItems.splice(productIndex, 1);
        Swal.fire({
          title: '',
          text: `El producte s'ha eliminat de la cistella`,
          timer: 3000,
          icon: 'error',
          showConfirmButton: false,
          position: 'bottom-end',
          toast: true,
          background: '#333',
          color: '#fff',
          timerProgressBar: true,
          width: '400px' 
        })
        console.log("Producto eliminado correctamente.");
      } else {
        console.log("Producto no encontrado en el carrito.");
      }
      console.log("Productos restantes en el carrito:", cartItems); // Mostrar productos restantes en el carrito
    }

    function cleanCart() {
      cartItems.splice(0, cartItems.length);
    }

    //Stripe

    async function handlePayment() {

      const showStripeItems = cartItems.map((item) => ({
        title: item.title, 
        price: parseFloat(item.price),
        quantity: item.quantity || 1,
      }));

      const items = cartItems.map((item) => ({
        id: item.id,
        quantity: item.quantity || 1,
      }))

      const itemsToSend = { products: showStripeItems, items: items }

      const response = await sendPayment(itemsToSend)

      const { id: sessionId } = await response.json();

      const stripe = Stripe(
        "pk_test_51QHYFvFLWcZi7m5YpsCaNI5INLqB7m6dnhpWfuOTYNL4VUJZi4KPu9aMJBnlCt2dJsBTlgm2TrDWam0jbGQQmxjh00QEwVpkLq"
      );
      const { error } = await stripe.redirectToCheckout({ sessionId });

      if (error) {
        console.error("Error al redirigir a Checkout:", error);
      } else {
        window.location.href = `${laravel.URL}/succes`;
      }
    }

    function addToCart(product) {
      console.log("Carro actual: ", cartItems);

      const exsistProductCar = cartItems.find((item) => item.id == product.id);

      if (exsistProductCar) {
        exsistProductCar.quantity++;
      } else {
        cartItems.push({
          ...product,
          quantity: 1,
        });
      }
      this.showCartFloat();
      Swal.fire({
        title: '',
        text: `El producte s'ha afegit a la cistella`,
        timer: 3000,
        icon: 'success',
        showConfirmButton: false,
        position: 'bottom-end',
        toast: true,
        background: '#333',
        color: '#fff',
        timerProgressBar: true,
        width: '400px' 
      })
    }

    // Filtrar productos por categoría
    function getFilterProducts() {
      const result = templateData.products.filter((product) => {
        // Condición para la categoría
        const categoryMatch =
          !selectedCategory.value ||
          product.category_id === selectedCategory.value;
        // Condición para la talla
        const sizeMatch =
          !selectedSize.value || product.size_id === selectedSize.value;
        return categoryMatch && sizeMatch;
      });
      return result;
    }

    // Función para obtener el número de productos por categoría
    function categoryProduct() {
      const counts = {};
      templateData.products.forEach((product) => {
        counts[product.category_id] = (counts[product.category_id] || 0) + 1;
      });
      return counts;
    }

    // Contar las tallas disponibles en los productos de la categoría seleccionada
    function sizeProduct() {
      const counts = {};
      let filteredProducts = [];

      // Si no se ha seleccionado categoría, contamos las tallas de todos los productos
      if (selectedCategory.value === null) {
        filteredProducts = templateData.products;
      } else {
        filteredProducts = filteredCategoryProducts.value;
      }

      filteredProducts.forEach((product) => {
        counts[product.size_id] = (counts[product.size_id] || 0) + 1;
      });
      return counts;
    }

    // Variable reactiva para mantener la copia estática de productos filtrados por categoría
    const filteredCategoryProducts = ref([]);

    // Esta función actualizará la copia de los productos filtrados por categoría
    function updateCategoryFilter() {
      if (selectedCategory.value !== null) {
        filteredCategoryProducts.value = templateData.products.filter(
          (product) => product.category_id === selectedCategory.value
        );
      }
    }

    const filteredProducts = computed(() => {
      let result = getFilterProducts();
      //aqui aplicamos el filtro de busqueda en base a searchQuery

      if (searchQuery.value) {
        selectedCategory.value = null
        selectedSize.value = null
        result = result.filter((product) =>
          product.title.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
      }

      return result;
    });


    //esta funcion actualiza searchQuery que automaticamente reactiva a filteredProducts
    function filteredProductsBySearch() {
      searchQuery.value = searchQuery.value.trim();
    }

    const categoryProductCount = computed(() => categoryProduct());
    const sizeProductCount = computed(() => sizeProduct());

    function resetFilters() {
      selectedCategory.value = null;
      selectedSize.value = null;
      searchQuery.value = null
    }

    function resetFilterSize() {
      selectedSize.value = null;
    }

    function showSelectedProduct(product) {
      console.log("Log del producto seleccionado: ", product);

      this.selectedProduct = product;

      console.log("Select product log", selectedProduct);

      this.changeDiv("productSelec");
    }

    function changeDiv(show) {
      this.visible = show;
      if (this.visible !== "page-cover") {
        this.visibleButtons = "buttons-menu";
      } else {
        this.visibleButtons = "";
      }
    }

    onBeforeMount(async () => {
      try {
        const [productsResult, categoriesResult, sizeResult] =
          await Promise.all([getData(), getCategories(), getSizes()]);

        templateData.products = productsResult;
        templateData.categories = categoriesResult;
        templateData.sizes = sizeResult;

        console.log("Template data:", templateData);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    });

    // Detectar cambios en la categoría seleccionada
    watchEffect(() => {
      updateCategoryFilter();
    });

    watch([selectedCategory, selectedSize], ([newCategory, newSize]) => {
      if (newCategory || newSize) {
        searchQuery.value = ''
      }
    });


    function continuePurchase() {
      visible.value = "purchase-form"; // Muestra el formulario al continuar
    }

    function submitForm() {
      console.log("Formulario enviado");
      visible.value = "purchase-completed"; // Vuelve a la vista de compra completada
      cleanCart();
    }

    function redirectToCrud() {
      window.location.href = 'http://127.0.0.1:8000/products'
    }

    // FUNCIONES DE LOGIN Y REGISTER

    function showLogin() {
      visible.value = "login-form";
    }

    function showRegister() {
      visible.value = "register-form";
    }

    function backToPurchaseForm() {
      visible.value = "purchase-form"; // Para regresar al formulario de compra
    }

    function login() {
      console.log("Iniciar sesión con:", {
        email: document.getElementById("login-email").value,
        password: document.getElementById("login-password").value,
      });
    }

    function register() {
      console.log('Registrar con:', {
        name: document.getElementById('reg-name').value,
        surname: document.getElementById('reg-surname').value,
        phone: document.getElementById('reg-phone').value,
        email: document.getElementById('reg-email').value,
        password: document.getElementById('reg-password').value
      });
    }

    function alertPayment() {
      const URL = window.location.search;
      const paramURL = URL.split("=");

      if (paramURL[1] == 0) {
        Swal.fire({
          title: '',
          text: 'La compra ha sigut cancel·lada',
          timer: 3000,
          icon: 'error',
          showConfirmButton: false,
          position: 'top-end',
          toast: true,
          background: '#333',
          color: '#fff',
          timerProgressBar: true,
          width: '300px' 
        })
      } else if (paramURL[1] == 1) {
        Swal.fire({
          title: '',
          text: 'La compra ha sigut realitzada',
          timer: 3000,
          icon: 'success',
          showConfirmButton: false,
          position: 'top-end',
          toast: true,
          background: '#333',
          color: '#fff',
          timerProgressBar: true,
          width: '300px' 
        })
      }
    }

    alertPayment()
    return {
      templateData,
      changeDiv,
      visible,
      selectedProduct,
      showSelectedProduct,
      cartItems,
      addToCart,
      objectsInCart,
      cleanCart,
      laravel,
      deleteItemCart,
      cancelPurchase,
      visibleButtons,
      discountProduct,
      incrementProduct,
      itemCartEmpty,
      cartVisible,
      showCartFloat,
      subTotalCart,
      isMenuOpen,
      continuePurchase,
      showForm,
      submitForm,
      showLogin,
      showRegister,
      backToPurchaseForm,
      login,
      register,
      selectedCategory,
      visibleFilter,
      toggleFilterCategory,
      selectedSize,
      resetFilters,
      hiddenFilter,
      getFilterProducts,
      filteredProducts,
      handlePayment,
      searchQuery,
      categoryProductCount,
      sizeProductCount,
      filteredProductsBySearch,
      resetFilterSize,
      redirectToCrud

    };
  }
}).mount('#app');