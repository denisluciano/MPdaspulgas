
<template>

  <v-app>
    <v-toolbar app dark color="#de5d3c" v-if="$route.name != 'Login'">
    <v-menu offset-y>
      <template v-slot:activator="{ on }">
        <v-btn flat dark icon color="white" v-on="on">
          <v-icon>more_vert</v-icon>
        </v-btn>
      </template>
      <v-list >
        <div v-for="item in items"
          :key="item.title" 
        >
          <v-list-tile
            class='mr-5'
            @click="$router.push(item.path)"
          >
            <v-list-tile-action >
                <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile>
        </div>
      </v-list>
    </v-menu>
      <span class="">
         <v-list-tile avatar>
          <v-list-tile-avatar>
            <v-avatar 
            size="45"
            color="grey lighten-4"
          >
            <img src="./assets/profile_pictures/asd.png" alt="avatar">
          </v-avatar>
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title v-if="$route.name != 'Login'">{{computedNome}}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        </span>
      <v-spacer></v-spacer>

      <v-btn icon @click="logout()">
        <v-icon>exit_to_app</v-icon>
      </v-btn>
    </v-toolbar>
    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  components: {
  },
  data () {
    return {
      url: 'http://127.0.0.1:8000',
      drawer: null,
      items: [
        { title: 'Fazer Login', icon: 'add_shopping_cart', path: '/Login'},
        { title: 'Anúncios', icon: 'add_shopping_cart', path: '/Anuncios'},
        { title: 'Meu perfil', icon: 'add_shopping_cart', path: '/Cadastro'},
        { title: 'Histórico', icon: 'attach_money', path: '/Acerto'},
      ],
      users: [
       // { title: 'Pessoas', icon: 'people', path: '/Usuarios'},
        { title: 'Bikers', icon: 'directions_bike', path: '/Bikers'},
        { title: 'Parceiros', icon: 'store_mall_directory', path: '/Parceiros'},
        { title: 'Admins', icon: 'assignment_ind', path: '/Admins'}
      ],
    }
  },


  computed: {
    computedNome(){
      return sessionStorage.getItem('nome');
    }
  },
  
  created () {
    sessionStorage.setItem('url', this.url)
  },

  methods: {
    onHome () {
          this.$router.push('/App')
    },
    logout () {
      sessionStorage.clear();
      this.$router.push('/');
      sessionStorage.setItem('url', this.url)
      
    },
    getNome() {
      return sessionStorage.getItem('nome')
    }
  }
}
</script>
<style>
  .fixed-top{
    position: fixed;
    top: 0px;
  }
</style>

