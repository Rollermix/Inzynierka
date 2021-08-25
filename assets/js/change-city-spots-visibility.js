document.querySelectorAll('tbody tr').forEach(element => {
    if(element.getAttribute('id')) {
        element.addEventListener('click', () => {
            document.querySelectorAll('tbody tr').forEach(spot => {
                if(spot.getAttribute('data-cityid') === element.getAttribute('id')) {
                    if(spot.classList.contains('hidden-js')) {
                        spot.classList.remove('hidden-js');
                    } else {
                        spot.classList.add('hidden-js');
                    }
                }
            })
        });
    }
})