const items = document.getElementById('item-table');

if (items) {
    items.addEventListener('click', ev => {
        if (ev.target.className === 'btn btn-danger delete-item') {

            const id = ev.target.getAttribute('data-id');

            fetch(`/items/delete/${id}`, {
                method: 'DELETE'
            }).then(res => location.reload());
        }
    });
}