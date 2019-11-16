<template>
    <div class="container">
        <form @submit="login">
            <div class="form-group">
                <input class="form-control" v-model="email" type="email" name="email" placeholder="Email Address">
            </div>
            <div class="form-group">
                <input class="form-control" v-model="password" type="password" name="password" placeholder="Password">
            </div>
            <button class="float-right btn btn-success">Login</button>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
          return{
              email: '',
              password: '',
          }
        },
        mounted() {
            
        },
        methods: {
            login(e){
                e.preventDefault();
                let data = {
                    email: this.email,
                    password: this.password
                }
                axios.post('/login',data).then(response => {
                    this.$emit('user',response.data);
                });
            }
       }
    }
</script>
