export function getCurrentPage() {
    const currentPage = sessionStorage.getItem("currentPage");
    return currentPage ? currentPage : "home";
}

export function setCurrentPage(page) {
    sessionStorage.setItem("currentPage", page);
}