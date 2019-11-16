<template>
    <div class="">
        <button class="btn btn-primary mb-2 float-right" type="button" data-toggle="modal" data-target="#account-0">Add</button>
        <newAccount :roles="roles" @account='newAccount'></newAccount>
        <table class="table w-100">
            <thead>
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        Email
                    </td>
                    <td>
                        Role
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="account in accounts">
                    <td>
                        {{account.name}}
                    </td>
                    <td>
                        {{account.email}}
                    </td>  
                    <td>
                        {{account.role.name}}
                    </td>
                    <td>
                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#account-'+account.id">
                          Edit
                        </button>
                        <button class="btn btn-danger" @click="deleteAccount(account)">Delete</button>
                        <account :roles="roles" :account='account' @account="updateUsers"></account>
                    </td>
                    
                </tr>
                
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data(){
          return{
            accounts: [],
            roles: [],
          }
        },
        mounted() {

            axios.get('user/all').then(response => {
                this.accounts = response.data;
            });

            axios.get('/roles/getAll').then(response => {
                this.roles = response.data;
            });
        },
        methods: {
            addUser(){
                alert('test');
            },
            addToForm(account){
                this.currentAccount = account;
            },
            updateUsers(account){
                this.accounts.forEach((value,key) => {
                    if(account.id == value.id){
                        Vue.set(this.accounts,key,account);
                        return;
                    }
                });
            },
            newAccount(account){
                Vue.set(this.accounts,this.accounts.length,account);
            },
            deleteAccount(account){
                swal.fire({
                    title: 'Are you sure you want to delete '+ account.name +'?',
                    icon: 'warning',
                    showCancelButton: true,
                    ConfirmButtonText: 'Delete',
                }).then((result) => {
                    if(result.value){
                        axios.post('/user/delete',account).then(response => {
                                if(response.status == 200){
                                    this.accounts.forEach((value,key) => {
                                        if(account.id == value.id){
                                            this.accounts.splice(key,1);
                                        }
                                    });
                                }
                            });
                    }
                });
            }
       }
    }
</script>
