/**
 * Add Event Listeners
 */
window.addEventListener('errorMessage', event => {
    alertError(event.detail.message);
})

window.addEventListener('successMessage', event => {
    alertSuccess(event.detail.message);
})

window.addEventListener('confirmationAlert',event => {
    Swal.fire({
        text: event.detail.message,
        icon: 'question',
        confirmButtonText: window.Lang.get('main.general.actions.confirm'),
        confirmButtonColor: '#238C00',
        showCancelButton: true,
        cancelButtonText: window.Lang.get('main.general.actions.cancel'),
        didOpen(popup) {
            var audio = new Audio('/static/audio/success-beep.wav');
            audio.play();
        }
    }).then((res) => {
        if(res.isConfirmed){
            Livewire.emit(event.detail.emit_when_confirmed, event.detail.emit_params);
        }
    });

})

window.addEventListener('inputAlert',event => {
    Swal.fire({
        title: event.detail.title,
        html: event.detail.alert+"<br/><b>"+event.detail.message+"</b>",
        confirmButtonText: window.Lang.get('main.general.actions.confirm'),
        confirmButtonColor: '#238C00',
        showCancelButton: true,
        cancelButtonText: window.Lang.get('main.general.actions.cancel'),
        input: 'text',
        inputValue: event.detail.initial_value,
        preConfirm(inputValue) {
          if(inputValue.length <= 1){
              Swal.showValidationMessage(
                  window.Lang.get('main.general.validation.type_something')
              )
          }
        },
        didOpen(popup) {
            var audio = new Audio('/static/audio/success-beep.wav');
            audio.play();
        }
    }).then((res) => {
        if(res.isConfirmed){
            // Emit Event
            Livewire.emit(event.detail.emit_when_confirmed, res.value, event.detail.emit_params);
        }
    });

})

// Execute custom JS code
window.addEventListener('vanilla', event => {
    eval(event.detail.js);
});

// Open a Bootstrap modal
window.addEventListener('openModal', event => {
    window.bootstrap.Modal.getOrCreateInstance('#'+event.detail.modalId).show();
});

// Close a Bootstrap modal
window.addEventListener('closeModal', event => {
    document.getElementById(event.detail.modalId).querySelector('.btn-close').click();
});

// Mask a element
window.addEventListener('mask', event => {
    window.VMasker(document.querySelector(event.detail.selector)).maskPattern(event.detail.pattern);
});


// Load Leaflet Map
window.addEventListener('loadGeoJson', event => {

    var container = L.DomUtil.get('map');
    if(container != null){
        container._leaflet_id = null;
    }

    let map = window.Leaflet.map("map",{
        center: [-16.485040295960356, -54.641971690360364],
        zoom: 13,
        dragging: true
    });

    window.Leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let parsedGeojson = JSON.parse(event.detail.jsonContent);
    let geoJson = window.Leaflet.geoJson(parsedGeojson).addTo(map);

    try{
        map.fitBounds(geoJson.getBounds());
    }catch (exceptionVars){
        window.alertError(window.Lang.get('main.plot.invalid_map_load'))
    }


});
