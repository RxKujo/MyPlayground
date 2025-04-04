export function attachButtonListeners(contentElement, filter_div) {
    const clearButton = contentElement.querySelector("#clear-button");
    const searchButton = contentElement.querySelector("#search-button");

    clearButton.addEventListener("click", () => {
        clear(filter_div);
    });
    searchButton.addEventListener("click", () => {
        search(filter_div);
    });
}

function clear(filter_div) {
    let filter_buttons = filter_div.querySelectorAll("button");
    filter_buttons.forEach((button) => {
        button.classList.remove("active");
        button["aria-pressed"] = "false";
    });
}

function search(filter_div) {
    let filter_buttons = filter_div.querySelectorAll("button");
    let selected_filters = [];
    filter_buttons.forEach((button) => {
        if (button.classList.contains("active")) {
            selected_filters.push(button.getAttribute("data-filter"));
        }
    });

    console.log("Selected filters:", selected_filters);
}