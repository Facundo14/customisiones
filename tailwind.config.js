/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./*.php",
    "./**/*.php"
  ],
  theme: {
    extend: {
      colors: {
        custom: {
            primary: '#7A4F3A',
            accent: '#D4A65A',
            bg: '#F5F2EC',
            white: '#FFFFFF',
            text: '#2B2B2B',
            subtext: '#6B6B6B',
            darkbg: '#1E1E1E',
            darkcards: '#2A2A2A',
            darktext: '#F5F2EC'
        }
      },
      fontFamily: {
        title: ['"Playfair Display"', 'serif'],
        sans: ['Montserrat', 'system-ui', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
