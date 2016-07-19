export default {

    name: {
        required: {
            rule: true,
            message: 'We need your the full name'
        }
    },

    username: {
        required: {
            rule: true,
            message: 'Username is required'
        },
        minlength: {
            rule: 6,
            message: 'We need at least 6 characters of username'
        }
    },

    email: {
        required: {
            rule: true,
            message: 'Email is required'
        }
    },

    password: {
        required: {
            rule: true,
            message: 'Password is required.'
        },
        minlength: {
            rule: 6,
            message: 'We need at least 6 characters of password'
        }
    }

}
