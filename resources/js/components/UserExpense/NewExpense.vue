<template>
    <!-- Modal -->
    <div class="modal fade" :id="'expense-0'" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">
                <b>New Expense</b>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form >
              <div class="form-group">
                    <label for="">Expense Category</label>
                    <select class="form-control" v-model="expense_cat_id">
                        <option v-for="expenseCat in expenseCats" :value="expenseCat.id">{{expenseCat.name}}</option>
                    </select>
              </div>
              <div class="form-group">
                  <label for="">Amount</label>
                  <input type="number" class="form-control" v-model.number="amount">
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
        props: ['expenseCats'],
        data(){
          return{
            id:  0,
            amount: 0,
            expense_cat_id: 0,
          }
        },
        mounted() {
            
        },
        methods: {
            save(){
                let data = {
                    id: this.id,
                    amount: this.amount,
                    expense_cat_id: this.expense_cat_id,
                };

                axios.post('/user-expenses/save',data).then(response => {

                    if(response.status == 200){
                        this.$emit('newExpense',response.data);
                    }

                });
            }
       }
    }
</script>
