require('./bootstrap');
import $ from 'jquery';
import DataTable from 'datatables.net-dt';
import '../../public/js/preline.js';
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;
window.$ = window.jQuery = $;
window.DataTable = DataTable;

// Initialize Preline after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.HSStaticMethods.autoInit();
});
