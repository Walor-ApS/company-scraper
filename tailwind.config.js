/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                gray: "#F7F8FA",
                darkGray: "#454A56",
                blue: "#247DD0",
                blueOpacity: "rgba(36, 125, 208, 0.25)",
                black: "#111111",
            },
        },
    },
    plugins: [],
};
