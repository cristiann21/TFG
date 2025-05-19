// Funcionalidad para filtros en la página de cursos
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar filtros en móvil
    const showFiltersBtn = document.getElementById('show-filters');
    const filtersSidebar = document.querySelector('.filters-sidebar');
    
    if (showFiltersBtn && filtersSidebar) {
        showFiltersBtn.addEventListener('click', function() {
            filtersSidebar.classList.toggle('show-mobile');
            
            // Cambiar texto del botón
            if (filtersSidebar.classList.contains('show-mobile')) {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Ocultar Filtros
                `;
            } else {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="21" x2="4" y2="14"></line>
                        <line x1="4" y1="10" x2="4" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="3"></line>
                        <line x1="20" y1="21" x2="20" y2="16"></line>
                        <line x1="20" y1="12" x2="20" y2="3"></line>
                        <line x1="1" y1="14" x2="7" y2="14"></line>
                        <line x1="9" y1="8" x2="15" y2="8"></line>
                        <line x1="17" y1="16" x2="23" y2="16"></line>
                    </svg>
                    Filtros
                `;
            }
        });
    }
    
    // Aplicar filtros automáticamente al cambiar selects
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Añadir una pequeña animación antes de enviar el formulario
            this.classList.add('filter-changed');
            setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 300);
        });
    });
    
    // Añadir efecto visual al hacer hover en los filtros
    const filterGroups = document.querySelectorAll('.filter-group');
    filterGroups.forEach(group => {
        const label = group.querySelector('label');
        const input = group.querySelector('input, select');
        
        if (input && label) {
            input.addEventListener('focus', () => {
                label.style.color = 'var(--color-primary)';
            });
            
            input.addEventListener('blur', () => {
                label.style.color = '';
            });
        }
    });
    
    // Añadir animación al botón de búsqueda
    const searchBtn = document.querySelector('.search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('mouseenter', function() {
            this.classList.add('search-btn-hover');
        });
        
        searchBtn.addEventListener('mouseleave', function() {
            this.classList.remove('search-btn-hover');
        });
    }
});