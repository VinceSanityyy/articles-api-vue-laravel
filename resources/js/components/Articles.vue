<template>
<v-app>
    <div>
        <h2>
            Articles
        </h2>
    <form class="mb-3" @submit.prevent="addArticle">
        <div class="form-group">
           <input type="text" class="form-control" placeholder="Title" v-model="article.title">
        </div>
         <div class="form-group">
           <textarea type="text" class="form-control" placeholder="Body" v-model="article.body"> </textarea>
        </div>
        <button type="submit" class="btn btn-block btn-primary">Save</button>
    </form>
        <nav aria-label="Page navigation example">


  <ul class="pagination">
    <li v-bind:class="[{disabled: !pagination.prev_page}]" class="page-item"><a @click="fetchArticles(pagination.prev_page)" class="page-link" href="#">Previous</a></li>
        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
    <li v-bind:class="[{disabled: !pagination.next_page}]" class="page-item"><a  @click="fetchArticles(pagination.next_page)" class="page-link" href="#">Next</a></li>
  </ul>
</nav>

 <br>
        <div class="card card-body" v-for="article in articles" v-bind:key="article.id">
            <h3>{{article.title}}</h3>
            <p>{{article.body}}</p>
            <hr>


<button @click="editArticle(article)" type="button" class="btn btn-warning mb-2">
  Edit
</button>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
  Delete
</button>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class
  ="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Delete article?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button @click="deleteArticle(article.id)" type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>

      </div>
    </div>
  </div>
</div>



<!-- success -->

<div id="successModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4>Alert</h4>
            </div>
            <div class="modal-body">
               Successfully added!
            </div>
        </div>
    </div>
</div>


</div>
</div>

</v-app>

</template>


<script>
export default {
    data(){
        return{

            articles: [],
            article: {
                id:'',
                title: '',
                body: ''
            },
            article_id: '',
            pagination:{},
            edit: false,


        }
    },
    created(){
        this.fetchArticles();
    },
    methods:{
        fetchArticles(page_url){
            let vm = this;
            page_url = page_url || 'api/articles'
            fetch(page_url)
            .then(res=>res.json())
            .then(res=>{
                this.articles = res.data;
                vm.makePagination(res.meta, res.links);
            })
            .catch((err)=>{
                console.log(err);
            })
        },
        makePagination(meta, links){
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page: links.next,
                prev_page: links.prev
            }
            this.pagination = pagination;
        },
        deleteArticle(id){

             fetch(`api/article/${id}`,{
                    method: 'delete'
                })
                .then(data=>{
                    this.fetchArticles();
                    console.log('deleted')
                })
        },
        addArticle(){
            if(this.edit === false){
                fetch('api/article',{
                    method: 'POST',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type' : 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('added');
                    this.fetchArticles();
                })
                .catch(err => console.log(err));
            }
            else {
                 fetch('api/article',{
                    method: 'PUT',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type' : 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('updated');
                    this.fetchArticles();
                })
                .catch(err => console.log(err));
            }
        },
        editArticle(article){
            this.edit = true;
            this.article.id = article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        }
    }
}
</script>

