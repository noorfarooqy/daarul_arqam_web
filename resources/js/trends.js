import './bootstrap';


import Axios from 'axios';
import Server from './Server';

var app = new Vue({
    el: '#appId',
    data: {
        Server: new Server(),
    },
    mounted() {

    },
    methods: {
        showError(error) {
            alert(error);
        },
        addTrend(trend) {
            switch (trend) {
                case 1:
                    this.addSheekhTrend()
                    break;
                case 2:
                    this.addBookTrend()
                    break;
                case 3:
                    this.addLessonTrend()
                    break;
                case 4:
                    this.addSermonTrend()
                    break;

                default:
                    break;
            }
        },
        addSheekhTrend() {
            var fd = new FormData(this.$refs.sheekhTrend);
            this.Server.setRequest(fd);
            this.Server.serverRequest(
                '/api/trending',
                this.trendAdded,
                this.showError,
            )
        },
        addBookTrend() {
            var fd = new FormData(this.$refs.bookTrend);
            this.Server.setRequest(fd);
            this.Server.serverRequest(
                '/api/trending',
                this.trendAdded,
                this.showError,
            )
        },
        addLessonTrend() {
            var fd = new FormData(this.$refs.lessonTrend);
            this.Server.setRequest(fd);
            this.Server.serverRequest(
                '/api/trending',
                this.trendAdded,
                this.showError,
            )
        },
        addSermonTrend() {
            var fd = new FormData(this.$refs.sermonTrend);
            this.Server.setRequest(fd);
            this.Server.serverRequest(
                '/api/trending',
                this.trendAdded,
                this.showError,
            )
        },
        trendAdded(data) {
            alert('successfully added trend');
        },
    },
    components: {}
});