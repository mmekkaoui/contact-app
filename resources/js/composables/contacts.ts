import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';
import { useNotification } from "@kyvg/vue3-notification";

interface PhoneType {
    id: number;
    type: string;
}

interface Address {
    id: number;
    address_line: string;
    pincode: string;
}

interface PhoneNumber {
    id: number;
    phone_number: string;
    phone_type_id: number;
}

interface User {
    id?: number;
    name: string;
    email: string;
    addresses: Address[];
    phone_numbers: PhoneNumber[];
}

interface Contact {
    id: number,
    user: User;
}

interface ApiResponse {
    status: string;
    message: string;
}

export default function useContacts() {
    const contacts = ref<Contact[]>([])
    const contact = ref<Contact>({
        user: {
            name: "",
            email: "",
            phone_numbers: [],
            addresses: []
        }
    } as Contact)
    const phoneTypes = ref<PhoneType[]>([])
    const router = useRouter()
    const errors = ref<string>('')
    const notification = useNotification()

    const getPhoneTypes = async () => {
        let response = await axios.get<PhoneType[]>('/api/phone-types')
        phoneTypes.value = response.data.data;
    }

    const getContacts = async () => {
        let response = await axios.get<Contact[]>('/api/contacts')
        contacts.value = response.data.data;
    }

    const getContact = async (id: number) => {
        await axios.get<Contact>('/api/contacts/' + id).then(res => {
            contact.value = res.data.data;
        }).catch(res => {
            console.log(res);
        })
    }

    const storeContact = async (data: User) => {
        errors.value = ''
        axios.post<ApiResponse>('/api/contacts/', { user: data })
            .then(function (res) {
                notification.notify({
                    title: "Saved",
                    text: res.data.message,
                });

                router.push('/dashboard')
            })
            .catch(function (error) {
                console.log(error);
                errors.value = error.response.data.errors || '';
            });
    }

    const updateContact = async (id: number) => {
        errors.value = ''
        const data = {
            ...contact.value,
            user: {
                ...contact.value.user,
                phone_numbers: contact.value.user.phone_numbers.map(_item => ({ id: _item.id, phone_number: _item.phone_number, phone_type_id: _item.phone_type_id }))
            }
        }

        axios.put<ApiResponse>('/api/contacts/' + id, data)
            .then(function (res) {
                notification.notify({
                    title: "Updated",
                    text: res.data.message,
                });

                router.push('/dashboard')
            })
            .catch(function (error) {
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