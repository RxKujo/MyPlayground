document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector('#searchUserField');
    
    
    searchInput.addEventListener("keyup", () => {
        const tableRows = document.querySelectorAll("tbody tr");
        const searchTerm = searchInput.value.trim().toLowerCase();
        
        tableRows.forEach((row) => {
            const cells = row.querySelectorAll("td");
            
            const nomCell = cells[1];
            const prenomCell = cells[2];

            nomCell.innerHTML = nomCell.textContent;
            prenomCell.innerHTML = prenomCell.textContent;

            const nomText = nomCell.textContent.toLowerCase();
            const prenomText = prenomCell.textContent.toLowerCase();

            let matchFound = false;

            if (searchTerm !== "" && (nomText.includes(searchTerm) || prenomText.includes(searchTerm))) {
                matchFound = true;

                const regex = new RegExp(`(${searchTerm})`, "gi");
                if (nomText.includes(searchTerm)) {
                    nomCell.innerHTML = nomCell.textContent.replace(regex, "<strong>$1</strong>");
                }
                if (prenomText.includes(searchTerm)) {
                    prenomCell.innerHTML = prenomCell.textContent.replace(regex, "<strong>$1</strong>");
                }
            }

            row.style.display = matchFound || searchTerm === "" ? "" : "none";
        });
    });
});