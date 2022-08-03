module.exports = {
  env: {
    browser: true,
    es6: true,
    mocha: true,
    node : true
  },
  plugins: ['mocha'],
  extends: 'eslint:recommended',
  parserOptions: {
    'ecmaVersion': 2020,
    'sourceType': 'module'
  },
  rules: {
    indent: ['error', 2],
    quotes: ['error', 'single'],
    semi: ['error', 'always']
  }
};
