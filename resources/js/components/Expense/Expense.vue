<template>
    <!-- Modal -->
    <div class="modal fade" :id="'expense-'+expense.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">
                <b>{{expense.name}}</b>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form >
                <div class="form-group">
                    <label for="">Expense Name</label>
                    <input type="text" class="form-control" v-model="name">
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
        props: ['expense'],
        data(){
          return{
            id:  this.expense.id,
            name: this.expense.name,
          }
        },
        mounted() {
            
        },
        methods: {
            save(){
                let data = {
                    id: this.id,
                    name: this.name,
                };

                axios.post('/expenses/save',data).then(response => {

                    if(response.status == 200){
                        this.$emit('expense',response.data);
                    }

                });
            }
       }
    }
</script>
