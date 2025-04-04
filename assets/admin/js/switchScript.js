import { loadContent } from "./pageLoader.js";
import { refreshTabs } from "../../shared/js/tabManager.js";

document.addEventListener("DOMContentLoaded", function() {
    const sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    const contentElement = document.querySelector("#content");

    let currentPage = "dashboard";
    refreshTabs(sidebarTabs, currentPage);
    loadContent(currentPage, contentElement);

    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", (e) => {
            e.preventDefault();
            const page = tab.getAttribute("data-page");
            if (currentPage !== page) {
                currentPage = page;
                loadContent(page, contentElement);
                refreshTabs(sidebarTabs, page);
            }
        });
    });
});