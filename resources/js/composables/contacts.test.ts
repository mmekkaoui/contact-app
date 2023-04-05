import { test, expect } from 'vitest';
import { ref } from 'vue';
import axios from 'axios';
import useContacts from './contacts';

test('useContacts', async () => {
    // Mock axios
    const axiosGet = jest.spyOn(axios, 'get');
    const axiosPost = jest.spyOn(axios, 'post');
    const axiosPut = jest.spyOn(axios, 'put');
    const axiosDelete = jest.spyOn(axios, 'delete');

    // Set up test data
    const contacts = [
        {
            data: {
                id: 1,
                name: 'John Doe',
                email: 'johndoe@example.com',
                addresses: [],
                phone_numbers: [],
            },
        },
        {
            data: {
                id: 2,
                name: 'Jane Doe',
                email: 'janedoe@example.com',
                addresses: [],
                phone_numbers: [],
            },
        },
    ];
    const contact = {
        id: 1,
        name: 'John Doe',
        email: 'johndoe@example.com',
        addresses: [],
        phone_numbers: [],
    };
    const phoneTypes = [{id: 1, name: 'Mobile'}, {id: 2, name: 'Home'}];
    const router = {push: jest.fn()};
    const errors = ref('');
    const notification = {notify: jest.fn()};

    // Set up composable
    const {
        contacts: resultContacts,
        contact: resultContact,
        phoneTypes: resultPhoneTypes,
        getContacts,
        getContact,
        storeContact,
        updateContact,
        destroyContact,
        getPhoneTypes,
    } = useContacts();

    // Test getPhoneTypes
    axiosGet.mockResolvedValueOnce({data: phoneTypes});
    await getPhoneTypes();
    expect(resultPhoneTypes.value).toEqual(phoneTypes);

    // Test getContacts
    axiosGet.mockResolvedValueOnce({data: {data: contacts}});
    await getContacts();
    expect(resultContacts.value).toEqual(contacts);

    // Test getContact
    axiosGet.mockResolvedValueOnce({data: {data: contact}});
    await getContact(1);
    expect(resultContact.value).toEqual(contact);

    // Test storeContact
    const responseSuccess = {data: {status: 'success', message: 'Contact saved'}};
    axiosPost.mockResolvedValueOnce(responseSuccess);
    await storeContact(contact);
    expect(axiosPost).toHaveBeenCalledWith('/api/contacts/', {user: contact});
    expect(notification.notify).toHaveBeenCalledWith({title: 'Saved', text: 'Contact saved'});
    expect(router.push).toHaveBeenCalledWith({name: 'contacts.index'});

    const responseError = {data: {status: 'error', message: 'Contact not saved'}};
    axiosPost.mockResolvedValueOnce(responseError);
    await storeContact(contact);
    expect(axiosPost).toHaveBeenCalledWith('/api/contacts/', {user: contact});
    expect(notification.notify).toHaveBeenCalledWith({title: 'Error', text: 'Contact not saved'});

    // Test updateContact
    axiosPut.mockResolvedValueOnce(responseSuccess);
    await updateContact(1);
    expect(axiosPut).toHaveBeenCalledWith('/api/contacts/1', {user: contact});
    expect(notification.notify).toHaveBeenCalledWith({title: 'Updated', text: 'Contact saved'});
    expect(router.push).toHaveBeenCalledWith({name: 'contacts.index'});
});
