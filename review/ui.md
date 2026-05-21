# UI / INTERACTION REVIEW

## What I saw

Four screenshots opened cleanly (home desktop + mobile, about desktop, contact desktop); I could not serve the site for live geometry measurement (file:// is blocked, no shell), so pixels + CSS math are my evidence. **Home desktop (1440px):** the hero is a two-column split — moss-olive block left holding the white Archivo-Expanded headline that wraps one word per line ("FORM &" / "DESIGN" / "FOR" / "HOW" / "YOU LIVE" / "IN" / "BATANGAS"), architectural render right behind a teak keyline with a dark "ANYO AT DISENYO · CONCEPT RENDER" tag bottom-left. The last word, **"BATANGAS", sits flush against the teak keyline with essentially zero right-margin** — the final "S" is hard up against the olive/render boundary. Header is a slim chalk bar: cropped monogram + "ANYO AT DISENYO / ARCHITECTURAL SERVICES" left; "WORK SERVICES ABOUT CONTACT" + a brick "REQUEST CONSULTATION" button right. The brick CTA reads as clearly clickable; the four text nav links are plain dark uppercase mono with **no underline or colour distinction at rest** — they read as labels, not links. Below: giant brick "01" / "02" numerals overlapping their headings (intended), body copy on the teak band reads fully, no clipped characters.

**Home mobile (375px):** hero collapses to a single olive column (per CSS) with the headline, subhead, brick CTA, then the render strip below; the faint shape upper-right is the ghosted chalk monogram bleeding off (`right:-22%`), not the render colliding with type. **Contact desktop:** a clean two-column drafting form — labels in olive mono UPPERCASE *above* each field (NAME / EMAIL / PHONE / PROJECT LOCATION / PROJECT TYPE / ABOUT YOUR PROJECT), bottom-ruled inputs, a "SEND REQUEST →" brick button, info card + context-house render right. Inputs are underline-only (transparent, 2px bottom border) so empty fields render as bare horizontal lines. No clipped or colliding body copy on about or contact. Image behaviour is good: global `img{max-width:100%;height:auto}` and `aspect-ratio` on every render frame (16/10, 1/1, 4/5) — low CLS risk.

## Findings

### Ship blockers (must fix before publish)

(none I can confirm from the captured pixels — see the hero-clipping item below, which is a borderline blocker the synthesiser may choose to escalate)

### Important (should fix this revision pass)

- **Hero headline `.display` / `.hero__left`** — docs/index.html:380, sized `clamp(3.2rem,8vw,6.5rem)` (index.html:63-67) inside a `1.38fr` grid column with `overflow:hidden` (index.html:257-259); screenshot-home-desktop.png shows "BATANGAS" flush against the teak keyline — the headline fills the column with ~0px slack. Because the font caps at 6.5rem (~104px ≥1300px viewport) while the fr-column keeps shrinking, the longest word silently truncates across a band of **very common laptop widths (~1280–1366px)**: at 1366px the content box is ≈619px but "BATANGAS" renders ≈630–650px, so `overflow:hidden` eats the final "S". The brand's geographic hook disappears with no visible error. → Lower the display clamp max (e.g. `clamp(2.6rem,6.5vw,5.2rem)`) and/or guarantee the longest word fits the narrowest column before relying on `overflow:hidden`.
- **Header nav links `.nav a`** — docs/index.html:170-177; the teak underline is drawn by `::after { right:100% }` and only animates in on `:hover`/`.is-active`, so at rest the links have no underline and the same ink colour as static text. On the home page no item is active, so "WORK SERVICES ABOUT CONTACT" (screenshot-home-desktop.png header) carry **zero affordance cues** — indistinguishable from labels until hovered (and hover doesn't exist on touch). → Give nav links a persistent resting cue (static teak underline, weight, or colour) so they read as clickable without hover.
- **Contact form required fields** — docs/contact.html:350/354/379 set `required` on Name, Email, and About-your-project, but the labels (contact.html:349 etc.) carry no asterisk or "(required)" marker, so the user can't tell which fields are mandatory until submit fails. → Add a visible required marker (e.g. `*` in brick) to required-field labels.

### Nice to have (skip if budget tight)

- **Form inputs `.field input/select/textarea`** — docs/contact.html:260-264; transparent background + bottom-border-only means an empty field renders as a lone horizontal line under its label (screenshot-contact-desktop.png), low discoverability that it's an editable target even though the hit area is a correct 44px. → Add a faint chalk fill or a left tick so empty fields read as inputs; tap height is already fine.
- **Footer & spec-row link tap targets** — docs/index.html:222-223 (`.footer-nav a`) and contact.html:399; these mono text links are ~21px tall with no min-height, under the 44×44px touch minimum on mobile. → Add vertical padding (`min-height:44px` / `padding:.6rem 0`) to footer and spec-row links.

## Summary for the synthesiser

The hero headline fills its column with zero slack and `overflow:hidden`, so "BATANGAS" — already flush against the keyline at 1440px — will silently truncate at common ~1280–1366px laptop widths; treat that as the build's main layout-integrity risk and the nav's no-resting-affordance as the main interaction gap.
