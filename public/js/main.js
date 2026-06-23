document.querySelectorAll('.filter-pill').forEach(button => {
   button.addEventListener('click', () => {
       button.classList.toggle('active');
       updateFilter();
   });
});

function updateFilter() {
    const allCategories = [...document.querySelectorAll('.filter-pill')].map(btn => btn.dataset.category);
    const activeCategories = [...document.querySelectorAll('.filter-pill.active')]
        .map(btn => btn.dataset.category);

    if(activeCategories.length === 0) {
        console.log(allCategories);
    } else {
        console.log(activeCategories);
    }
}