import { loadContent } from "./pageLoader.js";
import { refreshTabs } from "../../shared/js/tabManager.js";

export function listenNav(navLogo, contentElement, tabs) {
    navLogo.addEventListener("click", (e) => {
        e.preventDefault();
        const homePage = navLogo.getAttribute("data-page");

        loadContent(homePage, contentElement);
        refreshTabs(tabs, homePage);
    });
}
