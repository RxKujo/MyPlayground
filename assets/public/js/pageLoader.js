export async function fetchPage(page) {
    try {
        const response = await fetch(`pages/public/${page}.html`);
        const content = await response.text();
        return content;
    } catch (error) {
        console.error("Error fetching page:", error);
    }
}

export async function loadContent(page, contentElement) {
    const webPage = await fetchPage(page);
    if (webPage) {
        contentElement.innerHTML = webPage;
    } else {
        console.error("Failed to load page content.");
    }
}