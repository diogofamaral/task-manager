export default class DecoratedError {
    constructor(error) {
        this.__error = error;
    }

    get message() {
        return this.response?.data?.message ?? this.__error.message;
    }

    get response() {
        return this.__error.response || {};
    }

    get status() {
        return this.response.status;
    }

    get errors() {
        if (! this.response.data) {
            return {};
        }

        return this.response.data.errors || {};
    }

    /** @returns {boolean} */
    isForbidden() {
        return this.status === 403;
    }

    /** @returns {boolean} */
    isUnprocessableEntity() {
        return this.status === 422;
    }
}
