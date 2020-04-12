/*

{
    'id' : "#id",
    'trigger' : {
        'type' : 'after<exit_intent'
    },
    'position' : 'tl|tc|tr|ml|mc|mr|bl|bc|br',
    'animation' : 'fade|slide,
    'content' : '<div></div>'
}


*/

import PopupTrigger from './popup.trigger'
import PopupAnimation from './popup.animation'
import PopupPosition from './popup.position'

var Popup = function () {

    var popups = []

    var init = function (configuration) {
        let exm_container = document.getElementById("exm_container");
        if (exm_container == null) {
            exm_container = document.createElement("div")
            exm_container.classList.add("exm")
            document.body.appendChild(exm_container)
        }
        let popup_container = document.createElement("div")
        let popup = document.createElement("div")

        popup.innerHTML = configuration.content
        popup.setAttribute("id", configuration.id)
        popup.classList.add("popup")
        popup.classList.add(PopupAnimation.getInitialAnimationState(configuration))

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

        popups[configuration.id] = configuration;

        if (configuration.trigger.type === "after5") {
            setTimeout(() => {
                document.querySelector("#" + configuration.id).classList.toggle("animation-fade-out")
                document.querySelector("#" + configuration.id).classList.toggle("animation-fade-in")
            }, 5000);
            PopupTrigger.after5(configuration)
        } else if (configuration.trigger.type === "exit_intent") {
            PopupTrigger.exitIntent(configuration)
        }

    }

    var close = function (id) {
        if (typeof popups[id] !== "undefined") {
            let config = popups[id]
            document.querySelector("#" + config.id).classList.toggle("animation-fade-in")
            document.querySelector("#" + config.id).classList.toggle("animation-fade-out")

            document.querySelector("#" + config.id).closest(".popup-container").remove();
        }
    }

    return {
        init: init,
        close: close
    }
}()

export default Popup