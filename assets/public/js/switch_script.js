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
    
    if (webPage) {
        content.innerHTML = webPage;
    } else {
        console.error("Failed to load page:", page);
    }

    content.innerHTML = webPage;

}

document.addEventListener("DOMContentLoaded", function() {
    sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    
    sidebarTabs.forEach((tab) => {
        if (tab.classList.contains("active")) {
            const page = tab.getAttribute("data-page");
            loadContent(page);
        }
    });
});
