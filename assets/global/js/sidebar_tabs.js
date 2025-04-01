function listenTabs() {
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", function (e) {
            e.preventDefault();
            tab.classList.add("active");
            sidebarTabs.forEach((otherTab) => {
                if (otherTab !== tab) {
                    otherTab.classList.remove("active");
                }
            });
        });

        
    });
}

document.addEventListener("DOMContentLoaded", function() { 
    sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    
    listenTabs();
});
