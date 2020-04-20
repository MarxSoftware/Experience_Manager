/*

{
    'id' : "#id",
    'trigger' : {
        'type' : 'after<exit_intent'
    },
    'position' : 'tl|tc|tr|ml|mc|mr|bl|bc|br',
    'animation' : 'fade|slide,
    'content' : '<div></div>'
    'conditions' : {
        'weekdays' : ['1']
    }
}


*/

import PopupTrigger from './popup.trigger'
import PopupAnimation from './popup.animation'
import PopupPosition from './popup.position'
import PopupOverlay from './popup.overlay'

var Popup = function () {

    var popups = []

    var _addContainers = function () {
        let exm_container = document.getElementById("exm_container")
        if (exm_container == null) {
            exm_container = document.createElement("div")
            exm_container.classList.add("exm")
            exm_container.id = "exm_container"
            document.body.appendChild(exm_container)
        }
        PopupOverlay.addOverlay(exm_container, _closeHandler.bind(this));

        return exm_container;
    }

    var _closeHandler = function () {
        closeAll()
    }

    var init = function (configuration) {

        let exm_container = _addContainers();

        let popup_container = document.createElement("div")
        let popup = document.createElement("div")

        popup.innerHTML = configuration.content
        popup.setAttribute("id", configuration.id)
        popup.classList.add("popup")
        popup.classList.add(PopupAnimation.getCloseAnimation(configuration))

        if (PopupPosition.isLeft(configuration)) {
            popup.style.right = 0
        } else if (PopupPosition.isRight(configuration)) {
            popup.style.left = 0
        } else if (PopupPosition.isTopCenter(configuration)) {
            popup.style.bottom = 0
        } else if (PopupPosition.isBottomCenter(configuration)) {
            popup.style.top = 0
        }

        popup_container.classList.add("popup-container")
        popup_container.classList.add(PopupPosition.getPosition(configuration))
        popup_container.style.zIndex = "1000"
        popup_container.appendChild(popup)


        exm_container.appendChild(popup_container)

        popup_container.style.width = (popup.offsetWidth + 10) + "px"
        popup_container.style.height = (popup.offsetHeight + 10) + "px"

        let $closeElement = document.querySelector("#" + configuration.id + " .close");
        if ($closeElement) {
            $closeElement.addEventListener("click", () => {
                close(configuration.id)
            });
        }

        popups.push(configuration);

        if (configuration.trigger.type === "after5") {
            PopupTrigger.after5(configuration)
        } else if (configuration.trigger.type === "exit_intent") {
            PopupTrigger.exitIntent(configuration)
        }

    }

    var close = function (id) {
        let popup = popups.find((element) => element.id === id);
        if (typeof popup !== "undefined") {
            _close(popup)
            //document.querySelector("#" + popup.id).closest(".popup-container").remove();
        }
    }

    var _close = function (popup) {
        const openAnimationClass = PopupAnimation.getOpenAnimation(popup)
        const closeAnimationClass = PopupAnimation.getCloseAnimation(popup)
        document.querySelector("#" + popup.id).classList.toggle(openAnimationClass)
        document.querySelector("#" + popup.id).classList.toggle(closeAnimationClass)

        PopupOverlay.hide()
    }

    var closeAll = function () {
        popups.forEach(_close)
    }

    return {
        init: init,
        close: close,
        closeAll: closeAll
    }
}()

export default Popup