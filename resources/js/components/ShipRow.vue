<template>
    <tr>
        <th scope="row">{{index}}</th>
        <td>{{ship.code}}</td>
        <td>{{ship.model}}</td>
        <td>{{ship.crews.length}}</td>
        <td>{{subordinateNb}}</td>
        <td>{{totalCrew}}</td>
        <td><button class="btn">detail</button></td>
    </tr>
</template>

<script>
    export default {
        props: {
            ship: Object,
            index: Number
        },
        data() {
            return {
            }
        },
        computed: {
            subordinateNb(){
                if(this.ship.subordinates === undefined) return 0;
                return this.ship.subordinates.length;
            },
            totalCrew() {
                let nb = this.ship.crews.length;
                if(this.ship.subordinates){
                    this.ship.subordinates.forEach(function(ship) {
                        nb += ship.crews.length;
                    });
                }

                return nb;
            }
        }
    }
</script>
