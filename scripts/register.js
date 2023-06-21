const basicSection = document.querySelector('.basic');
const addrPassSection = document.querySelector('.addr-pass');
const role = document.querySelector('input[name="role"]:checked').value;
const elderlyInputSection = document.querySelector('.elderly-input');
const volunteerInputSection = document.querySelector('.volunteer-input');
const nextButton = document.querySelector('.basic .button button');
const roleInputButton = document.querySelector('.addr-pass .button button');

document.addEventListener('DOMContentLoaded', function () {
    nextButton.addEventListener('click', toggleNext);
    roleInputButton.addEventListener('click', toggleRoleInput);
});

function toggleNext() {
    basicSection.style.display = 'none';
    addrPassSection.style.display = 'block';
    elderlyInputSection.style.display = 'none';
    volunteerInputSection.style.display = 'none';

}

function toggleRoleInput() {
    basicSection.style.display = 'none';
    addrPassSection.style.display = 'none';
    elderlyInputSection.style.display = 'none';
    volunteerInputSection.style.display = 'none';

    if (role === 'elderly') {
        elderlyInputSection.style.display = 'block';
    } else if (role === 'volunteer') {
        volunteerInputSection.style.display = 'block';
    }
}
