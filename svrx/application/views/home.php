

<div id="app" class="nt-frame">
    <div class="nt-title">
        <label class="fs14">创建账户</label>
    </div>
    <div class="nt-list">
        <ul class="nt-list-ul nt-list-ul-md4">
        <li>
                <label class="nt-list-label"><span class="red mr5">*</span>名称：</label>

                <div class="nt-list-input">
                    <input type="text" placeholder="请输入" class="nt-input" v-model="name" />
                </div>
        </li>

        <li>
                <label class="nt-list-label"><span class="red mr5">*</span>类型：</label>

                <div class="nt-list-input">
                    <input type="text" placeholder="请输入" class="nt-input" v-model="type" />
                </div>
        </li>
        <li>
                <label class="nt-list-label"><span class="red mr5">*</span>地址：</label>

                <div class="nt-list-input">
                    <input type="text" placeholder="请输入" class="nt-input" v-model="url" />
                </div>
        </li>
        <li>
                <label class="nt-list-label"><span class="red mr5">*</span>用户名：</label>

                <div class="nt-list-input">
                    <input type="text" placeholder="请输入" class="nt-input" v-model="username" />
                </div>
        </li>
        <li>
                <label class="nt-list-label"><span class="red mr5">*</span>密码：</label>

                <div class="nt-list-input">
                    <input type="text" placeholder="请输入" class="nt-input" v-model="password" />
                </div>
        </li>
      </ul>
      <p class="cl"></p>
      <div class="textC nt-operation">
        <button type="button" class="nt-btn nt-green" v-on:click="setusers">保存</button>
      </div>
</div>
<script type="text/javascript">
var app = new Vue({
  el: '#app',
  data: {
    name:'',
    type:'',
    url:'http://',
    username:'',
    password:''
  },
  methods: {
    getusers: function () {
        this.$http.get('/index.php/api/getusers').then(function(response) {
            this.$set('json', response.data);
            console.log(response.data);
        },
        function(response, status, request) {
            console.log('fail' + status + "," + request);
        })
    },
    setusers: function () {
        var item = {
          'name':this.name,
          'type':this.type,
          'url':this.url,
          'username':this.username,
          'password':this.password
        };
        this.$http.post('/index.php/api/setusers',item).then(function(response) {
            this.$set('json', response.data);
            console.log(response.data);
        },
        function(response, status, request) {
            console.log('fail' + status + "," + request);
        })
    }
  }
})
</script>