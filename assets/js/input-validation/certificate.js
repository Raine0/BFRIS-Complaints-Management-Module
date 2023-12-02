const otherpurposeInput = document.getElementById('other-purpose');
const orInput = document.getElementById('receipt-number');
const cedulaInput = document.getElementById('cedula-number');

document.addEventListener('DOMContentLoaded', () => {

  otherpurposeInput.addEventListener('input', () => {
    const otherpurposeValue = otherpurposeInput.value.trim();
    if (otherpurposeValue === '') {
      otherpurposeInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else if (/^[0-9]+$/.test(otherpurposeValue)) {
      otherpurposeInput.setCustomValidity('Numbers are not allowed.');
    } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'",.<>/?]+$/.test(otherpurposeValue)) {
      otherpurposeInput.setCustomValidity('Special Characters are not allowed.');
    } else if (!/^[a-zA-Z\s-]+$/.test(otherpurposeValue)) {
      otherpurposeInput.setCustomValidity('Numbers and Special Characters are not allowed.');
    } else {
      otherpurposeInput.setCustomValidity('');
    }
  });

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

  cedulaInput.addEventListener('input', () => {
    const cedulaValue = cedulaInput.value.trim();
    if (cedulaValue === '') {
      cedulaInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
    } else if (/^[a-zA-Z]+$/.test(cedulaValue)) {
      cedulaInput.setCustomValidity('Characters are not allowed.');
    } else if (/^[~`!@#$%^&*()_=+[\]{}|;:.,'"<>/?]+$/.test(cedulaValue)) {
      cedulaInput.setCustomValidity('Special Characters are not allowed.');
    } else if (cedulaValue.length !== 8) {
      cedulaInput.setCustomValidity('Length should be exactly 8 digits.');
    } else if (!/^[0-9]{8}$/.test(cedulaValue)) {
      cedulaInput.setCustomValidity('Alphabet characters and Special characters are not allowed.');
    } else {
      cedulaInput.setCustomValidity('');
    }
  });
  
});
