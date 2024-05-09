import {ref} from 'vue';
export function useFetch(){
    const loading = ref(false);
    const data = ref([]);
    const error = ref(null);
    const fetchData = async (url, header)=>{
        data.value = [];
        error.value = null;
        loading.value = true;
        try{
            const response = await fetch(url, header);
            data.value = await response.json();
        }
        catch(err){
            error.value = err.toString();
        }
        finally{
            loading.value = false;
        }
    } 
    return { loading , data , error , fetchData}
}

