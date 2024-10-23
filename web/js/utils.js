import { getData } from './communicationManager.js'
import { createApp, reactive,ref, onBeforeMount} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
  setup() {
    
    const templateData = reactive({data: []});


    //- - - - - - - -  VARIABLEESSSS - - - - - - - 

    let visible = ref('store');
    let selectedProduct= ref(null);
    let cart = [];
    let objectsInCart = ref(0);
    /*let counterOfSameProduct = ref(0);
    let sameProduct = ref(true);*/

    onBeforeMount(async () => {
      try{
        const result = await getData();
        templateData.data = result;
      }catch(error) {
          console.error('Error fetching data: ', error);
      }
    })

    // - - - - - - - - - - FUNCIONES - - - - - - - - - - -

    /*function incrementCounterSameProducts() {
      this.counterOfSameProduct++;
    }*/

    /*function sameSelectedProduct(data) {
      sameProduct = this.selectedProduct.id === data.id;
    }*/

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
    };
    // - - - - - - - - - - RETUUUURN - - - - - - - - - - - - -

    return {
      templateData,changeDiv,visible,selectedProduct,showSelectedProduct, cart,addToCart,objectsInCart,cleanCart,deleteById,cancelPurchase
    }
  }
}).mount('#app');