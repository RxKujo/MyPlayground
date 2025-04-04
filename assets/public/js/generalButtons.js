import { refreshTabs } from "../../shared/js/tabManager.js";
import { setCurrentPage } from "./storageUtils.js";

export function listenPTButtons(contentElement) {
    listenFindPartners(contentElement);
    listenJoinTournaments(contentElement);
}

function listenFindPartners(contentElement) {
    const findButton = contentElement.querySelector("#find-button");
    if (findButton) {
        findButton.addEventListener("click", () => {
            gotoPartners("partners");
        });
    }
}

function listenJoinTournaments(contentElement) {
    const joinButton = contentElement.querySelector("#tournament-button");
    if (joinButton) {
        joinButton.addEventListener("click", () => {
            gotoPartners("tournaments");
        });
    }
}

async function gotoPartners(pageName) {
    import("./pageLoader.js").then((module) => {
        const page = pageName;
        const contentElement = document.querySelector("#content");
        return module.loadContent(page, contentElement).then(() => {
            setCurrentPage(page);
            refreshTabs(document.querySelectorAll("#sidebar-list li a"), page);
            window.scrollTo(0, 0);
        });
    });
}