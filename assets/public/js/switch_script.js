const classList = [
    "active",
    "fs-5",
    "fw-bold"
];

function listenTabs() {
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", function (e) {
            e.preventDefault();
            const page = tab.getAttribute("data-page");

            if (localStorage.getItem("currentPage") === page) {
                return;
            }
            currentPage = page;
            localStorage.setItem("currentPage", currentPage);
            
            loadContent(page);
            refreshTabs(page);
        });
    });
}

function listenNav() {
    nav_logo.addEventListener("click", function (e) {
        e.preventDefault();
        const homePage = nav_logo.getAttribute("data-page");
        
        if (localStorage.getItem("currentPage") === homePage) {
            return;
        } else {
            currentPage = homePage;
            localStorage.setItem("currentPage", currentPage);
        }
        
        loadContent(homePage);
        refreshTabs(homePage);
    });
}



function addScript(src) {
    document.body.appendChild(src);
}

async function fetchPage(page) {
    try {
        const response = await fetch(`pages/public/${page}.html`);
        const content = await response.text();
        return content;
    } catch (error) {
        console.error("Error fetching page:", error);
    }
}

async function loadContent(page) {
    let content = document.getElementById("content");
    let webPage = await fetchPage(page);
    
    let tempDiv = document.createElement("div");
    tempDiv.innerHTML = webPage;

    associations = tempDiv.querySelectorAll("associated");

    associations.forEach((association) => {
        let scriptNode = document.createElement("script");
        scriptNode.src = association.innerHTML;

        if (!document.body.contains(scriptNode)) {
            addScript(scriptNode);
        }
    });

    if (webPage) {
        content.innerHTML = webPage;
    } else {
        console.error("Failed to load page:", page);
    }

    content.innerHTML = webPage;

}

function checkPageActive(tabs) {
    let page;
    tabs.forEach((tab) => {
        if (tab.classList.contains("active")) {
            page = tab.getAttribute("data-page");
        }
    });

    return page;
}

function refreshTabs(currentPageStorage) {
    sidebarTabs.forEach((tab) => {
        if (tab.getAttribute("data-page") === currentPageStorage) {
            tab.classList.add("active", "fs-5", "fw-bold");
        } else {
            tab.classList.remove("active", "fs-5", "fw-bold");
        }
    });
}


function savePage() {
    localStorage.setItem("currentPage", currentPage);
}


let pages = [
    "home",
    "tournaments",
    "partners",
    "profile",
    "settings"
]

let currentPage = "";


document.addEventListener("DOMContentLoaded", function() {
    nav_logo = document.querySelector("#nav-logo");
    sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    
    if (!localStorage.getItem("currentPage")) {
        localStorage.setItem("currentPage", "home");
    } else {
        currentPage = localStorage.getItem("currentPage");
    }
    
    
    console.log("Current page from localStorage:", currentPage);
    
    
    refreshTabs(currentPage);
    currentPage = checkPageActive(sidebarTabs);
    loadContent(currentPage);
    
    
    listenNav();
    listenTabs();

});
