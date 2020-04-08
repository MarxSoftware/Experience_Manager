/*

{
    'id' : "#id",
    'trigger' : {
        'type' : 'after'
    },
    'position' : 'tl|tc|tr|ml|mc|mr|bl|bc|br',
    'animation' : 'fade|slide,
    'content' : '<div></div>'
}


*/

var Popup = function () {

    var popups = []

    var _getPosition = function (config) {
        switch (config.position) {
            case 'tl':
                return 'position-top-left'
            case 'tc':
                return 'position-top-center'
            case 'tc':
                return 'position-top-right'
            case 'ml':
                return 'position-middle-left'
            case 'mc':
                return 'position-middle-center'
            case 'mr':
                return 'position-middle-right'
            case 'bl':
                return 'position-bottom-left'
            case 'bc':
                return 'position-bottom-center'
            case 'br':
                return 'position-bottom-right'
            default:
                return ''
        }
    }

    var _getInitialAnimationState = function (config) {
        switch (config.animation) {
            case 'fade':
                return 'animation-fade-out'
            case 'slide':
                switch (config.position) {
                    case 'tl':
                    case 'ml':
                    case 'bl':
                        return 'slide-out-left'
                    case 'tr':
                    case 'mr':
                    case 'br':
                        return 'slide-out-right'
                }
            default:
                return ''
        }
    }   

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
        popup.classList.add(_getInitialAnimationState(configuration))

        popup_container.classList.add("popup-container")
        popup_container.classList.add(_getPosition(configuration))
        popup_container.style.zIndex = "1000"
        popup_container.appendChild(popup)

        
        exm_container.appendChild(popup_container)
        
        popup_container.style.width = (popup.offsetWidth + 10) + "px"
        popup_container.style.height = (popup.offsetHeight + 10) + "px"

        document.querySelector("#" + configuration.id + " .close").addEventListener("click", () => {
            close(configuration.id)
        });

        popups[configuration.id] = configuration;

        setTimeout(() => {
            document.querySelector("#" + configuration.id).classList.toggle("animation-fade-out")
            document.querySelector("#" + configuration.id).classList.toggle("animation-fade-in")
        }, 5000);
        
    }

    var close = function (id) {
        if (typeof popups[id] !== "undefined") {
            let config = popups[id]
            document.querySelector("#" + config.id).classList.toggle("animation-fade-in")
            document.querySelector("#" + config.id).classList.toggle("animation-fade-out")
        }
    }

    return {
        init: init,
        close: close
    }
}()

export default Popup