<template>
    <div class="">
        <button class="btn btn-primary mb-2 float-right" type="button" data-toggle="modal" data-target="#expense-0">Add</button>
        <newExpense @newExpense="newExpense"></newExpense>
        <table class="table w-100">
            <thead>
                <tr>
                    <td>
                        Name
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="expense in expenses">
                    <td>
                        {{expense.name}}
                    </td>
                    <td>
                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#expense-'+expense.id">
                          Edit
                        </button>
                        <button class="btn btn-danger" @click="deleteexpense(expense)">Delete</button>
                        <expense :expense='expense' @expense="updateExpense"></expense>
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
            expenses: [],
          }
        },
        mounted() {

            axios.get('/expenses/getAll').then(response => {
                this.expenses = response.data;
            });
        },
        methods: {
            updateExpense(expense){
                this.expenses.forEach((value,key) => {
                    if(expense.id == value.id){
                        Vue.set(this.expenses,key,expense);
                        return;
                    }
                });
            },
            newExpense(expense){
                Vue.set(this.expenses,this.expenses.length,expense);
            },
            deleteexpense(expense){
                swal.fire({
                    title: 'Are you sure you want to delete '+ expense.name +'?',
                    icon: 'warning',
                    showCancelButton: true,
                    ConfirmButtonText: 'Delete',
                }).then((result) => {
                    if(result.value){
                        axios.post('/expenses/delete',expense).then(response => {
                                if(response.status == 200){
                                    this.expenses.forEach((value,key) => {
                                        if(expense.id == value.id){
                                            this.expenses.splice(key,1);
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
