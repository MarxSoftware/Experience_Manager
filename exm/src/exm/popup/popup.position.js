var PopupPosition = function () {


    var getPosition = function (config) {
        switch (config.position) {
            case 'tl':
                return 'position-top-left'
            case 'tc':
                return 'position-top-center'
            case 'tr':
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

    var isTopCenter = function (config) {
        switch (config.position) {
            case 'tc':
                return true
            default:
                return false
        }
    }
    var isTop = function (config) {
        switch (config.position) {
            case 'tr':
            case 'tl':
            case 'tc':
                return true
            default:
                return false
        }
    }
    var isBottom = function (config) {
        switch (config.position) {
            case 'br':
            case 'bl':
            case 'bc':
                return true
            default:
                return false
        }
    }

    var isBottomCenter = function (config) {
        switch (config.position) {
            case 'bc':
                return true
            default:
                return false
        }
    }

    var isLeft = function (config) {
        switch (config.position) {
            case 'tl':
            case 'ml':
            case 'bl':
                return true
            default:
                return false
        }
    }

    var isRight = function (config) {
        switch (config.position) {
            case 'tr':
            case 'mr':
            case 'br':
                return true
            default:
                return false
        }
    }

    return {
        getPosition: getPosition
        , isLeft: isLeft
        , isRight: isRight
        , isTop: isTop
        , isBottom: isBottom
        , isTopCenter: isTopCenter
        , isBottomCenter: isBottomCenter
    }
}()

export default PopupPosition