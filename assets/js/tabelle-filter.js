document.addEventListener('DOMContentLoaded', function () {
    var inputs = document.querySelectorAll('[data-tabelle-filter]');

    inputs.forEach(function (input) {
        var table = document.getElementById(input.getAttribute('data-tabelle-filter'));

        if (!table) {
            return;
        }

        var rows = table.querySelectorAll('tbody tr');
        var clearButton = input.parentElement.querySelector('.tabelle-filter-clear');

        function applyFilter() {
            var query = input.value.trim().toLowerCase();

            rows.forEach(function (row) {
                var text = row.textContent.toLowerCase();
                var visible = query === '' || text.indexOf(query) !== -1;
                row.style.display = visible ? '' : 'none';
            });

            if (clearButton) {
                clearButton.hidden = query === '';
            }
        }

        input.addEventListener('input', applyFilter);

        if (clearButton) {
            clearButton.addEventListener('click', function () {
                input.value = '';
                applyFilter();
                input.focus();
            });
        }
    });
});
