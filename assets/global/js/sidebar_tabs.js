const classList = [
    "active",
    "fs-5",
    "fw-bold"
];

function listenTabs() {
    sidebarTabs.forEach((tab) => {
        tab.addEventListener("click", function (e) {
            e.preventDefault();
            tab.classList.add(...classList);
            
            sidebarTabs.forEach((otherTab) => {
                if (otherTab !== tab) {
                    otherTab.classList.remove(...classList);
                }
            });
        });

        
    });
}

document.addEventListener("DOMContentLoaded", function() { 
    sidebarTabs = document.querySelectorAll("#sidebar-list li a");
    
    listenTabs();
});
