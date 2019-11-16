<template>
    <div class="">
        <button class="btn btn-primary mb-2 float-right" type="button" data-toggle="modal" data-target="#expense-0">Add</button>
        <user-newExpense :expenseCats="expenseCats" @newExpense="newExpense"></user-newExpense>
        <table class="table w-100">
            <thead>
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        Amount
                    </td>
                    <td>
                        User
                    </td>
                    <td>
                        Date
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="expense in expenses">
                    <td>
                        {{expense.category.name}}
                    </td>
                    <td>
                        {{expense.amount}}
                    </td>
                    <td>
                        {{expense.user.name}}
                    </td>
                    <td>
                        {{expense.created_at}}
                    </td>
                    <td>
                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#expense-'+expense.id">
                          Edit
                        </button>
                        <button class="btn btn-danger" @click="deleteexpense(expense)">Delete</button>
                        <user-expense :expense='expense' :expenseCats='expenseCats' @expense="updateExpense"></user-expense>
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
            expenseCats: [],
          }
        },
        mounted() {

            axios.get('/user-expenses/getAll').then(response => {
                this.expenses = response.data;
            });

            axios.get('/expenses/getAll').then(response => {
              this.expenseCats = response.data;
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
                    title: 'Are you sure you want to delete '+ expense.category.name +'?',
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
