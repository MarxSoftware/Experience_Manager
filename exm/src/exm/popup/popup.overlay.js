
var PopupOverlay = function () {

    var addOverlay = function (exm_container, clickHandler) {
        let popup_overlay = document.getElementById("exm_overlay")
        if (popup_overlay == null) {
            popup_overlay = document.createElement("div")
            popup_overlay.classList.add("overlay")
            popup_overlay.id = "exm_overlay"

            exm_container.appendChild(popup_overlay)
        }

        popup_overlay.addEventListener('click', clickHandler)
    }

    var show = function () {
        document.getElementById("exm_overlay").style.display = 'block'
    }
    var hide = function () {
        document.getElementById("exm_overlay").style.display = 'none'
    }

    return {
        addOverlay: addOverlay,
        show: show,
        hide: hide
    }
}()

export default PopupOverlay