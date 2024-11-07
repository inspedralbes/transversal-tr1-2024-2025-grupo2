import { getData, getCategories, getSizes, sendDataProducts } from "./communicationManager.js";

import { createApp, reactive, ref, onBeforeMount, watch} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        let laravel = reactive({ URL: "http://localhost:8000" })
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

        watch(isMenuOpen, (newValue) => {
            if (newValue) {
                // Cuando el menú se abre, bloqueamos el scroll
                document.body.classList.add('menu-open');
            } else {
                // Cuando el menú se cierra, restauramos el scroll
                document.body.classList.remove('menu-open');
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
            visibleFilter.value = false
        }


        function showCartFloat() {
            if (this.visible === 'store' || this.visible === 'productSelec') {
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


            const exsistProductCar = cartItems.find(item => item.id == product.id);

            if (exsistProductCar) {
                exsistProductCar.quantity++;
                console.log(cartItems)
            }
        }


        function discountProduct(product) {

            console.log("El objeto que se quiere reducir es " + product.id)

            const exsistProductCar = cartItems.find(item => item.id == product.id);

            if (exsistProductCar) {
                exsistProductCar.quantity--;
                console.log(cartItems)
                itemCartEmpty(exsistProductCar);
            }
        }

        function cancelPurchase() {
            console.log('Carrito compra rapida: ', cartItems);

            this.cleanCart();
            this.changeDiv('store');
        }

        function deleteItemCart(product) {
            console.log('Id del producto: ', product.id); // Mostrar el id del producto
            console.log('Producto que se quiere eliminar', cartItems.find(item => item.id === product.id)); // Mostrar el producto que se quiere eliminar
            console.log('Productos totales que hay en el objeto', cartItems); // Mostrar todos los productos en el carrito

            const productIndex = cartItems.findIndex(item => item.id === product.id);

            if (productIndex !== -1) {
                console.log('Producto encontrado en el índice:', productIndex);
                cartItems.splice(productIndex, 1);
                console.log('Producto eliminado correctamente.');
            } else {
                console.log('Producto no encontrado en el carrito.');
            }
            console.log('Productos restantes en el carrito:', cartItems); // Mostrar productos restantes en el carrito
        }


        function cleanCart() {
            cartItems.splice(0, cartItems.length)
        }



        function addToCart(product) {

            console.log('Carro actual: ', cartItems);

            const exsistProductCar = cartItems.find(item => item.id == product.id)

            if (exsistProductCar) {
                exsistProductCar.quantity++ 
            } else {
                cartItems.push({
                    ...product,
                    quantity: 1
                })
            }
            this.showCartFloat();
        }

        function getFilterProducts() {
            const result = templateData.products.filter((product) => {
                // Condición para la categoría (solo si hay una categoría seleccionada)
                const categoryMatch = !selectedCategory.value || product.category_id === selectedCategory.value;
                // Condición para la talla (solo si hay una talla seleccionada)
                const sizeMatch = !selectedSize.value || product.size_id === selectedSize.value;
                return categoryMatch && sizeMatch;
            });
            return result
        }

        function resetFilters() {
            selectedCategory.value = null;
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
            if (this.visible !== 'page-cover') {
                this.visibleButtons = 'buttons-menu';
            } else {
                this.visibleButtons = '';
            }
        }

        function prepareObject(items) {
            console.log("Objeto dentro de prepareObject", items);

            if (!Array.isArray(items)) {
                items = [items]
                console.log("Dentro de la condicion si es un array", items);
            }

            // Usar map para crear un nuevo array con las modificaciones
            const finalItems = items.map(item => {
                const newItem = { ...item }
                // delete newItem.id
                delete newItem.price
                delete newItem.image
                delete newItem.description
                delete newItem.category_id
                delete newItem.category
                delete newItem.size_id
                delete newItem.size
                delete newItem.updated_at
                delete newItem.created_at
                delete newItem.title
                return newItem;
            });

            console.log("Objeto final en prepareObject", finalItems);
            return finalItems;
        }

        function sendData(itemsBuy) {
            console.log("Items dentro de send data", itemsBuy);

            let finalItems = prepareObject(itemsBuy)
            let products = {products: finalItems }      // Actualiza la orden con el precio total

            console.log("Log de finalItems en sendData", products);
            sendDataProducts(products)

            cleanCart()
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

        function continuePurchase() {
            visible.value = 'purchase-form'; // Muestra el formulario al continuar
        }

        function submitForm() {
            console.log("Formulario enviado");
            visible.value = 'purchase-completed'; ; // Vuelve a la vista de compra completada
            cleanCart();
        }

        // FUNCIONES DE LOGIN Y REGISTER

        function showLogin() {
            visible.value = 'login-form';
        }

        function showRegister() {
            visible.value = 'register-form';
        }

        function backToPurchaseForm() {
            visible.value = 'purchase-form'; // Para regresar al formulario de compra
        } 

        function login() {
            console.log('Iniciar sesión con:', {
                email: document.getElementById('login-email').value,
                password: document.getElementById('login-password').value
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
        return {
            templateData, changeDiv, visible, selectedProduct, showSelectedProduct, cartItems, addToCart, objectsInCart, cleanCart, laravel, deleteItemCart, cancelPurchase, visibleButtons, discountProduct, incrementProduct, itemCartEmpty, cartVisible, showCartFloat, subTotalCart, isMenuOpen, continuePurchase, showForm, submitForm, showLogin, showRegister, backToPurchaseForm, login, register, selectedCategory, visibleFilter, toggleFilterCategory, selectedSize, resetFilters, hiddenFilter, getFilterProducts, sendData
        };
    }
}).mount('#app');