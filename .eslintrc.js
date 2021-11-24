module.exports = {
  env: {
    browser: true,
    es6: true,
    mocha: true
  },
  plugins: ['mocha'],
  extends: 'eslint:recommended',
  parserOptions: {
    sourceType: 'module'
  },
  rules: {
    'indent': ['error', 2],
    'quotes': ['error', 'single'],
    'no-undef': ['off'],
    'semi': ['error', 'always']
  },
};
