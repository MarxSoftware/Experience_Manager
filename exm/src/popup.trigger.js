var PopupTrigger = function () {

    var _after = function (popup, seconds) {
        setTimeout(() => {
            document.querySelector("#" + popup.id).classList.toggle("animation-fade-out")
            document.querySelector("#" + popup.id).classList.toggle("animation-fade-in")
        }, seconds);
    }

    var after5 = function (popup) {
        _after(popup, 5000);
    }
    var exitIntent = function (popup) {
        let onMouseOut = (event) => {
            if (
                event.clientY < 50 &&
                event.relatedTarget == null &&
                event.target.nodeName.toLowerCase() !== 'select') {
                // Remove this event listener
                document.removeEventListener("mouseout", onMouseOut);
                // Show the popup
                document.querySelector("#" + popup.id).classList.toggle("animation-fade-out")
                document.querySelector("#" + popup.id).classList.toggle("animation-fade-in")
            }
        };
        document.addEventListener("mouseout", onMouseOut);
    }

    return {
        after5: after5,
        exitIntent: exitIntent
    }
}()

export default PopupTrigger