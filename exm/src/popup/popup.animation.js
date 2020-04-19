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
                        return 'slide-in-left'
                    case 'tr':
                    case 'mr':
                    case 'br':
                        return 'slide-in-right'
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

    
    return {
        getCloseAnimation : getCloseAnimation,
        getOpenAnimation: getOpenAnimation
    }
}()

export default PopupAnimation