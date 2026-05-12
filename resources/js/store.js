const store = {

    loading: false,

    sidebarOpen: true,

    flash: {
        success: '',
        error: ''
    },

    setLoading(value) {
        this.loading = value;
    },

    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    },

    setSuccess(message) {
        this.flash.success = message;

        setTimeout(() => {
            this.flash.success = '';
        }, 3000);
    },

    setError(message) {
        this.flash.error = message;

        setTimeout(() => {
            this.flash.error = '';
        }, 3000);
    }
}

export default store;