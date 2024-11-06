import { getData } from './communicationManager.js'
import { createApp, reactive, ref, onBeforeMount,watch } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        let laravel = reactive({ URL: "http://localhost:8000" })
        let templateData = reactive({ products: [] });
        //let visible = ref('store');
        let selectedProduct = reactive([]);
        let cartItems = reactive([])
        let objectsInCart = cartItems.length;
        let visible = ref('page-cover');
        const visibleButtons = ref('');
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

        function showSelectedProduct(product) {
            this.selectedProduct = product


            console.log(selectedProduct);

            this.changeDiv('productSelec');
        }

        function changeDiv(show) {
            this.visible = show;
            if (this.visible !== 'page-cover') {
                this.visibleButtons = 'buttons-menu';
            } else {
                this.visibleButtons = '';
            }
        };

        onBeforeMount(async () => {
            try {
                const result = await getData();
                console.log(result);

                templateData.products = result;
                console.log(templateData.products);

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        })

        function continuePurchase() {
            this.visible = 'purchase-form'; // Muestra el formulario al continuar
        }

        function submitForm() {
            console.log("Formulario enviado");
            visible.value = 'purchase-completed'; // Vuelve a la vista de compra completada
            cleanCart();
        }


        onBeforeMount(async () => {
            try {
                const result = await getData();
                templateData.products = result;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        })

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
            })
        }
        
        return {
            templateData, changeDiv, visible, selectedProduct, showSelectedProduct, cartItems, addToCart, objectsInCart, cleanCart, laravel, deleteItemCart, cancelPurchase, visibleButtons, discountProduct, incrementProduct, itemCartEmpty, cartVisible, showCartFloat, subTotalCart, continuePurchase, showForm, submitForm, showLogin, showRegister, backToPurchaseForm, login, register,isMenuOpen
        };
    }
}).mount('#app');