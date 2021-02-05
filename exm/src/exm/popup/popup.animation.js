var PopupAnimation = function () {

    var getOpenAnimation = function (config) {
        switch (config.animation) {
            case 'fade':
                return 'animation-fade-in'
            case 'slide':
                switch (config.position) {
                    case 'tl':
                    case 'ml':
                    case 'bl':
                        return 'animation-slide-in-left'
                    case 'tr':
                    case 'mr':
                    case 'br':
                        return 'animation-slide-in-right'
                    case 'bc':
                        return 'animation-slide-in-bottom'
                    case 'tc':
                        return 'animation-slide-in-top'
                }
            default:
                return ''
        }
    }
    var getCloseAnimation = function (config) {
        switch (config.animation) {
            case 'fade':
                return 'animation-fade-out'
            case 'slide':
                switch (config.position) {
                    case 'tl':
                    case 'ml':
                    case 'bl':
                        return 'animation-slide-out-left'
                    case 'tr':
                    case 'mr':
                    case 'br':
                        return 'animation-slide-out-right'
                    case 'bc':
                        return 'animation-slide-out-bottom'
                    case 'tc':
                        return 'animation-slide-out-top'
                }
            default:
                return ''
        }
    }


    return {
        getCloseAnimation: getCloseAnimation,
        getOpenAnimation: getOpenAnimation
    }
}()

export default PopupAnimation