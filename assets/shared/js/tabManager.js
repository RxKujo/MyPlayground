export function refreshTabs(tabs, currentPage) {
    tabs.forEach((tab) => {
        const isActive = tab.getAttribute("data-page") === currentPage;

        tab.classList.toggle("active", isActive);
        tab.classList.toggle("fs-5", isActive);
        tab.classList.toggle("fw-bold", isActive);
    });
}

export function checkPageActive(tabs) {
    let activePage;

    tabs.forEach((tab) => {
        if (tab.classList.contains("active")) {
            activePage = tab.getAttribute("data-page");
        }
    });
    return activePage;
}