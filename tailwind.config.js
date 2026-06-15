/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        govblue: {
          50: '#f0f4fe',
          100: '#dbe5fc',
          200: '#bfd2fa',
          300: '#93b4f6',
          400: '#608ef1',
          500: '#3866ea',
          600: '#254adc',
          700: '#1d3abf',
          800: '#1d329b',
          900: '#1d2c7b',
          950: '#11194b',
        },
      },
    },
  },
  plugins: [],
}
