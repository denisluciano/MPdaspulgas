
<template>
    <div>
        <v-toolbar app>
        <v-toolbar-title class="headline text-uppercase">
            <!-- <span>Vuetify</span> -->
            <span @click="onHome" style="cursor:pointer;" class="font-weight-light">MP das pulgas</span>
        </v-toolbar-title>

        <v-spacer></v-spacer>
        <v-btn>logar</v-btn>
        <v-btn>cadastrar</v-btn>
        </v-toolbar>





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

