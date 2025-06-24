import { refreshTabs } from "../../shared/js/tabManager.js";
import { setCurrentPage } from "./storageUtils.js";

export function listenPTButtons(contentElement) {
    listenNav();
    listenDC(contentElement);
    listenFindPartners(contentElement);
    listenJoinTournaments(contentElement);
    listenEditProfile(contentElement)
    listenRegistrationPlayer(contentElement);
}

function listenFindPartners(contentElement) {
    const findButton = contentElement.querySelector("#find-button");
    if (findButton) {
        findButton.addEventListener("click", () => {
            setCurrentPage("partners");
        });
    }
}

function listenJoinTournaments(contentElement) {
    const joinButton = contentElement.querySelector("#tournament-button");
    if (joinButton) {
        joinButton.addEventListener("click", () => {
            setCurrentPage("tournaments");
        });
    }
}

function listenNav() {
    const navLogo = document.querySelector("#nav-logo");
    const profileIcon = document.querySelector("#profile-icon");
    const messagesIcon = document.querySelector("#messages-icon");

    if (navLogo) {
        navLogo.addEventListener("click", () => {
            setCurrentPage("home");
        })
    } else if (profileIcon) {
        profileIcon.addEventListener("click", () => {
            setCurrentPage("profile");
        })
    } else if (messagesIcon) {
        messagesIcon.addEventListener("click", () => {
            setCurrentPage("messages");
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

function listenDL(contentElement) {
    const dcButton = contentElement.querySelector("#delete-button");
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
            setCurrentPage("profile");
        });
    }
}

function listenRegistrationPlayer(contentElement) {
    try {
        const roleInputs = contentElement.querySelectorAll('input[name="role"]');
        console.log(roleInputs);
        const positionCol = contentElement.querySelector('#position-container').closest('.col');
        const levelCol = contentElement.querySelector('#level-container').closest('.col');

        function togglePositionContainer() {
        const isJoueur = contentElement.querySelector('#joueur').checked;
        positionCol.style.display = isJoueur ? 'block' : 'none';
        levelCol.style.display = isJoueur ? 'block' : 'none';
        }

      
        roleInputs.forEach(input => {
        input.addEventListener('change', togglePositionContainer);
        console.log("changed");
        });
    } catch {

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