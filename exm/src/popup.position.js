var PopupPosition = function () {


    var getPosition = function (config) {
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

    
    return {
        getPosition: getPosition
    }
}()

export default PopupPosition