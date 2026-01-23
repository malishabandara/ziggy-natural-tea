// Cart Logic
const Cart = {
    key: 'ziggy_cart',

    getItems: function () {
        const items = localStorage.getItem(this.key);
        return items ? JSON.parse(items) : [];
    },

    addItem: function (product) {
        let items = this.getItems();
        const existingItem = items.find(item => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += parseInt(product.quantity);
        } else {
            items.push(product);
        }

        localStorage.setItem(this.key, JSON.stringify(items));
        this.updateBadge();

        // Show notification
        this.showNotification('Product added to cart!');
    },

    updateItem: function (productId, quantity) {
        let items = this.getItems();
        const item = items.find(item => item.id === productId);
        if (item) {
            item.quantity = parseInt(quantity);
            if (item.quantity <= 0) {
                this.removeItem(productId);
                return;
            }
            localStorage.setItem(this.key, JSON.stringify(items));
            this.updateBadge();
        }
    },

    removeItem: function (productId) {
        let items = this.getItems();
        items = items.filter(item => item.id !== productId);
        localStorage.setItem(this.key, JSON.stringify(items));
        this.updateBadge();
    },

    clear: function () {
        localStorage.removeItem(this.key);
        this.updateBadge();
    },

    updateBadge: function () {
        const items = this.getItems();
        const count = items.reduce((sum, item) => sum + parseInt(item.quantity), 0);
        const badge = document.getElementById('cart-count');
        if (badge) badge.textContent = count;
    },

    showNotification: function (message) {
        // Simple alert for now, can be improved to a toast
        console.log(message);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    Cart.updateBadge();
});
