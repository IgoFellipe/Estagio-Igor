/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                // Cores Institucionais UniFil
                primary: {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#F08223', // Cor principal da marca
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                    950: '#431407',
                    DEFAULT: '#F08223',
                },
                secondary: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#13294B', // Cor institucional escura
                    950: '#020617',
                    DEFAULT: '#13294B',
                },
                // Alias para compatibilidade
                principal: '#F08223',
                sidebar: '#13294B',
                'sidebar-hover': '#1e293b',
                // Cores de Gamificação
                'unifil-orange': '#F08223',
                'unifil-blue': '#13294B',
                // Medalhas
                gold: '#FFD700',
                silver: '#C0C0C0',
                bronze: '#CD7F32',
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                'glow': '0 0 20px rgba(240, 130, 35, 0.3)',
                'glow-lg': '0 0 40px rgba(240, 130, 35, 0.4)',
                'inner-glow': 'inset 0 0 20px rgba(240, 130, 35, 0.1)',
                'podium': '0 10px 40px -10px rgba(240, 130, 35, 0.5), 0 0 0 4px rgba(240, 130, 35, 0.3)',
                'podium-silver': '0 8px 30px -8px rgba(192, 192, 192, 0.5)',
                'podium-bronze': '0 8px 30px -8px rgba(205, 127, 50, 0.5)',
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.5s ease-out',
                'fade-in-down': 'fadeInDown 0.5s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float': 'float 6s ease-in-out infinite',
                'slide-in-right': 'slideInRight 0.3s ease-out',
                'slide-out-left': 'slideOutLeft 0.3s ease-in',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInDown: {
                    '0%': { opacity: '0', transform: 'translateY(-20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                slideInRight: {
                    '0%': { transform: 'translateX(100%)' },
                    '100%': { transform: 'translateX(0)' },
                },
                slideOutLeft: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },
    plugins: [],
}
