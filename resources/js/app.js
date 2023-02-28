import './bootstrap';

import Alpine from 'alpinejs';

import('preline')

window.Alpine = Alpine;

Alpine.start();

import jQuery from 'jquery';
window.$ = jQuery;
import "./chartjs";