let filter_div = document.getElementById("search-filters");

let clearButton = document.querySelector("#clear-button");
let searchButton = document.querySelector("#search-button");

function clear() {
    let filter_buttons = filter_div.querySelectorAll("button");
    filter_buttons.forEach((button) => {
        button.classList.remove("active");
        button["aria-pressed"] = "false";
    });
}

function search() {
    let filter_buttons = filter_div.querySelectorAll("button");
    let selected_filters = [];
    filter_buttons.forEach((button) => {
        if (button.classList.contains("active")) {
            selected_filters.push(button.getAttribute("data-filter"));
        }
    });

    console.log("Selected filters:", selected_filters);
}


clearButton.addEventListener("click", function() {
    clear();
});

searchButton.addEventListener("click", function() {
    search();
});