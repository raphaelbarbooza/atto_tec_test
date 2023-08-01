/**
 * Sweet Alerts
 */
window.alertSuccess = (message) => {
    Swal.fire({
        text: message,
        icon: 'success',
        confirmButtonText: window.Lang.get('swal.ok'),
        confirmButtonColor: '#238C00',
        didOpen(popup) {
            var audio = new Audio('/static/audio/success-beep.wav');
            audio.play();
        }
    })
}

window.alertError = (message) => {
    Swal.fire({
        text: message,
        icon: 'error',
        confirmButtonText: window.Lang.get('swal.ok'),
        confirmButtonColor: '#B20000',
        didOpen(popup) {
            var audio = new Audio('/static/audio/error-beep.wav');
            audio.play();
        }
    })
}
