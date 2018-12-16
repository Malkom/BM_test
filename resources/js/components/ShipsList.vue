<template>
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Model</th>
                <th scope="col">Nb crew</th>
                <th scope="col">Nb subordinate</th>
                <th scope="col">Total crew</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <ship-row :key="ship.code" :ship="ship" :index="index" v-for="(ship,index) in ships"/>
        </tbody>
    </table>
</template>

<script>
    const ShipRow = require('./ShipRow.vue');
    export default {
        components: {
            'ship-row': ShipRow.default
        },
        data() {
            return {
                ships: []
            }
        },
        mounted() {
            axios('/ships').then((response) => {
                this.ships = response.data;
            })
        }
    }
</script>
