import './bootstrap';


import SermonForm from "./components/NewSermonForm.vue";
import Axios from 'axios';

var app = new Vue({
    el: '#appId',
    data: {
        sheekhList: [],
    },
    mounted() {

        var data = new FormData();
        var _this = this;
        data.append('api_token', window.api_token)
        Axios.post(
            '/api/sheekhs', data
        ).then((res) => {
            if (res.data["isSuccess"] == true) {
                _this.sheekhList = res.data["data"];
            }
        }).catch((err) => {
            console.log('server error ', err.message);
        });
    },
    methods: {},
    components: {
        'sermon-form': SermonForm,
    }
});