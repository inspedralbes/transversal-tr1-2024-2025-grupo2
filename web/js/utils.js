import { getData } from './communicationManager.js'
import { createApp, reactive, ref, onBeforeMount } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        let laravel = reactive ({ URL: "http://localhost:8000"})
        let templateData = reactive({ products: [] });
        //let visible = ref('store');
        let selectedProduct = reactive([]);
        let cartItems = reactive([])
        let objectsInCart = cartItems.length;
        let visible = ref('page-cover');
        const visibleButtons = ref('');
        let cartVisible = ref(false);


        /* function subTotalCart(){
             let total = ref('0');
 
             for (let i  = 0; i < cartItems.length; i++){
                 total =+ cartItems[i].price * cartItems[i].quantity;
             }
 
             return total;
         }*/


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


            const exsistProductCar = cartItems.find(item => item.id == product.id);

            if (exsistProductCar) {
                exsistProductCar.quantity++;
            }
        }


        function discountProduct(product) {
            const exsistProductCar = cartItems.find(item => item.id == product.id);

            if (exsistProductCar) {
                exsistProductCar.quantity--;
                itemCartEmpty(exsistProductCar);
            }
        }

        function cancelPurchase() {
            this.cleanCart();
            this.changeDiv('store');
        }

        function deleteItemCart(product) {
            const productIndex = cartItems.findIndex(item => item.id === product.id);

            if (productIndex !== -1) {
                cartItems.splice(productIndex, 1);
            } else {
            }
        }


        function cleanCart() {
            cartItems.splice(0, cartItems.length)
        }

        function addToCart(product) {
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
                templateData.products = result;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        });

        return {
            templateData, changeDiv, visible, selectedProduct, showSelectedProduct, cartItems, addToCart, objectsInCart, cleanCart, laravel, deleteItemCart, cancelPurchase, visibleButtons, discountProduct, incrementProduct, itemCartEmpty, cartVisible, showCartFloat
        };
    }
}).mount('#app');