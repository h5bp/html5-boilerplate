import globals from 'globals';
import js from '@eslint/js';
import mocha from 'eslint-plugin-mocha';
import { defineConfig } from 'eslint/config';

export default defineConfig([
  {
    files: ['**/*.js'],
    plugins: {
      js,
      mocha,
    },
    languageOptions: {
      ecmaVersion: 2020,
      sourceType: 'module',
      globals: {
        ...globals.browser,
        ...globals.node,
        ...globals.mocha,
      },
    },
    extends: ['js/recommended'],
    rules: {
      // Your custom rules
      indent: ['error', 2],
      quotes: ['error', 'single'],
      semi: ['error', 'always'],
    },
  },
]);
