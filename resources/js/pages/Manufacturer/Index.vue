<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';

defineProps({
    message: String
});
</script>
<template>
    <AppLayout>
            <h2>
                {{message}}
            </h2>
    </AppLayout>
</template>