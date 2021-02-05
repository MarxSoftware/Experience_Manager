import PopupAnimation from './popup.animation'
import PopupOverlay from './popup.overlay'

var PopupTrigger = function () {

    var _after = function (popup, seconds) {
        const openAnimationClass = PopupAnimation.getOpenAnimation(popup);
        const closeAnimationClass = PopupAnimation.getCloseAnimation(popup);
        PopupAnimation.getCloseAnimation(popup);
        setTimeout(() => {
            PopupOverlay.show();
            document.querySelector("#" + popup.id).classList.toggle(closeAnimationClass)
            document.querySelector("#" + popup.id).classList.toggle(openAnimationClass)
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
                PopupOverlay.show();
                // Show the popup
                const openAnimationClass = PopupAnimation.getOpenAnimation(popup);
                const closeAnimationClass = PopupAnimation.getCloseAnimation(popup);
                document.querySelector("#" + popup.id).classList.toggle(closeAnimationClass)
                document.querySelector("#" + popup.id).classList.toggle(openAnimationClass)
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