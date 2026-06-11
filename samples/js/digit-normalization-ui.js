(function () {
  'use strict';

  const digitMap = {
    '۰': '0', '۱': '1', '۲': '2', '۳': '3', '۴': '4',
    '۵': '5', '۶': '6', '۷': '7', '۸': '8', '۹': '9',
    '٠': '0', '١': '1', '٢': '2', '٣': '3', '٤': '4',
    '٥': '5', '٦': '6', '٧': '7', '٨': '8', '٩': '9'
  };

  function normalizeDigits(value) {
    return String(value || '').replace(/[۰-۹٠-٩]/g, function (char) {
      return digitMap[char] || char;
    });
  }

  function normalizeInput(event) {
    const input = event.target;
    const normalized = normalizeDigits(input.value);

    if (input.value !== normalized) {
      input.value = normalized;
      input.dispatchEvent(new Event('change', { bubbles: true }));
    }
  }

  function bindCheckoutNormalization(root) {
    const scope = root || document;
    const selector = 'input[data-normalize-digits="true"], input[name*="phone"], input[name*="postcode"]';

    scope.querySelectorAll(selector).forEach(function (input) {
      input.addEventListener('input', normalizeInput);
      input.value = normalizeDigits(input.value);
    });
  }

  window.ShowcaseCheckoutDigits = {
    normalizeDigits: normalizeDigits,
    bind: bindCheckoutNormalization
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      bindCheckoutNormalization(document);
    });
  } else {
    bindCheckoutNormalization(document);
  }
})();
