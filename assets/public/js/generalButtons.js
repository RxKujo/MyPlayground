import { refreshTabs } from "../../shared/js/tabManager.js";
import { setCurrentPage } from "./storageUtils.js";

export function listenPTButtons(contentElement) {
    listenDC(contentElement);
}

function listenFindPartners(contentElement) {
    const findButton = contentElement.querySelector("#find-button");
    if (findButton) {
        findButton.addEventListener("click", () => {
            gotoPage("partners");
        });
    }
}

function listenJoinTournaments(contentElement) {
    const joinButton = contentElement.querySelector("#tournament-button");
    if (joinButton) {
        joinButton.addEventListener("click", () => {
            gotoPage("tournaments");
        });
    }
}

function listenNav(contentElement) {
    const nav_logo = document.querySelector("#nav-logo");
    if (nav_logo) {
        nav_logo.addEventListener("click", () => {
            gotoPage("home");
        })
    }
}

function listenDC(contentElement) {
    const dcButton = contentElement.querySelector("#disconnect-button");
    if (dcButton) {
        dcButton.addEventListener("click", () => {
            setCurrentPage("home");
        });
    }
}

function listenEditProfile(contentElement) {
    const editButton = contentElement.querySelector("#edit-profile");
    if (editButton) {
        editButton.addEventListener("click", () => {
            gotoPage("edit-profile");
        });
    }
}


async function gotoPage(pageName) {
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