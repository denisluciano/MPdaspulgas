<template>
<div>
        <v-toolbar app>
        <v-toolbar-title class="headline text-uppercase">
            <!-- <span>Vuetify</span> -->
            <span @click="onHome" style="cursor:pointer;" class="font-weight-light">Dinni Compras</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>

        </v-toolbar>

    <v-layout row wrap >
        <v-flex xs12 >
            <v-card>

            <v-list three-line>
            <template v-for="(item, index) in items">
                <v-list-tile
                :key="index"
                >
                    <v-flex xs12>
                        <v-list-tile-content>
                            <v-list-tile-title> Produto: {{item.produto_nome}}</v-list-tile-title>
                            <v-list-tile-sub-title>Cliente: {{item.cliente_nome }} {{item.sobrenome}}</v-list-tile-sub-title>
                            <v-list-tile-sub-title>Data da compra: {{formatDate(item.created_at)}}</v-list-tile-sub-title>


                        </v-list-tile-content>
                        <v-divider></v-divider>
                    </v-flex>

                </v-list-tile>
                </template>
            </v-list>
        </v-card>
        </v-flex>
    </v-layout>
    </div>


</template>

<script>

import axios from 'axios'
import moment from 'moment'

export default {
    name:"Compra",
    data () {
      return {
        items: []

      }
    },
    methods: {
        onInit () {
            axios.get('http://127.0.0.1:8000/api/compras/').then((res) => {
                this.items = res.data
            }).catch((error) => {
                console.log(error)
            })

        },
        onHome () {
          this.$router.push('/')
        },
        formatDate(date){
            return moment(date, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY');
        }
    },
    mounted () {
        this.onInit()
    }

}
</script>
