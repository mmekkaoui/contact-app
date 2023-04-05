import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';
import { useNotification } from "@kyvg/vue3-notification";

interface PhoneType {
    id: number;
    name: string;
}

interface Address {
    id: number;
    street: string;
    city: string;
    state: string;
    zip: string;
}

interface PhoneNumber {
    id: number;
    number: string;
    type_id: number;
}

interface User {
    id?: number;
    name: string;
    email: string;
    addresses: Address[];
    phone_numbers: PhoneNumber[];
}

interface Contact {
    data: User;
}

interface ApiResponse {
    status: string;
    message: string;
}

export default function useContacts() {
    const contacts = ref<Contact[]>([])
    const contact = ref<User>({} as User)
    const phoneTypes = ref<PhoneType[]>([])
    const router = useRouter()
    const errors = ref<string>('')
    const notification = useNotification()

    const getPhoneTypes = async () => {
        let response = await axios.get<PhoneType[]>('/api/phone-types')
        phoneTypes.value = response.data;
    }

    const getContacts = async () => {
        let response = await axios.get<Contact[]>('/api/contacts')
        contacts.value = response.data.data;
    }

    const getContact = async (id: number) => {
        let response = await axios.get<Contact>('/api/contacts/' + id)
        contact.value = response.data.data;
        contact.value.addresses = contact.value.addresses || [];
        contact.value.phone_numbers = contact.value.phone_numbers || [];
    }

    const storeContact = async (data: User) => {
        errors.value = ''
        axios.post<ApiResponse>('/api/contacts/', { user: data})
            .then(function(res){
                if (res.data.status === "success"){
                    notification.notify({
                        title: "Saved",
                        text: res.data.message,
                    });

                    router.push({name: 'contacts.index'})
                }else{
                    notification.notify({
                        title: "Error",
                        text: res.data.message,
                    });
                }
            })
            .catch(function(error){
                console.log(error);
                errors.value = error.response.data.errors || '';
            });
    }

    const updateContact = async (id: number) => {
        errors.value = ''
        axios.put<ApiResponse>('/api/contacts/' + id, { user: contact.value})
            .then(function(res){
                if (res.data.status === "success"){
                    notification.notify({
                        title: "Updated",
                        text: res.data.message,
                    });

                    router.push({name: 'contacts.index'})
                }else{
                    notification.notify({
                        title: "Error",
                        text: res.data.message,
                    });
                }
            })
            .catch(function(error){
                console.log(error);
                errors.value = error.response.data.errors || '';
            });
    }

    const destroyContact = async (id: number) => {
        await axios.delete('/api/contacts/' + id)
    }


    return {
        contacts,
        contact,
        errors,
        phoneTypes,
        getContacts,
        getContact,
        storeContact,
        updateContact,
        destroyContact,
        getPhoneTypes
    }
}