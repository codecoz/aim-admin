// Usage: https://www.chartjs.org/
// import Chart from "chart.js";

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Chart.defaults.global.defaultFontFamily = "'Inter', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";

window.Chart = Chart;