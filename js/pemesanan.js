// slider
const col2 = document.querySelector('.col-2');
const DeskripsiWisata = document.querySelector('.DeskripsiWisata-link');
const DeskripsiPemesanan = document.querySelector('.DeskripsiPemesanan-link');

DeskripsiPemesanan.addEventListener('click', () => {
    col2.classList.add('active');
});

DeskripsiWisata.addEventListener('click', () => {
    col2.classList.remove('active');
});
