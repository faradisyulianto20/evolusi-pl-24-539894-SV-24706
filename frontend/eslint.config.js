import pluginVue from 'eslint-plugin-vue'

export default [
  // Gunakan config "flat" ESLint 8/9 yang kompatibel dengan eslint-plugin-vue v9
  ...pluginVue.configs['flat/recommended'],
  {
    rules: {
      // Aturan Vue – wajib lulus di CI
      'vue/multi-word-component-names': 'off', // komponen satu kata seperti App.vue diizinkan
      'vue/no-unused-vars': 'warn',
    },
  },
]
