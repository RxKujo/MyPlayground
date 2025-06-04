import { refreshTabs } from "../../shared/js/tabManager.js";
import { setCurrentPage } from "./storageUtils.js";

export function checkFilterDivAttach(contentElement) {
    const filter_div = document.querySelector("#search-filters");
    if (!filter_div) {
        return null;
    }

    attachButtonListeners(contentElement, filter_div);
}

function attachButtonListeners(contentElement, filter_div) {
    const clearButton = contentElement.querySelector("#clear-button");
    const searchButton = contentElement.querySelector("#search-button");

    if (clearButton && searchButton) {
        clearButton.addEventListener("click", () => {
            clear(filter_div);
        });
        searchButton.addEventListener("click", () => {
            search(filter_div);
        });
    }
}

function clear(filter_div) {
    let filter_buttons = filter_div.querySelectorAll("label[type='button']");
    filter_buttons.forEach((button) => {
        button.classList.remove("active");
        button["aria-pressed"] = "false";
    });
}

function search(filter_div) {
    setCurrentPage("partners");
}

async function gotoPartners() {
    import("./pageLoader.js").then((module) => {
        const page = "partners";
        const contentElement = document.querySelector("#content");
        return module.loadContent(page, contentElement).then(() => {
            setCurrentPage(page);
            refreshTabs(document.querySelectorAll("#sidebar-list li a"), page);
            window.scrollTo(0, 0);
        });
    });
}
