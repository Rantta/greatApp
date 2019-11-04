<template>
    <div class="container">
        <div class="row ">
            <div class="col-md-12 mt-3">
             <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background-image: url('./img/cover.jpg');">
                <h3 class="widget-user-username">{{form.name}}</h3>
                <h5 class="widget-user-desc">{{form.type}}</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="changePic()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              </div>

            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                   
                    <p>User Activity</p>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input type="text" v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" id="inputName" placeholder="Name">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input type="email" v-model="form.email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" id="inputEmail" placeholder="Email">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                        <div class="col-sm-10">
                          <textarea class="form-control" v-model="form.bio" :class="{ 'is-invalid': form.errors.has('bio') }" id="inputExperience" placeholder="Experience"></textarea>
                          <has-error :form="form" field="bio"></has-error>
                        </div>
                      </div>
                       <div class="form-group">
                        <label for="inputName2" class="col-sm-2 control-label">Photo</label>

                        <div class="col-sm-10">
                          <input type="file" @change='fileSelected' class="" id="" placeholder="Photo">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label" style=";">Passport (leave it empty if not changing)</label>

                        <div class="col-sm-10">
                          <input type="password" v-model="form.password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" id="inputSkills" placeholder="Passport">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" @click="updateInfo" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            <!-- /.nav-tabs-custom -->
          </div>
            </div>
        </div>
    </div>
</template>
<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    min-height: 350px;
}
</style>
<script>
    export default {
        data() {
            return {
             form: new Form({
                   id:'',
                   name :'',
                   email :'',
                   password :'',
                   type :'',
                   bio :'',
                   photo :''
              })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods :{
              fileSelected(event){
                let file = event.target.files[0];
                let reader  = new FileReader();
                if(file['size'] < 2111775) {
                  reader.onloadend = (file) => {
                  this.form.photo = reader.result;
                  this.form.put('api/profile/');
                  axios.get('api/profile').then(({data}) => (this.form.fill(data)));
                }
                reader.readAsDataURL(file);
                }else{
                Swal.fire(
                    'Error!',
                    'The File Size Is larger Than 2MB',
                    'error'
                    )
                }
                
              },
              updateInfo(){
                this.$Progress.start();
                this.form.put('api/profile/')
                .then(()=> {
                  this.$Progress.finish()
                })
                .catch(() => {
                   this.$Progress.fail()
                });
              },
               changePic(){
                 if(this.form.photo !== ""){
                    return 'img/profile/' + this.form.photo;
                 }else{
                   return './img/profile/profile.png';
                 }
                
              }   
        },
        created() {
         axios.get('api/profile').then(({data}) => (this.form.fill(data)));
        }
    }
</script>
