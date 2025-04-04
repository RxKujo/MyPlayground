import { loadContent } from "./pageLoader.js";
import { refreshTabs } from "../../shared/js/tabManager.js";
import { listenNav } from "./navHandler.js";
import { getCurrentPage, setCurrentPage } from "./storageUtils.js";
import { attachButtonListeners } from "./filterButtons.js";


document.addEventListener("DOMContentLoaded", async function() {
    
    const nav_logo = document.querySelector("#nav-logo");
    const sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    const contentElement = document.querySelector("#content");
    
    let currentPage = getCurrentPage();
    refreshTabs(sidebarTabs, currentPage);
    await loadContent(currentPage, contentElement);
    
    
    const filterDiv = document.querySelector("#search-filters");
    attachButtonListeners(contentElement, filterDiv);
    listenNav(nav_logo, sidebarTabs, contentElement)
    
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", (e) => {
            e.preventDefault();
            const page = tab.getAttribute("data-page");
            if (currentPage !== page) {
                currentPage = page;
                setCurrentPage(page);
                loadContent(page, contentElement);
                refreshTabs(sidebarTabs, page);
            }
        });
    });
    
    console.log("Current page:", contentElement.outerHTML);
});
