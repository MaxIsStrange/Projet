const Tabs = document.querySelectorAll("[data-tab]");
const FirstLocation = "section";

window.location.hash = FirstLocation;

Tabs.forEach((element) => {
    element.addEventListener("click", (event) => {
        let selectedTab = event.currentTarget;
        updateActiveTab(selectedTab);
    });
});

let updateActiveTab = (newActiveTab) => {
    Tabs.forEach((tab) => {
        tab.classList.remove("is-active");
    });

    newActiveTab.classList.add("is-active");
};

