const fnameInput = document.getElementById('first_name');
const lnameInput = document.getElementById('last_name');
const birthplaceInput = document.getElementById('place_of_birth');
const civilStatusInput = document.getElementById('other-civil-status');
const nationalityInput = document.getElementById('nationality');
const religionInput = document.getElementById('other-religion');
const disabilityInput = document.getElementById('other-disability');
const educationalAttainmentInput = document.getElementById('other-educational-attainment');
const streetInput = document.getElementById('street');
const phonenoInput = document.getElementById('phone_number');
const votersidInput = document.getElementById('voter_id');
const precinctnoInput = document.getElementById('precinct_number');
const emergencynameInput = document.getElementById('emergency-person');
const relationshipInput = document.getElementById('other-relationship');
const emergencyaddressInput = document.getElementById('emergency-address');
const emergencynoInput = document.getElementById('emergency-contact');


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

birthplaceInput.addEventListener('input', () => {
  const birthplaceValue = birthplaceInput.value.trim();
  if (birthplaceValue === '') {
    birthplaceInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>/?]+$/.test(birthplaceValue)) {
    birthplaceInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z0-9\s,.-ñÑ]+$/.test(birthplaceValue)) {
    birthplaceInput.setCustomValidity('Special Characters are not allowed.');
  } else {
    birthplaceInput.setCustomValidity('');
  }
});

civilStatusInput.addEventListener('input', () => {
  const civilStatusValue = civilStatusInput.value.trim();
  if (civilStatusValue === '') {
    civilStatusInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(civilStatusValue)) {
    civilStatusInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>?]+$/.test(civilStatusValue)) {
    civilStatusInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.,-ñÑ]+$/.test(civilStatusValue)) {
    civilStatusInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    civilStatusInput.setCustomValidity('');
  }
});

nationalityInput.addEventListener('input', () => {
  const nationalityValue = nationalityInput.value.trim();
  if (nationalityValue === '') {
    nationalityInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(nationalityValue)) {
    nationalityInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>?]+$/.test(nationalityValue)) {
    nationalityInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.,-ñÑ]+$/.test(nationalityValue)) {
    nationalityInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    nationalityInput.setCustomValidity('');
  }
});

religionInput.addEventListener('input', () => {
  const religionValue = religionInput.value.trim();
  if (religionValue === '') {
    religionInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(religionValue)) {
    religionInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>?]+$/.test(religionValue)) {
    religionInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.,-ñÑ]+$/.test(religionValue)) {
    religionInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    religionInput.setCustomValidity('');
  }
});

disabilityInput.addEventListener('input', () => {
  const disabilityValue = disabilityInput.value.trim();
  if (disabilityValue === '') {
    disabilityInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(disabilityValue)) {
    disabilityInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>?]+$/.test(disabilityValue)) {
    disabilityInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.,-ñÑ]+$/.test(disabilityValue)) {
    disabilityInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    disabilityInput.setCustomValidity('');
  }
});


educationalAttainmentInput.addEventListener('input', () => {
  const educationalAttainmentValue = educationalAttainmentInput.value.trim();
  if (educationalAttainmentValue === '') {
    educationalAttainmentInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(educationalAttainmentValue)) {
    educationalAttainmentInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>?]+$/.test(educationalAttainmentValue)) {
    educationalAttainmentInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.,-ñÑ]+$/.test(educationalAttainmentValue)) {
    educationalAttainmentInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    educationalAttainmentInput.setCustomValidity('');
  }
});

streetInput.addEventListener('input', () => {
  const streetValue = streetInput.value.trim();
  if (streetValue === '') {
    streetInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>?]+$/.test(streetValue)) {
    streetInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z0-9\s.,-ñÑ]+$/.test(streetValue)) {
    streetInput.setCustomValidity('Special Characters are not allowed.');
  } else {
    streetInput.setCustomValidity('');
  }
});


phonenoInput.addEventListener('input', () => {
  const phonenoValue = phonenoInput.value.trim();
  if (phonenoValue === '') {
    phonenoInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[a-zA-Z]+$/.test(phonenoValue)) {
    phonenoInput.setCustomValidity('Characters are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:.,'"<>/?]+$/.test(phonenoValue)) {
    phonenoInput.setCustomValidity('Special Characters are not allowed.');
  } else if (phonenoValue.length < 11) {
    phonenoInput.setCustomValidity('Please input 11 digit number, starting with "09"');
  } else if (!/^09[0-9]{9}$/.test(phonenoValue)) {
    phonenoInput.setCustomValidity('Please input 11 digit number, starting with "09"');
  }  else {
    phonenoInput.setCustomValidity('');
  }
});

votersidInput.addEventListener('input', () => {
  const votersidValue = votersidInput.value.trim();
  if (votersidValue === '') {
    votersidInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:,'"<>/?]+$/.test(votersidValue)) {
    votersidInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z0-9\s.-ñÑ]+$/.test(votersidValue)) {
    votersidInput.setCustomValidity('Special Characters are not allowed.');
  } else {
    votersidInput.setCustomValidity('');
  }
});

precinctnoInput.addEventListener('input', () => {
  const precinctValue = precinctnoInput.value.trim();
  if (precinctValue === '') {
    precinctnoInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:,'"<>/?]+$/.test(precinctValue)) {
    precinctnoInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z0-9\s.-ñÑ]+$/.test(precinctValue)) {
    precinctnoInput.setCustomValidity('Special Characters are not allowed.');
  } else {
    precinctnoInput.setCustomValidity('');
  }
});

emergencynameInput.addEventListener('input', () => {
  const emergencynameValue = emergencynameInput.value.trim();
  if (emergencynameValue === '') {
    emergencynameInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(emergencynameValue)) {
    emergencynameInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:,'"<>/?]+$/.test(emergencynameValue)) {
    emergencynameInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.-ñÑ]+$/.test(emergencynameValue)) {
    emergencynameInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    emergencynameInput.setCustomValidity('');
  }
});

relationshipInput.addEventListener('input', () => {
  const relationshipValue = relationshipInput.value.trim();
  if (relationshipValue === '') {
    relationshipInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[0-9]+$/.test(relationshipValue)) {
    relationshipInput.setCustomValidity('Numbers are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:,'"<>/?]+$/.test(relationshipValue)) {
    relationshipInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z\s.-ñÑ]+$/.test(relationshipValue)) {
    relationshipInput.setCustomValidity('Numbers and Special Characters are not allowed.');
  } else {
    relationshipInput.setCustomValidity('');
  }
});

emergencyaddressInput.addEventListener('input', () => {
  const emergencyaddressValue = emergencyaddressInput.value.trim();
  if (emergencyaddressValue === '') {
    emergencyaddressInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:'"<>/?]+$/.test(emergencyaddressValue)) {
    emergencyaddressInput.setCustomValidity('Special Characters are not allowed.');
  } else if (!/^[a-zA-Z0-9\s.,-ñÑ]+$/.test(emergencyaddressValue)) {
    emergencyaddressInput.setCustomValidity('Special Characters are not allowed.');
  } else {
    emergencyaddressInput.setCustomValidity('');
  }
});

emergencynoInput.addEventListener('input', () => {
  const emergencynoValue = emergencynoInput.value.trim();
  if (emergencynoValue === '') {
    emergencynoInput.setCustomValidity('Please enter a value. Avoid inputting whitespaces');
  } else if (/^[a-zA-Z]+$/.test(emergencynoValue)) {
    emergencynoInput.setCustomValidity('Characters are not allowed.');
  } else if (/^[~`!@#$%^&*()_=+[\]{}|;:,.'"<>/?]+$/.test(emergencynoValue)) {
    emergencynoInput.setCustomValidity('Special Characters are not allowed.');
  } else if (emergencynoValue.length < 11) {
    emergencynoInput.setCustomValidity('Please input 11 digit number, starting with "09"');
  } else if (!/^09[0-9]{9}$/.test(emergencynoValue)) {
    emergencynoInput.setCustomValidity('Please input 11 digit number, starting with "09"');
  } else {
    emergencynoInput.setCustomValidity('');
  }
});


