$(document).ready(function() {
    const closeModalButton = document.querySelectorAll('.close-modal-btn')

    function closeModalBtn() {
        const modalContainer = document.getElementById('modal-container')
        modalContainer.classList.remove('show-modal')
    }

    closeModalButton.forEach(close => close.addEventListener('click', closeModalBtn))
})

function openModal() {
    const modalContainer = document.getElementById('modal-container')
    modalContainer.classList.add('show-modal')
}