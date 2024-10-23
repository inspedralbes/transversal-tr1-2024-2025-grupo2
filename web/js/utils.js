import { getData } from './communicationManager.js'
import { createApp, reactive,ref, onBeforeMount} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        const templateData = reactive({ data: [] });
        //let visible = ref('store');
        let selectedProduct= ref(null);
        let cart = [];
        let objectsInCart = ref(0);
        let visible = ref('page-cover'); // Iniciamos mostrando la 'portada'
        const visibleButtons = ref('')

        function cancelPurchase() {
            this.cleanCart();
            this.changeDiv('store');
          }
      
          function deleteById(index) {
            this.cart.splice(index,1)
            this.objectsInCart--;
          }
      
          function cleanCart(){
            this.cart = [];
            this.objectsInCart = 0;
          }
      
          function addToCart(data) {
            this.objectsInCart++;
            this.cart.push(data);
          }
          
          function showSelectedProduct (data) {
            this.selectedProduct = data;
            this.changeDiv('productSelec');
          }

          function changeDiv(show) {
            this.visible = show;
            this.visibleButtons = 'buttons-menu';
          };

        onBeforeMount(async () => {
            try {
                const result = await getData();
                templateData.data = result;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        });

        return {
            templateData,changeDiv,visible,selectedProduct,showSelectedProduct, cart,addToCart,objectsInCart,cleanCart,deleteById,cancelPurchase,visibleButtons
        };
    }
}).mount('#app');