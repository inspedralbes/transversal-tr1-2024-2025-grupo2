import { getData, getCategories, getSizes } from "./communicationManager.js";
import {
  createApp,
  reactive,
  ref,
  onBeforeMount,
  computed,
  watchEffect,
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
    let searchQuery = ref("");

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
        console.log("Producto eliminado correctamente.");
      } else {
        console.log("Producto no encontrado en el carrito.");
      }
      console.log("Productos restantes en el carrito:", cartItems); // Mostrar productos restantes en el carrito
    }

    function cleanCart() {
      cartItems.splice(0, cartItems.length);
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
      selectedCategory,
      visibleFilter,
      toggleFilterCategory,
      selectedSize,
      resetFilters,
      hiddenFilter,
      filteredProducts,
      categoryProductCount,
      sizeProductCount,
      resetFilterSize,
      searchQuery,
      filteredProductsBySearch
    };
  },
}).mount("#app");
