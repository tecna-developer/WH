# 📱 WH - E-Commerce Website | Frontend Practice Project

A modern, responsive e-commerce website built with **vanilla JavaScript**, **SCSS**, and **Vite**. This is an **educational project** for practicing and mastering web development skills.

## 🎯 Learning Objectives

This project focuses on practicing:

- **Semantic HTML5** markup
- **Advanced CSS/SCSS** architecture with modular structure (BEM methodology)
- **Vanilla JavaScript** with ES6+ features
- **Responsive web design** and mobile-first approach
- **Modern build tools** and asset optimization
- **Working with libraries** (Swiper for carousels, CSS normalization)

## 🛠 Tech Stack

- **Build Tool:** [Vite](https://vitejs.dev/) - Next generation frontend tooling
- **Styling:** SCSS with modular architecture
- **JavaScript:** Vanilla ES6+
- **Libraries:**
  - [Swiper](https://swiperjs.com/) - Touch slider library
  - [@a1rth/css-normalize](https://www.npmjs.com/package/@a1rth/css-normalize) - CSS normalization
- **Image Optimization:** Multiple image formats (AVIF, responsive sizes)

## 📦 Project Structure

```
src/
├── scss/              # Modular SCSS architecture
│   ├── base/         # Global styles, typography
│   ├── blocks/       # Page-specific components
│   ├── ui/           # Reusable UI components
│   └── helpers/      # Mixins and variables
├── js/               # JavaScript modules
├── image/            # Optimized images (multiple formats)
└── icons/            # SVG icons
```

## 🚀 Getting Started

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

## 🧵 WordPress theme (`wp-theme/`)

This same source (`src/`, SCSS, JS) also drives a WooCommerce theme that lives in
[`wp-theme/`](wp-theme/). Both targets share the SCSS/JS source and build with
Vite, but through separate configs and outputs:

| | static site (this README's `npm run build`) | WordPress theme |
|---|---|---|
| Config | `vite.config.js` | `vite.theme.config.js` |
| Entry | the six `*.html` pages | `src/main.js` only |
| Output | `dist/` | `wp-theme/build/` (gitignored) |
| Consumed by | GitHub Pages | `wp-theme/functions.php`, via a manifest lookup |

```bash
# One-off build of the theme's CSS/JS
npm run build:theme

# Rebuild on every save (use this while developing the theme)
npm run watch:theme
```

`functions.php` reads `wp-theme/build/.vite/manifest.json` and enqueues the
hashed CSS/JS it points to — there's nothing to wire up by hand after a build.

**Local dev:** the theme folder itself isn't copied anywhere. Point your local
WordPress install's `wp-content/themes/wh` at `wp-theme/` with a directory
junction (Windows; no admin rights needed, unlike a symlink):

```powershell
cmd /c mklink /J "<path to Local site>\app\public\wp-content\themes\wh" "<repo>\wp-theme"
```

Static assets that aren't run through Vite (placeholder product photos, the
presentation/Instagram images) live under `wp-theme/assets/` and are tracked
in git as-is.

**Deploying to the live site:** every push to `main` that touches the theme or
its sources runs [`deploy-theme.yml`](.github/workflows/deploy-theme.yml), which
builds `wp-theme/build/` and uploads the whole `wp-theme/` folder over FTP. Only
changed files travel — the action keeps a `.ftp-deploy-sync-state.json` on the
server. You can also start it by hand from the Actions tab (`Run workflow`).

Because `wp-theme/build/` is gitignored, merging a change is never enough on its
own: the theme has to be rebuilt and re-uploaded, which is exactly what this
workflow automates.

Configure it once under **Settings → Secrets and variables → Actions**:

| Name | Kind | Value |
|---|---|---|
| `FTP_SERVER` | secret | FTP host, e.g. `ftp.example.com` (no `ftp://`) |
| `FTP_USERNAME` | secret | FTP account login |
| `FTP_PASSWORD` | secret | FTP account password |
| `FTP_SERVER_DIR` | secret **or** variable | **required** — path to the theme on the server, with a trailing slash, e.g. `/public_html/wp-content/themes/wh/`. GitHub won't let a variable reuse a name an existing secret already holds, so the workflow reads whichever one exists |
| `FTP_PROTOCOL` | variable | `ftps` (default) or `ftp` if the host has no TLS |

`FTP_SERVER_DIR` has no default on purpose: a wrong path would quietly build a
tree of files at the FTP root instead of inside WordPress. The run stops before
connecting if it is unset or missing its trailing slash. Find the real path in
your hosting's file manager — it's wherever `wp-config.php` lives, plus
`wp-content/themes/wh/`.

## ✨ Features

- Responsive design for mobile, tablet, and desktop
- Image optimization with AVIF format support
- Modular SCSS with CSS-in-JS variables
- Smooth transitions and animations
- Interactive sliders and carousels
- Product catalog and shopping interface
- Contact form
- Social media integration

## 📚 Key Pages

- **index.html** - Home/landing page
- **shop.html** - Product catalog and shopping
- **contacts.html** - Contact and information page

## 📝 License

This is an educational project created for learning purposes.
