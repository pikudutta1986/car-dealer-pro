/**
 * Global Form Validation System for Car Dealer Pro
 * Provides comprehensive client-side validation for all forms
 */

// Wait for jQuery to be available
(function() {
    'use strict';
    
    // Function to initialize validation when jQuery is ready
    function initValidation() {
        // Use jQuery if available, otherwise use vanilla JS
        const $ = window.jQuery || window.$;
        
        if (!$) {
            console.error('jQuery not found. Validation system requires jQuery.');
            return;
        }

    // Validation configuration
    const ValidationConfig = {
        // Field validation rules
        rules: {
            required: {
                pattern: /^.+$/,
                message: 'This field is required'
            },
            email: {
                pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                message: 'Please enter a valid email address'
            },
            phone: {
                pattern: /^[\+]?[1-9][\d]{0,15}$/,
                message: 'Please enter a valid phone number'
            },
            vin: {
                pattern: /^[A-HJ-NPR-Z0-9]{17}$/,
                message: 'VIN must be exactly 17 characters (letters and numbers only)'
            },
            year: {
                pattern: /^(19[6-9][0-9]|20[0-2][0-9])$/,
                message: 'Please enter a valid year (1960-2029)'
            },
            price: {
                pattern: /^\d+(\.\d{1,2})?$/,
                message: 'Please enter a valid price (numbers only)'
            },
            mileage: {
                pattern: /^\d+$/,
                message: 'Please enter a valid mileage (numbers only)'
            },
            engine: {
                pattern: /^\d+$/,
                message: 'Please enter a valid engine size (numbers only)'
            },
            seating: {
                pattern: /^[1-9]$/,
                message: 'Please enter a valid seating capacity (1-9)'
            },
            cylinders: {
                pattern: /^[1-8]$/,
                message: 'Please enter a valid number of cylinders (1-8)'
            },
            airbags: {
                pattern: /^\d+$/,
                message: 'Please enter a valid number of airbags'
            },
            password: {
                pattern: /^.{8,}$/,
                message: 'Password must be at least 8 characters'
            },
            strong_password: {
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/,
                message: 'Password must be at least 8 characters with uppercase, lowercase, and number'
            },
            username: {
                pattern: /^[a-zA-Z0-9_]{3,20}$/,
                message: 'Username must be 3-20 characters (letters, numbers, underscore only)'
            },
            url: {
                pattern: /^https?:\/\/.+/,
                message: 'Please enter a valid URL starting with http:// or https://'
            },
            slug: {
                pattern: /^[a-z0-9-]+$/,
                message: 'Slug must contain only lowercase letters, numbers, and hyphens'
            }
        },
        
        // Form-specific configurations
        forms: {
            'login-form': {
                fields: {
                    'username': ['required', 'username'],
                    'password': ['required', 'password']
                }
            },
            'car-form': {
                fields: {
                    'vin': ['required', 'vin'],
                    'carcondition': ['required'],
                    'year': ['required', 'year'],
                    'make_id': ['required'],
                    'model_id': ['required'],
                    'website_price': ['price'],
                    'owner_price': ['price'],
                    'mileage': ['mileage'],
                    'engine': ['engine'],
                    'seating_capacity': ['seating'],
                    'cylinders': ['cylinders'],
                    'airbags': ['airbags'],
                    'email': ['email'],
                    'phone': ['phone']
                },
                customValidations: {
                    'price-comparison': function(form) {
                        const websitePrice = parseFloat($('#website_price').val()) || 0;
                        const ownerPrice = parseFloat($('#owner_price').val()) || 0;
                        
                        if (websitePrice > 0 && ownerPrice > 0 && websitePrice < ownerPrice) {
                            return 'Website price should be higher than owner price';
                        }
                        return null;
                    }
                }
            },
            'contact-form': {
                fields: {
                    'name': ['required'],
                    'email': ['required', 'email'],
                    'subject': ['required'],
                    'message': ['required']
                }
            },
            'settings-form': {
                fields: {
                    'username': ['required', 'username'],
                    'email': ['required', 'email'],
                    'phone': ['phone'],
                    'businessname': ['required'],
                    'currency': ['required'],
                    'distance_unit': ['required']
                }
            },
            'password-form': {
                fields: {
                    'current_password': ['required'],
                    'new_password': ['required', 'password'],
                    'confirm_password': ['required']
                },
                customValidations: {
                    'password-match': function(form) {
                        const newPassword = $('#new_password').val();
                        const confirmPassword = $('#confirm_password').val();
                        
                        if (newPassword !== confirmPassword) {
                            return 'New password and confirm password do not match';
                        }
                        return null;
                    }
                }
            },
            'email-settings-form': {
                fields: {
                    'smtp_host': ['required'],
                    'smtp_port': ['required'],
                    'username': ['required', 'email']
                }
            },
            'social-links-form': {
                fields: {
                    'fb_page_link': ['url'],
                    'twitter_page_link': ['url'],
                    'yt_page_link': ['url'],
                    'insta_page_link': ['url']
                }
            },
            'page-form': {
                fields: {
                    'title': ['required'],
                    'slug': ['required', 'slug']
                }
            },
            'model-form': {
                fields: {
                    'make_id': ['required'],
                    'model': ['required']
                }
            },
            'make-form': {
                fields: {
                    'make': ['required']
                }
            },
            'bodystyle-form': {
                fields: {
                    'bodystyle': ['required']
                }
            }
        }
    };

    // Validation class
    class FormValidator {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.addValidationStyles();
        }

        bindEvents() {
            // Bind to all forms
            $(document).on('submit', 'form', (e) => {
                this.validateForm(e);
            });

            // Clear validation on input
            $(document).on('input', 'input, select, textarea', (e) => {
                this.clearFieldError(e.target);
            });
            
            // Clear validation on form reset
            $(document).on('reset', 'form', (e) => {
                this.clearAllValidationStates(e.target);
            });
        }

        addValidationStyles() {
            // Add CSS for validation states
            if (!$('#validation-styles').length) {
                $('head').append(`
                    <style id="validation-styles">
                        .field-error {
                            border-color: #dc3545 !important;
                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                            background-color: #fff5f5 !important;
                        }
                        .field-success {
                            border-color: #28a745 !important;
                            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
                            background-color: #f8fff8 !important;
                        }
                        .field-required-error {
                            border-color: #dc3545 !important;
                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                            background-color: #fff5f5 !important;
                            border-width: 2px !important;
                        }
                        .validation-message {
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.25rem;
                            display: block;
                            font-weight: 500;
                        }
                        .validation-success {
                            color: #28a745;
                        }
                        .form-group.has-error .form-control {
                            border-color: #dc3545;
                            background-color: #fff5f5;
                        }
                        .form-group.has-success .form-control {
                            border-color: #28a745;
                            background-color: #f8fff8;
                        }
                        .form-group.has-error .form-floating label {
                            color: #dc3545;
                        }
                        .form-group.has-success .form-floating label {
                            color: #28a745;
                        }
                        .required-field-empty {
                            border-color: #dc3545 !important;
                            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
                            background-color: #fff5f5 !important;
                            border-width: 2px !important;
                            animation: shake 0.5s ease-in-out;
                        }
                        @keyframes shake {
                            0%, 100% { transform: translateX(0); }
                            25% { transform: translateX(-5px); }
                            75% { transform: translateX(5px); }
                        }
                        .form-error-message {
                            background-color: #f8d7da;
                            border: 1px solid #f5c6cb;
                            color: #721c24;
                            padding: 15px;
                            border-radius: 5px;
                            margin-bottom: 20px;
                        }
                        .form-error-message ul {
                            margin: 10px 0 0 0;
                            padding-left: 20px;
                        }
                        .form-error-message li {
                            margin: 5px 0;
                        }
                        /* Contact form specific styling */
                        .contact__form .form-control.field-error {
                            border-color: #dc3545 !important;
                            background-color: #fff5f5 !important;
                        }
                        .contact__form .form-group.has-error .form-control {
                            border-color: #dc3545 !important;
                            background-color: #fff5f5 !important;
                        }
                        .contact__form .validation-message {
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.25rem;
                            display: block;
                            font-weight: 500;
                        }
                    </style>
                `);
            }
        }

        validateForm(e) {
            const form = e.target;
            const formId = this.getFormId(form);
            const formConfig = this.getFormConfig(formId);
            
            if (!formConfig) {
                return true; // No validation config, allow submission
            }

            let isValid = true;
            const errors = [];

            // Validate individual fields
            Object.keys(formConfig.fields).forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    const fieldError = this.validateField(field, formConfig.fields[fieldName]);
                    if (fieldError) {
                        isValid = false;
                        errors.push(fieldError);
                        
                        // Add special styling for required field errors
                        if (fieldError.includes('required')) {
                            $(field).addClass('required-field-empty');
                            setTimeout(() => {
                                $(field).removeClass('required-field-empty');
                            }, 1000);
                        }
                    }
                }
            });
            
            // Highlight all empty required fields
            if (!isValid) {
                this.highlightEmptyRequiredFields(form, formConfig);
            }

            // Run custom validations
            if (formConfig.customValidations) {
                Object.keys(formConfig.customValidations).forEach(validationName => {
                    const customError = formConfig.customValidations[validationName](form);
                    if (customError) {
                        isValid = false;
                        errors.push(customError);
                    }
                });
            }

            if (!isValid) {
                e.preventDefault();
                this.showFormErrors(errors);
                return false;
            }

            return true;
        }

        validateField(field, rules = null) {
            if (!field) return null;

            const fieldName = field.name;
            const formId = this.getFormId(field.closest('form'));
            const formConfig = this.getFormConfig(formId);
            
            if (!formConfig || !formConfig.fields[fieldName]) {
                return null;
            }

            const fieldRules = rules || formConfig.fields[fieldName];
            const value = field.value.trim();

            // Clear previous errors
            this.clearFieldError(field);

            // Check each rule
            for (const rule of fieldRules) {
                const ruleConfig = ValidationConfig.rules[rule];
                if (!ruleConfig) continue;

                if (rule === 'required' && !value) {
                    this.showFieldError(field, ruleConfig.message);
                    return ruleConfig.message;
                }

                if (value && ruleConfig.pattern && !ruleConfig.pattern.test(value)) {
                    this.showFieldError(field, ruleConfig.message);
                    return ruleConfig.message;
                }
            }

            // Show success state for valid fields
            if (value) {
                this.showFieldSuccess(field);
            }

            return null;
        }

        showFieldError(field, message) {
            $(field).addClass('field-error field-required-error').removeClass('field-success');
            
            // Add shake animation for required field errors
            if (message.includes('required')) {
                $(field).addClass('required-field-empty');
                setTimeout(() => {
                    $(field).removeClass('required-field-empty');
                }, 500);
            }
            
            // Add error message
            const errorElement = $(field).siblings('.validation-message');
            if (errorElement.length) {
                errorElement.text(message).removeClass('validation-success');
            } else {
                $(field).after(`<div class="validation-message">${message}</div>`);
            }

            // Add error class to parent form group
            $(field).closest('.form-group, .form-floating').addClass('has-error').removeClass('has-success');
            
            // Add red color to label if it exists
            const label = $(field).siblings('label, .form-floating label');
            if (label.length) {
                label.addClass('text-danger');
            }
        }

        showFieldSuccess(field) {
            $(field).addClass('field-success').removeClass('field-error field-required-error');
            
            // Remove error message
            $(field).siblings('.validation-message').remove();
            
            // Add success class to parent form group
            $(field).closest('.form-group, .form-floating').addClass('has-success').removeClass('has-error');
            
            // Remove red color from label and add green
            const label = $(field).siblings('label, .form-floating label');
            if (label.length) {
                label.removeClass('text-danger').addClass('text-success');
            }
        }

        clearFieldError(field) {
            $(field).removeClass('field-error field-success field-required-error required-field-empty');
            $(field).siblings('.validation-message').remove();
            $(field).closest('.form-group, .form-floating').removeClass('has-error has-success');
            
            // Remove color classes from label
            const label = $(field).siblings('label, .form-floating label');
            if (label.length) {
                label.removeClass('text-danger text-success');
            }
        }

        showFormErrors(errors) {
            // Remove existing error messages
            $('.form-error-message').remove();
            
            // Show errors
            if (errors.length > 0) {
                const errorHtml = `
                    <div class="form-error-message alert alert-danger" role="alert">
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            ${errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>
                `;
                
                $('form').prepend(errorHtml);
                
                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $('.form-error-message').offset().top - 100
                }, 500);
            }
        }

        getFormId(form) {
            if (!form) return null;
            
            // Try to get form ID
            if (form.id) return form.id;
            
            // Try to get form class
            if (form.className) {
                const classes = form.className.split(' ');
                for (const cls of classes) {
                    if (cls.includes('form') || cls.includes('Form')) {
                        return cls;
                    }
                }
            }
            
            // Try to determine form type by fields
            const fields = Array.from(form.querySelectorAll('input, select, textarea')).map(f => f.name);
            
            if (fields.includes('username') && fields.includes('password')) {
                return 'login-form';
            } else if (fields.includes('vin') && fields.includes('make_id')) {
                return 'car-form';
            } else if (fields.includes('name') && fields.includes('email') && fields.includes('message')) {
                return 'contact-form';
            } else if (fields.includes('username') && fields.includes('email') && fields.includes('businessname')) {
                return 'settings-form';
            } else if (fields.includes('current_password') && fields.includes('new_password')) {
                return 'password-form';
            } else if (fields.includes('title') && fields.includes('slug')) {
                return 'page-form';
            } else if (fields.includes('make_id') && fields.includes('model')) {
                return 'model-form';
            } else if (fields.includes('make') && !fields.includes('model')) {
                return 'make-form';
            } else if (fields.includes('bodystyle')) {
                return 'bodystyle-form';
            } else if (fields.includes('smtp_host') && fields.includes('smtp_port')) {
                return 'email-settings-form';
            } else if (fields.includes('fb_page_link') && fields.includes('twitter_page_link')) {
                return 'social-links-form';
            }
            
            return null;
        }

        getFormConfig(formId) {
            return ValidationConfig.forms[formId] || null;
        }

        highlightEmptyRequiredFields(form, formConfig) {
            // Find all required fields and highlight empty ones
            Object.keys(formConfig.fields).forEach(fieldName => {
                const fieldRules = formConfig.fields[fieldName];
                if (fieldRules.includes('required')) {
                    const field = form.querySelector(`[name="${fieldName}"]`);
                    if (field && !field.value.trim()) {
                        // Add red styling to empty required fields
                        $(field).addClass('field-error field-required-error');
                        $(field).closest('.form-group, .form-floating').addClass('has-error');
                        
                        // Add red color to label
                        const label = $(field).siblings('label, .form-floating label');
                        if (label.length) {
                            label.addClass('text-danger');
                        }
                        
                        // Add shake animation
                        $(field).addClass('required-field-empty');
                        setTimeout(() => {
                            $(field).removeClass('required-field-empty');
                        }, 1000);
                    }
                }
            });
        }

        clearAllValidationStates(form) {
            // Clear all validation states from all fields in the form
            $(form).find('input, select, textarea').each((index, field) => {
                this.clearFieldError(field);
            });
            
            // Remove form error message
            $(form).find('.form-error-message').remove();
        }

        // Public method to add custom validation rules
        addRule(ruleName, pattern, message) {
            ValidationConfig.rules[ruleName] = {
                pattern: pattern,
                message: message
            };
        }

        // Public method to add custom form configuration
        addFormConfig(formId, config) {
            ValidationConfig.forms[formId] = config;
        }

        // Public method to validate a specific field
        validateFieldByName(fieldName, value, rules) {
            for (const rule of rules) {
                const ruleConfig = ValidationConfig.rules[rule];
                if (!ruleConfig) continue;

                if (rule === 'required' && !value.trim()) {
                    return ruleConfig.message;
                }

                if (value && ruleConfig.pattern && !ruleConfig.pattern.test(value)) {
                    return ruleConfig.message;
                }
            }
            return null;
        }
    }

        // Initialize validation when document is ready
        $(document).ready(function() {
            try {
                window.FormValidator = new FormValidator();
                
                // Initialize form validation system
            } catch (error) {
                console.error('Error initializing form validation:', error);
            }
            
            // Add some additional utility functions
            window.FormValidationUtils = {
                // Validate email
                isValidEmail: function(email) {
                    return ValidationConfig.rules.email.pattern.test(email);
                },
                
                // Validate phone
                isValidPhone: function(phone) {
                    return ValidationConfig.rules.phone.pattern.test(phone);
                },
                
                // Validate VIN
                isValidVIN: function(vin) {
                    return ValidationConfig.rules.vin.pattern.test(vin);
                },
                
                // Format phone number
                formatPhone: function(phone) {
                    return phone.replace(/\D/g, '');
                },
                
                // Sanitize input
                sanitizeInput: function(input) {
                    return input.trim().replace(/[<>]/g, '');
                }
            };
        });
    }
    
    // Initialize when jQuery is available
    if (window.jQuery || window.$) {
        initValidation();
    } else {
        // Wait for jQuery to load
        const checkJQuery = setInterval(function() {
            if (window.jQuery || window.$) {
                clearInterval(checkJQuery);
                initValidation();
            }
        }, 100);
        
        // Timeout after 10 seconds
        setTimeout(function() {
            clearInterval(checkJQuery);
            console.error('jQuery did not load within 10 seconds. Validation system not initialized.');
        }, 10000);
    }
    
})();
