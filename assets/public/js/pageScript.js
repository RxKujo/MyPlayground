import { loadContent } from "./pageLoader.js";
import { refreshTabs } from "../../shared/js/tabManager.js";
import { getCurrentPage, setCurrentPage } from "./storageUtils.js";
import { checkFilterDivAttach } from "./filterButtons.js";
import { listenPTButtons } from "./generalButtons.js";


document.addEventListener("DOMContentLoaded", async function() {
    
    const sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    const contentElement = document.querySelector("#content");
    
    let currentPage = getCurrentPage();

    refreshTabs(sidebarTabs, currentPage);
   
    
    
    listenPTButtons(contentElement);
    checkFilterDivAttach(contentElement);
    
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", async (e) => {            
            const page = tab.getAttribute("data-page");

            setCurrentPage(page);

           
    
        });
    });
});
