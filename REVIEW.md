# REVIEW

## Visual evaluation

### What I saw

The home hero genuinely lands the brief's chosen family: a flat moss-olive
block fills the left ~58% carrying "FORM & DESIGN FOR HOW YOU LIVE IN BATANGAS"
in heavy expanded caps at real display scale (line-height ~0.92, one word per
line), a Plex-Mono kicker, and a hard brick "REQUEST CONSULTATION →" button; the
right ~42% is the ref-01 SketchUp render behind a teak keyline tagged "ANYO AT
DISENYO · CONCEPT RENDER". The eye lands on the headline first, then the render —
this reads unmistakably as Vignelli/Rand Swiss color-block, not warm-minimalism.
The display type did NOT collapse to a polite 3rem; the giant brick numerals,
teak/sage bands, mono spec rows, and ghosted monogram on the About page all
ship in pixels. The palette is the real eight-shade earth system on drafting
cream `#ECE7D9`, not the "3 neutrals + 1 accent" failure mode.

Two weaknesses are visible at first look. The signature numeral device only half
landed: "01" sits in a clear gap *above* "A PRACTICE BUILT ON ORDER AND CLIMATE"
rather than overlapping it, so the defining graphic move reads as a conventional
big label. And the hero headline fills its column to zero slack — "BATANGAS" is
hard against the teak keyline with no margin — which the CSS shows will truncate
at common laptop widths. The teak band under section 01 also barely separates
from the cream surface, softening the color-block rhythm.

### Visual pass/fail checks

- **No clipped or colliding content** — PASS. In the two home captures and the
  about/contact captures no character is occluded: "01" sits above (not over)
  its H2, hero text and render are split by the teak keyline, the About watermark
  is ghosted behind legible body copy. CAVEAT: "BATANGAS" (screenshot-home-desktop,
  hero left block) renders flush to the keyline with ~0px slack, and `.hero__left`
  `overflow:hidden` + the `clamp(3.2rem,8vw,6.5rem)` display cap mean the final
  "S" silently truncates at the very common 1280–1366px laptop band — escalated
  to Must Fix as the build's main layout-integrity risk.
- **Logo visible in header** — PASS. screenshot-home-desktop top-left shows the
  real cropped og-image monogram + "ANYO AT DISENYO / ARCHITECTURAL SERVICES".
- **First-glance family recognizable** — PASS. The olive color-block hero + giant
  brick numerals + mono labels read as Swiss/mid-century print in under a second.
- **Decorative system visible** — PASS. Well over two motifs: giant numerals,
  teak keyline render frames, olive/teak/sage bands, mono spec rows, baseline
  rules, and the ghosted rotated monogram (About).
- **Source imagery placed** — PASS. The firm's own ref-01 and ref-02 renders
  carry the hero + featured work + About philosophy image, plus a captioned
  Batangas context photo on Contact — not stock.
- **Mobile holds** — PASS. screenshot-home-mobile stacks the hero to a single
  olive column with the headline ("BATANGAS" fits at 375px), render below, CTA
  intact; no collision or clipping.

## Council consolidation

- **Designer**: The Swiss system shipped at real scale but the signature numeral
  bleeds left without overlapping the heading, `.meaning-big` outweighs its own
  H2, the hero rag orphans "IN", and the teak band reads too close to cream.
- **UX**: 5-second test and funnel pass, but the conversion path is broken (form
  posts to a dead `REPLACE_ME` endpoint) and the credibility being sold is
  unproven (no phone/hours, no named licensed architect, only unbuilt renders).
- **UI**: Hero headline fills its column with zero slack so "BATANGAS" truncates
  at 1280–1366px; nav links have no resting affordance; required form fields are
  unmarked.
- **Colour**: Palette fidelity is genuinely good, but text-over-colour fails AA
  across the build — headlined by the primary CTA label at 4.38:1.
- **Programmer**: Clean markup, but three deterministic publish blockers in the
  plumbing — localhost URLs in sitemap.xml/robots.txt, zero Open Graph tags, and
  the `REPLACE_ME` form action — plus root-absolute paths that 404 on a project
  Pages site.

Shared issues named once: broken contact form (UX + Programmer); text-over-colour
contrast incl. the CTA (Colour, intersecting the CTA all roles depend on); hero
headline zero-slack (UI, with Designer's rag note on the same line).

## Prioritised findings

### Must fix (revision will close these)

- **Contact form action** — `docs/contact.html:346` `action="https://formspree.io/f/REPLACE_ME"` — the build's primary conversion mechanism POSTs to a dead placeholder, so every "Send request" silently 404s (UX + Programmer ship blocker). — Wire the real Formspree ID, or until it exists replace the `<form>` with the working Messenger CTA so no submit can fail silently.
- **SEO export points at localhost** — `docs/sitemap.xml:4` `<loc>http://127.0.0.1:50205/</loc>` and `docs/robots.txt:6` `Sitemap: http://127.0.0.1:50205/...`, and the sitemap lists only the home URL — search engines get the dev server and four orphaned pages. — Regenerate both against the production origin and emit one `<url>` per page (`/`, `/work`, `/services`, `/about`, `/contact`).
- **No Open Graph / Twitter tags** — grep of `docs/*.html` returns zero `og:`/`twitter:` hits despite the firm's whole goal being to share the link off Facebook/Messenger; shares render as a bare URL. — Add `og:title`, `og:description`, absolute `og:image` (the lock-up) and `twitter:card=summary_large_image` to at least `index.html`.
- **Text-over-colour fails AA (build-wide)** — measured: primary CTA chalk-on-brick **4.38:1** (`index.html:103`, the conversion element everywhere), hero subhead `#ece9cf` **4.42:1** (`:269`), kicker `#e3e1bd` **4.07:1** (`:267`), render captions gray **2.72:1** (`:129`), eyebrow/spec-key olive **4.39:1** (`:82`,`:140`), footer labels **3.65:1** (`:218`), brick small text/links **3.93:1** (`:57`,`:284`). — Fix the colour values not the palette: white CTA label (→4.86:1), lift on-olive text to chalk, darken captions to ~`#5C5C5C`, reserve brick for ≥24px, set small labels in ink or on chalk cards.
- **Hero headline clipping** — `docs/index.html:380` display `clamp(3.2rem,8vw,6.5rem)` inside the `1.38fr` `.hero__left` with `overflow:hidden` (`:258-259`); "BATANGAS" is flush at 1440px and the content box (~619px at 1366px) is narrower than the rendered word (~624px+), so `overflow:hidden` eats the final "S" across the dominant ~1280–1366px laptop band. — Lower the display clamp max (e.g. `clamp(2.6rem,6.5vw,5.2rem)`) and guarantee the longest word fits the narrowest column before relying on `overflow:hidden`.
- **Section numeral signature collapsed** — `.numeral` is `display:block` in normal flow with only `margin-left:-42px` (`index.html:88-95`); home-desktop shows "01" in a clear gap above the H2, so Fingerprint #1's "overlapping the section heading" never happened, and `.meaning-big` (max 3.4rem, `:276`) renders larger than its own H2 (max 2.75rem, `:54`) so "ANYO — FORM" outweighs "A PRACTICE BUILT ON ORDER AND CLIMATE". — Absolutely position the numeral (or large negative margins) so it sits behind/over the H2 on the existing `z-index:1`, and drop `.meaning-big` max to ~2.3rem so the heading wins its tier.
- **Root-absolute internal paths** — every nav/asset uses `/…` (`index.html:341` `href="/work"`, `:334` `src="/uploads/logo.jpg"`, `:8` favicon); served from `/docs` with `.nojekyll` this is almost certainly a GitHub Pages **project** site at `user.github.io/<repo>/`, where `/work` and `/uploads/*` resolve to the domain root and 404 — taking down nav AND every image. — Use relative paths (`work.html`, `uploads/…`) or set a `<base>`; note `/work` (extensionless) only resolves via GitHub clean-URL handling.
- **Nav links have no resting affordance** — `.nav a` (`index.html:170-177`); the teak underline is drawn `::after { right:100% }` and only animates in on `:hover`/`.is-active`, so "WORK SERVICES ABOUT CONTACT" carry zero affordance at rest and hover doesn't exist on touch. — Give nav links a persistent resting cue (static teak underline, weight, or colour).

### Defer

- **Home trust layer / proof** — home substantiates nothing (no PRC license no., no named architect, no built work — both featured entries are "Concept render"/"In design"). Needs client-supplied data; revision can't invent it. — User to supply license, architect name, "practicing since [year]", one client line.
- **Contact channels** — no `tel:`, hours, or street address anywhere; only Facebook/Messenger live. Brief marked these `[verify]`/"must gather before launch" — data gap, not a code fix. — User to gather and add before publish.
- **Image weight** — `docs/uploads/ref-01.png` 2.4 MB and `ref-02.png` 4.5 MB load above-the-fold and again in featured work (~9 MB of PNGs at small sizes). — Re-encode as sub-300 KB JPG/WebP; add `loading="lazy"`/`width`/`height`.
- **Brand `aria-label` leak** — `aria-label="Anyo45 — home"` on every page announces the repo slug, not the brand. — Change to `aria-label="Anyo at Disenyo — home"`.
- **Heading-outline / landmark a11y** — Contact skips `<h1>`→`<h3>` (`contact.html:337`,`:388`); footer headings are `<h4>`; `anyo`/`disenyo` lack `lang="tl"`. — Promote/normalise headings and tag Tagalog terms.
- **Monogram trace fidelity** — the watermark SVG (`index.html:372-377`) is two overlapping rounded-rects (two side-by-side pills), not the interlocking figure-eight ribbon BRIEF §3 asked for; low impact at 8% opacity. — Redraw the path as the genuine loop.

## Fingerprint check

- **1. Index numeral bleeds ~40px left and overlaps the section heading** — PARTIAL. `margin-left:-42px` gives the left bleed (`index.html:95`) but `.numeral` is `display:block` in normal flow, so home-desktop shows "01" in a gap above the H2 — the overlap never happens.
- **2. Every section closes with a 2px bistre baseline rule** — PRESENT. `.rule` (`:76`) closes sections 01–04; visible as the dark hairlines between bands.
- **3. Hero two-column split olive / ref-01 render with teak keyline** — PRESENT. screenshot-home-desktop matches exactly, including the 2px teak `.hero__right` border.
- **4. Figure-eight monogram rotated ~12° ghosted ~8% behind hero + About** — PRESENT. Ghosted rotated watermark renders in the hero olive block and behind the About story (screenshot-about-desktop, right). Trace geometry is loose (two pills) — see Defer.
- **5. Primary CTA hard brick rectangle, chalk mono uppercase + "→", no shadow/round** — PRESENT. `.btn` `border-radius:0` brick fill (`:98-104`); visible in hero/header/contact. (Contrast fails AA — Must Fix.)
- **6. Every project entry carries a mono SCOPE/LOCATION/YEAR/STATUS spec block** — PRESENT. `.spec` rows under both work entries (`index.html:457-462`,`:474-479`).
- **7. Every render has a 2px teak keyline, no rounding** — PRESENT. `.render` (`:125`) on hero, featured work, About, Contact renders.
- **8. Eyebrow labels mono 500, 0.8125rem, uppercase, 0.12em, olive** — PRESENT. `.eyebrow` (`:79-83`) above every H2.
- **9. Real og-image ≥160px footer / ~220px About masthead / cropped header** — PRESENT. Footer logo 180px (`:217`), About masthead lock-up (screenshot-about-desktop top-right), header crop via `.brand__mark`. (Hero olive block uses the traced SVG not the bitmap — minor §3 deviation, outside this fingerprint item.)
- **10. Full-bleed bands alternate olive / teak / sage on Home + Services** — PRESENT. Home runs teak (01), sage (04), olive (CTA) bands; sections 02–03 sit on cream, so alternation is present but not every-section.

## Generic-AI tells

- **Centered hero on white over generic stock photo** — ABSENT. Left-aligned headline on a flat olive block over the firm's own ref-01 render.
- **Only Inter / Inter + Lora loaded as fonts** — ABSENT. Archivo (Expanded) + IBM Plex Sans + IBM Plex Mono (`index.html:11`).
- **Palette is 3 neutrals + 1 muted accent** — ABSENT. Full eight-shade earth system, all in use (cream surface confirmed, not white).
- **H1 / display capped near 3rem** — ABSENT. Display `clamp(3.2rem,8vw,6.5rem)`; numerals to 11rem.
- **Three identical cards as the home page's primary content** — ABSENT. Vertical work entries + mono scope rows, not a 3-card grid.
- **All decoration is border-radius + soft shadow** — ABSENT. Hard rectangles, `border-radius:0`, keylines and rules; no shadows.
- **Modular scale 1.25 with body-sized H1** — ABSENT. Scale 1.5, oversized display + giant numerals.
- **Logo missing or replaced by generic SVG when og-image existed** — ABSENT. Real og-image bitmap in header (crop), footer, and About masthead.
- **Real source imagery dropped (source/images/* unused)** — ABSENT. ref-01/ref-02 carry the page; context-house.jpg on Contact.
- **Decorative kit unused — all ornament is CSS only** — ABSENT. Real renders + bitmap logo combine with the CSS Swiss kit.

## Reference fidelity

The build is faithful to all three of the firm's own assets. `ref-00`/og-image is
placed as the real bitmap lock-up (header crop, 180px footer, About masthead) and
its locked moss-olive `#6E6C3E` anchors the system — no redrawn wordmark. `ref-01`
(primary) carries the full-bleed hero render and featured-work entry 01 with its
soft, low-contrast SketchUp grading intact behind a teak keyline, exactly the
"render-led, architecture is the hero" direction REFERENCES.md called for. `ref-02`
(secondary) is reused as the X-ray/ghosted philosophy image on About and featured
entry 02, preserving its sage/glass-green atmosphere. The only loose thread is the
decorative monogram trace (two pills vs. the continuous figure-eight ribbon of
ref-00) — cosmetic at 8% opacity, deferred.

## Overall

What's mediocre comes first: this is a strong concept undermined by an unshippable
build. The conversion form posts to a dead `REPLACE_ME` endpoint, the SEO export
leaks `127.0.0.1` to search engines, there are zero Open Graph tags on a site whose
entire job is to be shared off Facebook, root-absolute paths will 404 nav and every
image on a project Pages host, and text-over-colour fails AA across the build
starting with the CTA every page depends on. The signature numeral device — the one
bold move — only half landed, sitting above its heading instead of overlapping it,
and the hero headline clips the word "BATANGAS" at the most common laptop width.
What's working is real and rare: the Swiss color-block family reads at a glance,
the eight-shade earth palette and the firm's own renders ship with discipline, and
none of the ten generic-AI tells are present. I would not sign my name to it going
out today — the plumbing and contrast failures alone are disqualifying — but the
bones are good and the fix list is bounded and concrete. All five role reviews
landed on disk.

## Verdict

verdict: revise
