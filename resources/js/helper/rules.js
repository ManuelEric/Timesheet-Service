// validationRules.js
export const rules = {
  required: [
    value => {
      if (!value || value.length === 0) return 'Field is required'
      
      return true
    },
  ],
  email: [
    value => !!value || 'Email is required',
    value => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value) || 'Email must be valid',
  ],
  not_zero: [
    value => {
      if (!value || value==0) return 'Field cannot be 0'
      
      return true
    },
  ],
  password: [
    value => {
      if (!value || value.length < 8) return 'Password must be at least 8 characters long';
      return true;
    },
    value => {
      if (!/\d/.test(value)) return 'Password must contain at least one number';
      return true;
    },
    value => {
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(value)) return 'Password must contain at least one symbol (!@#$%^&*(),.?":{}|<>)';
      return true;
    },
  ],
}
