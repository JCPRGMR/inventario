document.getElementById("buscador").addEventListener("input", function() {
    let input = this.value.toLowerCase();
    let table = document.querySelector("table");
    let rows = table.querySelectorAll("tbody tr");

    rows.forEach(function(row) {
        let cells = row.querySelectorAll("td");
        let found = false;

        cells.forEach(function(cell) {
            if (cell.textContent.toLowerCase().includes(input)) {
                found = true;
            }
        });

        if (found) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});