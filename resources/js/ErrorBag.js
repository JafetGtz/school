class ErrorBag {
    constructor(errors = {}) {
        this.set(errors)
    }

    any() {
        return !!this.keys.length
    }

    get keys() {
        return Object.keys(this.errors)
    }

    has(key) {
        return this.keys.indexOf(key) > -1
    }

    first(key) {
        return this.errors[key] ? this.errors[key][0] : undefined
    }

    set(errors) {
        this.errors = errors
    }

    clear(key) {
        if (key) return delete this.errors[key]
        else this.set({})
    }
}

export default ErrorBag
