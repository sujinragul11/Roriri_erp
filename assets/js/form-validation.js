/**
 * Form-validation.js
 * Shared client-side validation helper for the RORIRI ERP.
 * Exposes a single global function: validateForm(form) -> boolean
 * and auto-enhances any <form class="needs-validation" novalidate>.
 */
(function ($, window) {
    'use strict';

    var SELECTOR = 'form.needs-validation[novalidate], form[data-validate]';

    // ---- field-level validators (return error message string or '') ----
    function validators() {
        var re = {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone10: /^\d{10}$/,
            url: /^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w\-./?%&=]*)?$/i,
            gst: /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/,
            number: /^-?\d*\.?\d+$/
        };

        return {
            email: function (v) {
                return v && !re.email.test(v) ? 'Please enter a valid email address.' : '';
            },
            phone10: function (v) {
                return v && !re.phone10.test(v) ? 'Please enter a valid 10-digit phone number.' : '';
            },
            url: function (v) {
                return v && !re.url.test(v) ? 'Please enter a valid URL.' : '';
            },
            gst: function (v) {
                return v && !re.gst.test(v) ? 'Please enter a valid GST number.' : '';
            },
            number: function (v) {
                return v && !re.number.test(v) ? 'Please enter a valid number.' : '';
            },
            min: function (v, el) {
                var m = el.data('min');
                if (v && m !== undefined && parseFloat(v) < parseFloat(m)) {
                    return 'Value must be at least ' + m + '.';
                }
                return '';
            },
            max: function (v, el) {
                var m = el.data('max');
                if (v && m !== undefined && parseFloat(v) > parseFloat(m)) {
                    return 'Value must be at most ' + m + '.';
                }
                return '';
            }
        };
    }

    function validatorsByName(name, value, el) {
        var fns = validators();
        if (fns[name]) { return fns[name](value, el); }
        return '';
    }

    // Render feedback for one field
    function setFieldState($field, error, feedback) {
        var $wrap = findWrap($field);
        if (error) {
            $field.addClass('is-invalid').removeClass('is-valid');
            if ($field.attr('aria-describedby')) { return; }
            $wrap.find('.invalid-feedback').text(error).show();
        } else {
            $field.removeClass('is-invalid');
            if ($field.val() !== '' || !isRequired($field)) {
                $field.addClass('is-valid');
            }
            $wrap.find('.invalid-feedback').text(feedback || '').hide();
        }
    }

    function isRequired($field) {
        return $field.prop('required') === true ||
               ($field.attr('required') !== undefined && $field.attr('required') !== 'false');
    }

    function findWrap($field) {
        // Prefer the nearest .form-group / .col-* wrapper containing a feedback element
        var $closest = $field.closest('.form-group, .col-md-6, .col-md-12, .col-6, .col-12, .col-sm-6, .mb-3, div');
        var fb = $closest.find('.invalid-feedback');
        return fb.length ? $closest : $field.closest('div');
    }

    function isHidden($el) {
        return !$el.is(':visible') || $el.css('display') === 'none';
    }

    function getFieldValue($field) {
        if ($field.attr('type') === 'checkbox') { return $field.is(':checked') ? 'x' : ''; }
        return $.trim($field.val());
    }

    // Validate a single field; returns true if valid
    function validateField($field) {
        // skip hidden-in-modal or display:none fields (e.g. Quill textarea) unless required
        if (isHidden($field) && $field.attr('type') !== 'hidden' && !isRequired($field)) {
            return true;
        }
        // Quill hidden textareas are optional by design
        if (($field.is('textarea') && $field.css('display') === 'none') && !isRequired($field)) {
            return true;
        }

        var val = getFieldValue($field);
        var error = '';

        if (isRequired($field) && val === '') {
            error = 'This field is required.';
        }

        if (!error && val !== '') {
            var rule = $field.data('rule');
            if (rule) { error = validatorsByName(rule, val, $field) || ''; }
            if (!error && $field.attr('type') === 'email' && !validators()['email'](val)) {
                error = 'Please enter a valid email address.';
            }
        }

        // date ordering: end >= start
        if (!error && $field.data('dateAfter')) {
            var other = $('#' + $field.data('dateAfter'));
            var a = new Date(val).getTime();
            var b = new Date(other.val()).getTime();
            if (val && other.val() && a < b) { error = 'Date cannot be before ' + other.data('label') + ' date.'; }
        }

        // Select2: mark wrapper invalid
        if ($field.hasClass('select2-hidden-accessible') || $field.data('select2')) {
            if (error) {
                $field.closest('.form-group, .col-md-6, .col-md-12').find('.select2-container').addClass('is-invalid');
            } else {
                $field.closest('.form-group, .col-md-6, .col-md-12').find('.select2-container').removeClass('is-invalid');
            }
        }

        var feedback = $field.data('feedback') || '';
        setFieldState($field, error, feedback);
        return error === '';
    }

    // Validate whole form; returns true if all valid
    function validateForm(form) {
        var $form = $(form);
        var ok = true;
        $form.find(':input').each(function () {
            var $f = $(this);
            if ($f.attr('type') === 'hidden') { return; }
            if (!validateField($f)) { ok = false; }
        });
        $form.addClass('was-validated');
        // request first invalid field focus
        if (!ok) {
            $form.find('.is-invalid:visible').first().focus();
        }
        return ok;
    }

    // wire live feedback
    function initForm($form) {
        $form.off('.formvalidate').on('input.formvalidate change.formvalidate blur.formvalidate', ':input', function () {
            if ($form.hasClass('was-validated')) {
                validateField($(this));
            }
        });

        // Select2 change hookup
        $form.find('select.select2, select[data-select2]').each(function () {
            var $s = $(this);
            $s.on('select2:select select2:unselect', function () {
                if ($form.hasClass('was-validated')) { validateField($s); }
            });
        });

        // Validate before form submit is allowed
        $form.on('submit.formvalidate', function (e) {
            if (!validateForm(this)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            return true;
        });
    }

    function init() {
        $(SELECTOR).each(function () { initForm($(this)); });
    }

    window.validateForm = validateForm;

    $(function () { init(); });

    // Re-init on modal shown (modals are hidden -> fields hidden)
    $(document).on('shown.bs.modal', function (e) {
        $(e.target).find(SELECTOR).each(function () { initForm($(this)); });
    });

})(jQuery, window);
