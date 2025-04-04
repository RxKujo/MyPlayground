export async function fetchPage(page) {
    try {
        const response = await fetch(`../../pages/admin/${page}.html`);
        const content = await response.text();
        return content;
    } catch (error) {
        console.error("Error fetching page:", error);
    }
}

export function loadContent(page, contentElement) {
    fetchPage(page).then((webPage) => {
        if (webPage) {
            contentElement.innerHTML = webPage;
        } else {
            console.error("Failed to load page content.");
        }
    });
}