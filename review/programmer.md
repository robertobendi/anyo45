# FRONTEND ENGINEER REVIEW

## What I saw

Four screenshots rendered cleanly. Home desktop (1440px): a two-column hero — olive left block with the white Archivo caps headline "FORM & DESIGN FOR HOW YOU LIVE IN BATANGAS", a Plex-Mono kicker, and a brick "REQUEST CONSULTATION →" button; right panel a SketchUp-style house render inside a teak keyline. Below, giant brick "01"/"02" numerals open teak/cream sections ("A PRACTICE BUILT ON ORDER AND CLIMATE", "ARCHITECTURE, END TO END"). Mobile (375px) stacks the hero, render under the headline. About shows a "04 ABOUT" opener, the og-image lock-up top-right, three h2 story blocks over a faint rotated chain-link monogram watermark, then a full-bleed ref-02 render. Contact shows "05 CONTACT", a bottom-ruled drafting form (NAME/EMAIL/PHONE/PROJECT LOCATION/PROJECT TYPE select/message), a chalk THE STUDIO / FIND US spec panel + context photo, an olive "MESSAGE THE STUDIO ON FACEBOOK" band, and the olive footer.

The markup is genuinely clean — real `<header>/<nav>/<main>/<article>/<footer>` landmarks, inline `<head>` CSS per PebbleStack convention, descriptive `alt` on every `<img>`, label-associated form fields with sensible `type`/`autocomplete`/`required`, a honeypot, `prefers-reduced-motion` handling, and no Twig/Lorem leakage in the HTML body. But the export plumbing and `<head>` metadata are where it falls down: localhost URLs shipped in the SEO files, no Open Graph, a placeholder form action, and root-absolute paths.

## Findings

### Ship blockers (must fix before publish)

- **`sitemap.xml` + `robots.txt`** — `docs/sitemap.xml:4` (`<loc>http://127.0.0.1:50205/</loc>`) and `docs/robots.txt:6` (`Sitemap: http://127.0.0.1:50205/sitemap.xml`) — the exported SEO files point search engines at the dev server's localhost address, and the sitemap lists only the home URL (about/work/services/contact are orphaned from it). → Regenerate both against the production origin and emit one `<url>` per page (`/`, `/work`, `/services`, `/about`, `/contact`).
- **`<head>` Open Graph (all pages)** — no `og:title`/`og:description`/`og:image`/`twitter:card` exist on any page (grep of `docs/*.html` returns zero `og:`/`twitter:` hits), despite the BRIEF naming `og-image.jpg` as the share asset and the firm's whole goal being to share this link off Facebook/Messenger — shares will render as a bare URL with no card. → Add `og:title`, `og:description`, and an absolute `og:image` (the lock-up) plus `twitter:card=summary_large_image` to at least `index.html`.
- **Contact form action** — `docs/contact.html:346` `action="https://formspree.io/f/REPLACE_ME"` — the primary inquiry form POSTs to a placeholder endpoint, so every submission 404s; `REPLACE_ME` is shipped live, not just in the adjacent comment. → Wire the real Formspree form ID before publish (or swap to a working endpoint), since the form is a stated conversion path.

### Important (should fix this revision pass)

- **Root-absolute internal paths (all pages)** — every nav/href and asset uses `/…` (`docs/index.html:341` `href="/work"`, `:334` `src="/uploads/logo.jpg"`, `:8` favicon, hero/work renders) — served from `/docs` with `.nojekyll` this is almost certainly a GitHub Pages **project** site at `user.github.io/<repo>/`, where `/work` and `/uploads/*` resolve to the domain root and 404, taking down nav *and* every image. → Use relative paths (`work.html`, `uploads/…`) or set a `<base>`; also note `/work` (extensionless) only resolves via GitHub's clean-URL handling, not on a generic host or local open.
- **Unoptimized hero/render images** — `docs/uploads/ref-01.png` is 2.4 MB and `ref-02.png` is 4.5 MB; the home page loads ref-01 as the above-the-fold hero LCP (`index.html:385`) *and* again in featured work (`:452`) plus ref-02 (`:469`), ~9 MB of PNGs displayed at small sizes for a mobile-first Batangas audience. → Re-encode the renders as compressed JPG/WebP (sub-300 KB each) and serve appropriately sized variants.
- **No `loading`/`width`/`height` on any `<img>`** — grep finds zero `loading=`, `width=`, or `height=` attributes across `docs/*.html`; below-the-fold renders and the footer logo load eagerly and every image lacks intrinsic dimensions, causing layout shift (CLS). → Add `loading="lazy"` to below-fold images (keep the hero eager, ideally `fetchpriority="high"`) and set `width`/`height` (or `aspect-ratio`) on each.
- **Brand link accessible name** — `aria-label="Anyo45 — home"` on the header brand link on every page (`docs/index.html:333`, and identically in about/services/work/contact) — screen readers announce the repo slug "Anyo45", not the brand; it's also an export identity leak. → Change to `aria-label="Anyo at Disenyo — home"`.
- **Heading-level skips** — Contact goes `<h1>Contact` (`contact.html:337`) straight to `<h3>The studio`/`<h3>Find us` (`:388`,`:397`) before any `<h2>` (the only h2 appears later in the CTA band, `:417`) — a skipped level and out-of-order outline; and on every page the footer "Studio"/"Site" are `<h4>` (`index.html:544`,`:553`) following a page `<h2>`, skipping h3 for visual sizing. → Promote the contact sidebar headings to `<h2>` (or wrap in an `<aside>` to reset context) and lift the footer headings to `<h2>`.

### Nice to have (skip if budget tight)

- **Missing `<link rel="canonical">`** — none of the five pages declare a canonical URL; add one per page to harden against duplicate-URL indexing once the localhost sitemap is fixed.
- **Sidebar landmarks** — the Contact info column (`contact.html:386` `<div>`) and the About spec column are complementary content in bare `<div>`s; wrap as `<aside>` for a cleaner landmark map.
- **Tagalog lang tagging** — `anyo`/`disenyo` are marked `<em>` but not `lang="tl"` (e.g. `index.html:399`, footer `:564`); add `lang="tl"` so screen readers pronounce them correctly.
- **Work placeholder as `<strong>`** — `work.html:437` renders a ~2rem display-font section title via `<strong>` inside `.placeholder`, so it's absent from the heading outline; make it a real `<h2>`/`<h3>` (and note the favicon at `uploads/favicon.ico` is the Facebook "f" the BRIEF warned against using as brand).

## Summary for the synthesiser

The HTML/CSS craft is solid, but the build is unshippable as-is because the export leaks `http://127.0.0.1` into sitemap.xml/robots.txt, has zero Open Graph tags, and posts the contact form to a `REPLACE_ME` placeholder — three deterministic publish blockers in the plumbing, not the pixels.
