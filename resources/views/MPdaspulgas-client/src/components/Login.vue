
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

           <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Login form</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>


                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" name="login" label="Login" type="text"></v-text-field>
                  <v-text-field prepend-icon="lock" name="password" label="Password" id="password" type="password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary">Login</v-btn>
              </v-card-actions>

            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
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

