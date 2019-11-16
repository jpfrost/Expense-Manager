<template>
    <div class="container">
        <canvas id="canvas"></canvas>
    </div>
</template>

<script>

var Chart = require('chart.js');

    export default {
        props:[],
        data(){
          return{
            expenses: [],
            label: [],
            data: [],
          }
        },
        watch:{
            expenses: function(expenses,oldexpenses){
                this.updateChart();
            }
        },
        mounted() {

            axios.get('/graph').then(response => {
                this.expenses = response.data;
            });


            
        },
        methods: {
           updateChart(){
                this.expenses.forEach((value,key) => {
                    Vue.set(this.label,this.label.length,value.name);
                    Vue.set(this.data,this.data.length,value.total);
                });

                new Chart(document.getElementById('canvas').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: this.label,
                            datasets: [{
                                label: 'Total Expenses',
                                data: this.data,
                                backgroundColor: [
                                    '#2ecc71',
                                    '#e74c3c',
                                    '#8e44ad',
                                    '#d35400',
                                    '#16a085'
                                ]
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                fontSize: 22,
                                text: 'Expenses'
                            }
                        }
                });
           },
       }
    }
</script>
