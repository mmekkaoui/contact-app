import { mount } from "@vue/test-utils";
import { describe, it, expect } from "vitest";
import ContactsCreate from '../ContactsCreate.vue'

describe("ContactsCreate.vue", () => {
    it("render contacts create correctly", () => {
        const wrapper = mount(ContactsCreate, {});

        expect(wrapper.html()).toContain("Add Contact Form")
    });
});