<template>
    <div class="">
        <button class="btn btn-primary mb-2 float-right" type="button" data-toggle="modal" data-target="#role-0">Add</button>
        <newRole @role='newRole'></newRole>
        <table class="table w-100">
            <thead>
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="role in roles">
                    <td>
                        {{role.name}}
                    </td>
                    <td>
                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#role-'+role.id">
                          Edit
                        </button>
                        <button class="btn btn-danger" @click="deleteRole(role)">Delete</button>
                        <role :role='role' @role="updateRole"></role>
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
            roles: [],
          }
        },
        mounted() {
            axios.get('/roles/getAll').then(response => {
                this.roles = response.data;
            });
        },
        methods: {
            addToForm(account){
                // this.currentAccount = account;
            },
            updateRole(role){
                console.log(role);
                this.roles.forEach((value,key) => {
                    if(role.id == value.id){
                        Vue.set(this.roles,key,role);
                        return;
                    }
                });
            },
            newRole(role){
                Vue.set(this.roles,this.roles.length,role);
            },
            deleteRole(role){
                swal.fire({
                    title: 'Are you sure you want to delete '+ role.name +'?',
                    icon: 'warning',
                    showCancelButton: true,
                    ConfirmButtonText: 'Delete',
                }).then((result) => {
                    if(result.value){
                        axios.post('/roles/delete',role).then(response => {
                                if(response.status == 200){
                                    this.roles.forEach((value,key) => {
                                        if(role.id == value.id){
                                            this.roles.splice(key,1);
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
