/**
 * Import custom resources
 */
import.meta.glob(['../images/**'])


/**
 * Require another libs
 */
// Bootstrap global
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Lang Manager global
window.Lang = Lang;
// Set the locale
window.Lang.setLocale(document.querySelector('meta[name="selected-lang"]').content);

// Sweet Alert
import Swal from "sweetalert2";
window.Swal = Swal;
/**
 * Files struct
 */
// Import Sweet Alerts
import "./swals";

// Import VMasker
import * as VMasker from "vanilla-masker";
window.VMasker = VMasker;

// Import Leaflet
import * as Leaflet from "leaflet";
window.Leaflet = Leaflet;

// Livewire events dispatch
import "./livewireDispatchs";

// Import Custom Listeners
import "./listeners";
