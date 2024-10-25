import { getData } from './communicationManager.js'
import { createApp, reactive, ref, onBeforeMount } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        let templateData = reactive({ products: [] });
        //let visible = ref('store');
        let selectedProduct = reactive([]);
        let cartItems = reactive([])
        let objectsInCart = ref(0);
        let visible = ref('page-cover');
        const visibleButtons = ref('')

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
        }

        function showSelectedProduct(product) {
            selectedProduct.push({ ...product });


            console.log(selectedProduct);

            this.changeDiv('productSelec');
        }

        function changeDiv(show) {
            this.visible = show;
            this.visibleButtons = 'buttons-menu';
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
        });

        return {
            templateData, changeDiv, visible, selectedProduct, showSelectedProduct, cartItems, addToCart, objectsInCart, cleanCart, deleteItemCart, cancelPurchase, visibleButtons
        };
    }
}).mount('#app');