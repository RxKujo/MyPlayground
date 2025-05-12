import { addScript, isScriptPresent, removeScript, replaceScript } from "./scriptLoader.js";


export async function fetchPage(page) {
    try {
        let response;
        
        response = await fetch(`pages/public/${page}.php`);

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
        if (page === "tournaments") {
            let src = "assets/public/js/carouselLoader.js";
            
            if (!isScriptPresent(src)) {
                addScript(src);
            } else {
                replaceScript(src, src);
            }
        } else if (page === "settings") {}
    } else {
        console.error("Failed to load page content.");
    }
}