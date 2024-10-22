import { createApp,ref, reactive, onBeforeMount } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';
import { getData } from './comunicationManager.js';

createApp({
    setup() {
        const templateData = reactive({ data: [] });

        const currentDiv = ref('page-cover') // Iniciamos mostrando la 'portada'

        function showSection(divName) { // Función para cambiar el div mostrado
            currentDiv.value = divName
            console.log(currentDiv);
            
        }

        onBeforeMount(async () => {
            try {
                const result = await getData();
                templateData.data = result;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        });

        return {
            templateData, currentDiv, showSection
        };
    }
}).mount('#app');
