import './bootstrap';

import Lesson from './classes/Lesson';

import LessonForm from "./components/NewLessonForm.vue";

var app = new Vue({
    el: '#appId',
    data: {
        Lessons: [new Lesson()],
    },
    mounted() {

    },
    methods: {
        AddNewLesson() {
            this.Lessons.push(new Lesson());
        }
    },
    components: {
        'lesson-form': LessonForm,
    }
});