<template>
  <div class="quality-bar">
    <div class="row" :style="`height: ${height}px`">
      <div class="bar-wrap">
        <div class="bar in" :style="`width: ${quality}%`"></div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.quality-bar {
    width: 100%;
    max-height: 35px;
}
.quality-bar .row {
  position: relative;
  margin: 4px 0 4px 0;
}
.quality-bar .bar-wrap {
  position: relative;
  background: #ee557b;
  width: 100%;
  height: 100%;
  overflow: hidden;
}
.quality-bar .bar-wrap .bar {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background: linear-gradient(45deg, #7fc3ff, #6bb6ff);
  transition: all 1s;
  transform: translateX(-100%);
}
.quality-bar .bar-wrap .bar.in {
  transform: translateX(0%);
}
</style>

<script>
export default {
	name: 'QualityBar',
  props: {
    quality: {type: [String, Number], required: true},
    height: {type: [String, Number], default: 26},
  },
	data() {
		return {

		}
	}
}
</script>
