<template>
    <!-- Modal -->
    <div class="modal fade" :id="'account-'+account.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">
                <b>{{account.name}}</b>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form >
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" v-model="name">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" v-model="email">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" v-model="password">
                </div>
                <div class="form-group">
                    <label for="">Role</label>
                    <select class="form-control" v-model="role_id">
                        <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="save()">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['account','roles'],
        data(){
          return{
            id: this.account.id || 0,
            name: this.account.name,
            email: this.account.email,
            password: '',
            role_id: this.account.role.id,
          }
        },
        mounted() {
            
        },
        methods: {
            save(){
                let data = {
                    id: this.id,
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    role_id: this.role_id
                };

                axios.post('/user/save',data).then(response => {

                    if(response.status == 200){
                        this.$emit('account',response.data);
                    }

                });
            }
       }
    }
</script>
