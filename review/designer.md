# GRAPHIC DESIGNER REVIEW

## What I saw

Home desktop (1440px): a genuinely striking two-column hero — left ~58% flat
moss-olive block carrying the headline "FORM & DESIGN FOR HOW YOU LIVE IN
BATANGAS" in heavy expanded caps that fills the block across six tight lines
(line-height ~0.92), a faint chalk figure-eight watermark ghosted in the
upper-right of the olive, a mono kicker "EST. BATANGAS CITY · LICENSED
ARCHITECTS", and a brick "REQUEST CONSULTATION →" button low-left; right ~42% is
the ref-01 render full-bleed behind a teak left-keyline with a bistre
"CONCEPT RENDER" tag bottom-left. The display H1 did **not** collapse to a polite
3rem — it shipped at full display scale and dominates. Below it, a tan (teak)
band holds a big brick "01", the eyebrow + H2 "A PRACTICE BUILT ON ORDER AND
CLIMATE", and a large two-tone "ANYO — FORM / DISENYO — DESIGN" block; then a
cream section opens "02 ARCHITECTURE, END TO END". (The home capture stops at
section 02, so for the lower page — featured work, process, CTA, footer — I read
the HTML and cross-checked the system against the About and Contact captures.)

About and Contact confirm the system renders: giant brick numerals "04"/"05"
bleeding left, the 220px og-image lock-up placed on a chalk card, a ghosted olive
monogram behind the About story column, full-bleed teak-keyline renders, mono
spec rows, sage/olive bands, thin bistre baseline rules, and an olive footer with
the real lock-up. The decorative kit is present in pixels, not just CSS. The
weakest beat is the teak band: at #B9925A over #ECE7D9 cream it reads close to
the surface, so it barely registers as a distinct color zone next to the
emphatic olive hero.

## Findings

### Ship blockers (must fix before publish)

None. The one bold move (oversized brick index numerals + Swiss color-block hero
with full-scale expanded display type) shipped and is visible; no single
composition/typographic failure makes this unfit under my lens.

### Important (should fix this revision pass)

- **Section index numeral** — index.html:87–95 (`.numeral` is `display:block` in
  normal flow above `.eyebrow`/`h2`; only `margin-left:-42px` applied) — the
  signature collapsed to a stacked big-number-above-heading. BRIEF §5 / Fingerprint
  #1 demand the numeral "bleeding ~40px past the left edge **and overlapping the
  section heading**"; the left-bleed shipped, the overlap did not. Home shows "01"
  sitting in a clear gap above the H2, so the defining graphic device reads as a
  conventional label. → Position the numeral absolutely (or use large negative
  margins) so it sits behind/over the H2 with the heading raised on the already-set
  `z-index:1` (line 93), restoring the overlap.
- **Hierarchy inversion, section 01** — `.meaning-big` clamp max 3.4rem
  (index.html:276) renders **larger** than the section H2 it lives under (`h2`
  clamp max 2.75rem, index.html:54). Home-desktop: "ANYO — FORM / DISENYO —
  DESIGN" visibly out-weighs "A PRACTICE BUILT ON ORDER AND CLIMATE", so the real
  heading is subordinate to its own sub-content. → Drop `.meaning-big` max to
  ~2.3rem (or promote the H2 above it) so the heading wins the tier.
- **Hero headline rag** — index.html:380, render in home-desktop and
  home-mobile — the wrap leaves "IN" orphaned alone on its own line above
  "BATANGAS", breaking the rag on the single most important piece of type on the
  site. → Force the last clause to stay whole (`IN&nbsp;BATANGAS` or a controlled
  `<br>`) so the display ends on a clean two-line beat.
- **Teak band rhythm** — `.band--teak` (index.html:117) over cream surface — the
  section-01 band sits too close in value to the page surface, so the
  alternating color-block rhythm (Fingerprint #10) loses its first strong hit and
  the band barely reads as a distinct zone between the olive hero and the sage
  band. (Colour owns the exact ratio; I'm flagging the broken sectional rhythm.)
  → Give the teak band more presence (heavier vertical padding + a stronger
  internal anchor) or reorder so a higher-contrast band carries section 01.

### Nice to have (skip if budget tight)

- **Monogram trace fidelity** — index.html:372–377 — the watermark SVG is two
  overlapping stroked rounded-rects, which read as two side-by-side pills, not the
  interlocking figure-eight chain of the real mark; BRIEF §3 asked for a faithful
  loop trace. Low visual impact at 8–10% opacity, but the motif isn't truly the
  brand loop. → Redraw the path as the genuine interlocking loop.
- **Numeral / eyebrow tuck** — index.html:90 (`margin: 0 0 -0.12em`) — the
  negative margin leaves an awkward small gap rather than a deliberate nest; tighten
  so the eyebrow sits snug under the numeral's optical baseline once overlap is
  fixed.

## Summary for the synthesiser

The Swiss system shipped with real display scale and visible decorative kit, but
the layout signature is 70% there — the giant numerals bleed left yet never
overlap the heading, so fix the numeral-over-heading overlap (and the meaning-big
> H2 inversion) to make the one bold move actually land.
