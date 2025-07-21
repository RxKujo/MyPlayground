document.addEventListener("DOMContentLoaded", () => {
    const date = new Date();

    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const currentDate = `${year}-${month}-${day}`;

    const maxDateObj = new Date(date);
    maxDateObj.setMonth(maxDateObj.getMonth() + 1);

    const maxDay = String(Math.min(date.getDate(), new Date(maxDateObj.getFullYear(), maxDateObj.getMonth() + 1, 0).getDate())).padStart(2, '0');
    const maxMonth = String(maxDateObj.getMonth() + 1).padStart(2, '0');
    const maxYear = maxDateObj.getFullYear();
    const maxDate = `${maxYear}-${maxMonth}-${maxDay}`;

    const datePicker = document.getElementById("datePicker");

    datePicker.setAttribute("min", currentDate)
    datePicker.setAttribute("max", maxDate);
})