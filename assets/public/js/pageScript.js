import { loadContent } from "./pageLoader.js";
import { refreshTabs } from "../../shared/js/tabManager.js";
import { getCurrentPage, setCurrentPage } from "./storageUtils.js";
import { checkFilterDivAttach } from "./filterButtons.js";
import { listenPTButtons } from "./generalButtons.js";


document.addEventListener("DOMContentLoaded", async function() {
    
    const nav_logo = document.querySelector("#nav-logo");
    const sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    const contentElement = document.querySelector("#content");
    
    let currentPage = getCurrentPage();

    refreshTabs(sidebarTabs, currentPage);
    await loadContent(currentPage, contentElement);
    
    
    listenPTButtons(contentElement);
    checkFilterDivAttach(contentElement);
    listenNav(nav_logo, sidebarTabs, contentElement)
    
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", async (e) => {
            e.preventDefault();
            
            const page = tab.getAttribute("data-page");

            currentPage = page;
            setCurrentPage(page);
            await loadContent(page, contentElement);
            refreshTabs(sidebarTabs, page);

            listenPTButtons(contentElement);
            checkFilterDivAttach(contentElement);
    
        });
    });
});
