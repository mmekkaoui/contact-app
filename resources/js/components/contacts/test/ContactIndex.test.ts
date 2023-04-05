import { mount } from '@vue/test-utils';
import Contacts from '../ContactsIndex.vue';

describe('Contacts.vue', () => {
    it('renders a table with contacts', async () => {
        const contacts = [
            {
                id: 1,
                user: {
                    name: 'John Doe',
                    email: 'johndoe@example.com',
                    phoneNumbers: [{ phone_number: '123-456-7890' }],
                },
            },
            {
                id: 2,
                user: {
                    name: 'Jane Doe',
                    email: 'janedoe@example.com',
                    phoneNumbers: [{ phone_number: '987-654-3210' }],
                },
            },
        ];

        const { getByText } = await mount(Contacts, {
            data() {
                return { contacts };
            },
        });

        expect(getByText('John Doe')).toBeInTheDocument();
        expect(getByText('johndoe@example.com')).toBeInTheDocument();
        expect(getByText('123-456-7890')).toBeInTheDocument();
        expect(getByText('Jane Doe')).toBeInTheDocument();
        expect(getByText('janedoe@example.com')).toBeInTheDocument();
        expect(getByText('987-654-3210')).toBeInTheDocument();
    });

    it('calls deleteContact when delete button is clicked', async () => {
        const deleteContact = jest.fn();
        const contacts = [
            {
                id: 1,
                user: {
                    name: 'John Doe',
                    email: 'johndoe@example.com',
                    phoneNumbers: [{ phone_number: '123-456-7890' }],
                },
            },
        ];

        const { getByText } = await mount(Contacts, {
            data() {
                return { contacts };
            },
            global: {
                mocks: {
                    $router: { push: jest.fn() },
                },
            },
            methods: { deleteContact },
        });

        const deleteButton = getByText('Delete');
        await deleteButton.trigger('click');
        expect(deleteContact).toHaveBeenCalledWith(1);
    });
});
