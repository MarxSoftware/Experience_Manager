var PopupAnimation = function () {


    var getInitialAnimationState = function (config) {
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
        getInitialAnimationState: getInitialAnimationState
    }
}()

export default PopupAnimation