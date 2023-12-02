const provinceInput = document.getElementById('province');
const orInput = document.getElementById('receipt-number');
const fnameInput = document.getElementById('first_name');
const lnameInput = document.getElementById('last_name');
const barangayInput = document.getElementById('barangay');
const cityInput = document.getElementById('city');

orInput.addEventListener('input', () => {
    const orValue = orInput.value.trim();
    if (orValue === '') {
      orInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else if (/^[~`!@#$%^&*()_=+[\]{}|;:.,'"<>/?]+$/.test(orValue)) {
      orInput.setCustomValidity('Special Characters are not allowed.');
    } else if (orValue.length !== 8) {
      orInput.setCustomValidity('Length should be exactly 8 characters.');
    } else if (!/^[0-9]{7}[A-Za-z]{1}$/.test(orValue)) {
      orInput.setCustomValidity('The first 7 characters should be numeric and the last character should be a letter.');
    } else {
      orInput.setCustomValidity('');
    }
});

fnameInput.addEventListener('input', () => {
    const fnameValue = fnameInput.value.trim();
    if (fnameValue === '') {
      fnameInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else if (/^[0-9]+$/.test(fnameValue)) {
      fnameInput.setCustomValidity('Numbers are not allowed.');
    } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'",.<>/?]+$/.test(fnameValue)) {
      fnameInput.setCustomValidity('Special Characters are not allowed.');
    } else if (!/^[a-zA-Z\s-ñÑ]+$/.test(fnameValue)) {
      fnameInput.setCustomValidity('Numbers and Special Characters are not allowed.');
    } else {
      fnameInput.setCustomValidity('');
    }
});
   
lnameInput.addEventListener('input', () => {
    const lnameValue = lnameInput.value.trim(); 
    if (lnameValue === '') {
      lnameInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else if (/^[0-9]+$/.test(lnameValue)) {
      lnameInput.setCustomValidity('Numbers are not allowed.');
    } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'",.<>/?]+$/.test(lnameValue)) {
      lnameInput.setCustomValidity('Special Characters are not allowed.');
    } else if (!/^[a-zA-Z\s-ñÑ]+$/.test(lnameValue)) {
      lnameInput.setCustomValidity('Numbers and Special Characters are not allowed.');
    } else {
      lnameInput.setCustomValidity('');
    }
});

barangayInput.addEventListener('input', () => {
    const barangayValue = barangayInput.value.trim();
    if (barangayValue === '') {
      barangayInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else {
      barangayInput.setCustomValidity('');
    }
});
  
cityInput.addEventListener('input', () => {
    const cityValue = cityInput.value.trim();
    if (cityValue === '') {
      cityInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else {
      cityInput.setCustomValidity('');
    }
});
  
provinceInput.addEventListener('input', () => {
    const provinceValue = provinceInput.value.trim();
    if (provinceValue === '') {
      provinceInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else {
      provinceInput.setCustomValidity('');
    }
});



