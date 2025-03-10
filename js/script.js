document.addEventListener("DOMContentLoaded", function () {
  const table = document.getElementById("ordered-table");
  const thElements = table.querySelectorAll("th");

  thElements.forEach((th, index) => {
    th.addEventListener("click", () => {
      const rows = Array.from(table.querySelectorAll("tbody tr"));
      const isAscending = th.classList.contains("asc");
      const compare = (rowA, rowB) => {
        const cellA = rowA.cells[index].innerText.trim();
        const cellB = rowB.cells[index].innerText.trim();
        return isNaN(cellA)
          ? cellA.localeCompare(cellB)
          : parseFloat(cellA) - parseFloat(cellB);
      };

      rows.sort((rowA, rowB) => {
        const result = compare(rowA, rowB);
        return isAscending ? result : -result;
      });

      rows.forEach((row) => table.querySelector("tbody").appendChild(row));
      th.classList.toggle("asc", !isAscending);
      th.classList.toggle("desc", isAscending);
    });
  });
});
