import { loadContent } from "./pageLoader.js";
import { refreshTabs } from "../../shared/js/tabManager.js";

export function getCurrentPage() {
    const currentPage = sessionStorage.getItem("currentPage");
    return currentPage ? currentPage : "dashboard";
}

export function setCurrentPage(page) {
    sessionStorage.setItem("currentPage", page);
}

document.addEventListener("DOMContentLoaded", function() {
    const sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    const contentElement = document.querySelector("#content");

    let currentPage = getCurrentPage();
            
    setCurrentPage(currentPage);
    refreshTabs(sidebarTabs, currentPage);
    
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", async (e) => {            
            const page = tab.getAttribute("data-page");
            
            setCurrentPage(page);
            refreshTabs(sidebarTabs, page);
            
           
                
            });
        });
});