<template>
  <div id="slideshow">
    <div class="current" :style="getCurrentStyle"></div>
    <div class="next" :style="getNextStyle" v-if="isAnimating"></div>
    <img class='overlay' src='/assets/images/html/top_overlay.png' alt=''/>
    <img class='tools' src='/assets/images/html/tools.png' alt=''/>
  </div>
</template>

<script>

import $ from 'jquery';

export default {
  name: "slideshow",
  data() {
    return {
      currentIndex: 1,
      maxIndex: 9,
      isAnimating: false,
      speed: 4000 // ms
    };
  },
  mounted() {
    setInterval(() => this.animateSlideshow(), this.speed);
  },
  methods: {
    animateSlideshow() {
      const current = $("#slideshow .current");
      const next = $("#slideshow .next");

      this.isAnimating = true;
      current.animate({
        opacity: 0
      }, this.speed / 2, () => {
        current.css({opacity: 1});
        this.currentIndex = this.getNextIndex();
        this.isAnimating = false;
      });

    },
    getNextIndex() {
      return this.currentIndex + 1 <= this.maxIndex ? this.currentIndex + 1 : 1;
    },
    getUrlByIndex(index) {
      return "/assets/images/slides/" + index + ".png";
    }
  },
  computed: {
    getCurrentStyle() {
      return {
        backgroundImage: 'url(' + this.getUrlByIndex(this.currentIndex) + ')'
      };
    },
    getNextStyle() {
      return {
        backgroundImage: 'url(' + this.getUrlByIndex(this.getNextIndex()) + ')'
      }
    }
  }
}
</script>