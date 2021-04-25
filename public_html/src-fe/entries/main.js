import Vue from "vue";
import slideshow from "../components/slideshow/slideshow";

new Vue({
    el: "#app",
    components: {
        slideshow: slideshow
    },
    created() {
        console.info('OSM app created! !!');
    }
});