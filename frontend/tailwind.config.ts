import type { Config } from 'tailwindcss'

export default {
    content: [
        './src/pages/**/*.{js,ts,jsx,tsx,mdx}',
        './src/components/**/*.{js,ts,jsx,tsx,mdx}',
        './src/app/**/*.{js,ts,jsx,tsx,mdx}',
    ],
    theme: {
        extend: {
            colors: {
                background: 'var(--background)',
                foreground: 'var(--foreground)',
                bg_primary: 'var(--bg-primary)',
                bg_secondary: 'var(--bg-secondary)',
                bg_tertiary: 'var(--bg-tertiary)',
            },
        },
    },
    plugins: [],
} satisfies Config
