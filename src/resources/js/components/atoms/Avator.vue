<template>
    <v-avatar :color="color" :size="size">
        <img v-show="src" :src="src" :alt="alt" />
    </v-avatar>
</template>

<script>
export default {
    name: "Avator",
    props: {
        color: { type: String, default: "grey lighten-3" },
        size: { type: [String, Number], default: 36 },
        src: { type: String, default: null },
        alt: { type: String, default: "" }
    },
    data() {
        return {
            //
        };
    }
};
</script>
