
<template>
    <div>
        <v-toolbar app>
        <v-toolbar-title class="headline text-uppercase">
            <!-- <span>Vuetify</span> -->
            <span @click="onHome" style="cursor:pointer;" class="font-weight-light">MP das pulgas</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>

        </v-toolbar>


        <v-container>
            <v-layout align-center justify-center column fill-height>
                <v-flex xs12 >
                    <v-btn @click="toProdutos" large color="red">Área de produtos</v-btn>
                </v-flex>
                <v-flex xs12 >
                    <v-btn @click="toClientes" large color="primary">Área de clientes</v-btn>
                </v-flex>
                <v-flex xs12 >
                    <v-btn @click="toCompras" large color="green">Área de Compras</v-btn>
                </v-flex>
            </v-layout>
        </v-container>
    </div>

</template>

<script>
  import axios from 'axios'

  export default {
      name:"Home",
    data: () => ({
        items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2'}
      ]
    }),
    methods: {
        onInit () {
            axios.get("http://127.0.0.1:8000/api/produtos").then((res) => {
                this.items = res.data
            }).catch((error) => {
                console.log(error)
            })
        },
        toProdutos () {
            this.$router.push('/produtos')
        },
        toClientes () {
            this.$router.push('/clientes')
        },
        toCompras () {
            this.$router.push('/compras')
        },
        onHome () {
          this.$router.push('/')
      }
    },
    mounted () {
        this.onInit()
    }
  }
</script>

