import { getData, getCategories, getSizes } from "./communicationManager.js";
import {
  createApp,
  reactive,
  ref,
  onBeforeMount,
  computed,
} from "https://unpkg.com/vue@3/dist/vue.esm-browser.js";

createApp({
  setup() {
    let laravel = reactive({ URL: "http://localhost:8000" });
    let templateData = reactive({ products: [], categories: [], sizes: [] });
    let selectedCategory = ref(null);
    let selectedSize = ref(null);
    let selectedProduct = reactive([]);
    let visibleFilter = ref(false);
    //let visible = ref('store');
    let cartItems = reactive([]);
    let objectsInCart = cartItems.length;
    let visible = ref("page-cover");
    const visibleButtons = ref("");
    let cartVisible = ref(false);

    /* function subTotalCart(){
             let total = ref('0');
 
             for (let i  = 0; i < cartItems.length; i++){
                 total =+ cartItems[i].price * cartItems[i].quantity;
             }
 
             return total;
         }*/

    function toggleFilterCategory() {
      visibleFilter.value = !visibleFilter.value;
    }

    function showCartFloat() {
      this.cartVisible = true;
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

    //filtrar productes segons la categoria

    const filteredProducts = computed(() => {
        
        return templateData.products.filter((product) => { // Múltiples filtros sobre la lista de productos
            // Condición para la categoría (solo si hay una categoría seleccionada)
            const categoryMatch = !selectedCategory.value || product.category_id === selectedCategory.value;
            // Condición para la talla (solo si hay una talla seleccionada)
            const sizeMatch = !selectedSize.value || product.size_id === selectedSize.value;   
            // Devolver el producto solo si cumplen cada condicion por separado
            return categoryMatch && sizeMatch;
        });
    });

    function showSelectedProduct(product) {
      this.selectedProduct = product;

      console.log(selectedProduct);

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

        console.log("Categorías:", templateData.categories);
        console.log("Categorías:", templateData.sizes);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
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
      selectedCategory,
      visibleFilter,
      toggleFilterCategory,
      selectedSize,
      filteredProducts
    };
  },
}).mount("#app");