import daisyui from "daisyui"

module.exports = {
  purge: ['./php/**/*.php', './js/**/*.ts'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
         daisyui,
  ],
}

 // purge: ['./public/index.html', './src/**/*.ts'],
