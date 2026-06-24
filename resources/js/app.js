function initKnockoutBracket(scrollCont) {
    if (!scrollCont) return;

    const columns = Array.from(
        scrollCont.querySelectorAll(":scope > section > *"),
    );

    function toggleHeight(col) {
        if (
            col.getBoundingClientRect().right <
            scrollCont.getBoundingClientRect().left
        ) {
            col.style.maxHeight = "0px";
        }
        if (
            col.getBoundingClientRect().right >
            scrollCont.getBoundingClientRect().left
        ) {
            col.style.maxHeight = "2000px";
        }
    }

    function applyAll() {
        columns.forEach((col) => toggleHeight(col));
    }

    scrollCont.addEventListener("scroll", applyAll);
    window.addEventListener("bracket-updated", applyAll);
}

window.initKnockoutBracket = initKnockoutBracket;

document.addEventListener("DOMContentLoaded", function () {
    const scrollCont = document.querySelector(
        ".knockout-bracket-container > div",
    );
    initKnockoutBracket(scrollCont);
});
