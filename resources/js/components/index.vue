<template>
    <div class="card">
        <div class="card-body">
            <div v-if="!user">
                <h5 card-title>Login</h5>
                <login @user='login'></login>
            </div>
            <div v-else>
                <button class="btn btn-danger float-right" @click="logout()">Logout</button>
                <button class="btn btn-secondary float-right mr-1" data-toggle="modal" data-target="#changePassword">Change Password</button>
                <!-- Modal -->
                <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">
                            <b>Change Password</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form >
                            <div class="form-group">
                                <label for="">Current Password</label>
                                <input class="form-control" type="password" v-model='password'>
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input class="form-control" type="password" v-model='newPassword'>
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input class="form-control" type="password" v-model='reNewPassword'>
                            </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="changePassword()">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                <h5 class="card-title" v-html="title">{{title}}</h5>
                <div class="card-body">
                    <div class="navigation">
                        <ul class="nav justify-content-center"> 
                            <li>
                                <button class="btn btn-primary" value="1" @click="changeNav($event)">Dashboard</button>
                            </li>
                            <li v-if="user.role.access.includes(1)">
                                <button class="btn btn-secondary" value="2" @click="changeNav($event)">Expenses</button>
                            </li>
                            <li v-if="user.role.access.includes(2)">
                                <button class="btn btn-secondary" value="5" @click="changeNav($event)">Expenses Category</button>
                            </li>
                            <li v-if="user.role.access.includes(2)">
                                <button class="btn btn-secondary" value="3" @click="changeNav($event)">Accounts</button>
                            </li>
                            <li v-if="user.role.access.includes(2)">
                                <button class="btn btn-secondary" value="4" @click="changeNav($event)">Roles</button>
                            </li>
                        </ul>
                    </div>
                    <div class="" v-if="selectedView == 1">
                        <chart></chart>
                    </div>
                    <div class="" v-else-if="selectedView == 2">
                        <user-expenses></user-expenses>
                    </div>
                    <div class="" v-else-if="selectedView == 3">
                        <div v-if="user.role_id == 1">
                            <accounts></accounts>
                        </div>
                        <div v-else>
                            <account :account="user"></account>
                        </div>
                    </div>
                    <div class="" v-else-if="selectedView == 4">
                        <roles></roles>
                    </div>
                    <div class="" v-else-if="selectedView == 5">
                        <expenses></expenses>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
            user: null,
            selectedView: 1,
            title: 'Dashboard',
            password: '',
            newPassword: '',
            reNewPassword: '',
          }
        },
        mounted() {
            axios.get('getCurrentUser').then(response => {
                this.user = response.data;
            });
        },
        methods: {
            logout(){
                axios.get('logout').then(response => {
                    this.user = response.data;
                });
            },
            login(e){
                this.user = e;
            },
            changeNav(event){
                this.selectedView = event.toElement.value;
                this.title = event.toElement.innerText;
            },
            changePassword(){
                let data = {
                    password: this.password,
                    newPassword: this.newPassword,
                    reNewPassword: this.reNewPassword
                };

                axios.post('/user/changePassword',data).then(response => {
                    if(response.status == 200){
                        swal.fire('Successfully Change Password');
                    }else{
                        swal.fire('Error Changing Passowrd');
                    }
                });
            }

        }
    }
</script>

<style scoped>

</style>