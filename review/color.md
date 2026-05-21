# COLOUR REVIEW

## What I saw

All four captured screenshots render on **drafting cream `#ECE7D9`**, not pure
white — the single most common drift (cream → `#ffffff`) was avoided, and raised
blocks ("THE STUDIO" / "FIND US" on contact) sit on the slightly warmer chalk
`#F6F3EA`. The palette is faithful: the home hero's left ~58% is a flat **moss
olive** field carrying white caps "FORM & DESIGN FOR HOW YOU LIVE IN BATANGAS",
the section index numerals ("01", "04 ABOUT", "05 CONTACT") are **muted brick**
red, the "ANYO — FORM / DISENYO — DESIGN" dashes spark brick, render frames carry
**teak** keylines, the home's lower band is a tan **teak** block ("02
ARCHITECTURE, END TO END"), the about render is the green-tinted ref-02 X-ray in a
teak frame, and footer + closing/contact CTA bands are olive. I confirmed the CSS
custom properties (`docs/index.html:14-21`) name all eight brief shades verbatim.
This is the disciplined Swiss earth-tone system the brief asked for, not the
"3 neutrals + 1 muted accent" failure mode — fidelity is a pass.

The problem is **contrast**, and it clusters on text-over-colour. The screenshots
are top-crops (home cuts off at section 02), so the **celadon sage `#7E9A86`**
process band is below the fold and unverifiable in pixels; it does exist in markup
(`docs/index.html:489`), so all three+ accents are present, but sage is the one
palette member I could not confirm rendered. Computed ratios below use the exact
shipped hex values.

## Findings

### Ship blockers (must fix before publish)

- **Primary CTA button text** — `docs/index.html:101-103` (`.btn`: chalk
  `#F6F3EA` label on brick `#C24A33`, `font-size:.8125rem` / 13px uppercase mono)
  — measured **4.38 : 1**, under the 4.5 : 1 AA floor for small text. This is the
  conversion element repeated everywhere (hero "Request consultation", header
  nav CTA `:345`, contact "Send request" `:382`); the firm's whole objective rides
  on it and its label fails AA. → Switch the label to pure `#ffffff` (→ **4.86 : 1**)
  or darken the fill to ~`#B0402A`.

### Important (should fix this revision pass)

- **Hero subhead + kicker on olive** — `docs/index.html:269` (`.hero__sub`
  `#ece9cf`, 17px body) = **~4.42 : 1** and `:267` (`.hero__kicker` `#e3e1bd`,
  13px) = **~4.07 : 1**, both under 4.5 : 1 — the hero's only running prose sits
  just below legibility on the olive block. → Lighten both toward chalk `#F6F3EA`
  (subhead reaches ~6 : 1).
- **Render / context captions** — `docs/index.html:129-131` (`.figcap`,
  `.render__cap`: drafting-gray `#8C8C8C` on cream, 12px) = **2.72 : 1**, the
  worst ratio in the build; visible as a faint gray strip under the contact-page
  render. The brief mandates captions to mark context photos, so this text must be
  readable. → Darken caption colour to ~`#5C5C5C` (≈4.6 : 1) — keep gray for
  hairlines only.
- **Brick as small text / inline links** — `docs/index.html:57` (`a{color:var(--brick)}`)
  and `:284` (`.scope-row__no`, 13px) — brick `#C24A33` on cream = **3.93 : 1**,
  under 4.5 for body/label text (the giant numerals are exempt as large text).
  → Reserve brick for ≥24px display use; set inline links and small mono numbers
  in ink `#27271F`.
- **Eyebrow + spec-key labels** — `docs/index.html:82` (`.eyebrow`) and `:140`
  (`.spec__k`) — olive `#6E6C3E` on cream = **~4.39 : 1**, marginally under 4.5
  for the small uppercase mono labels that appear above every H2. → Nudge the
  label olive ~10% darker, or only set these labels on chalk cards (→4.88 : 1).
- **Footer section labels** — `docs/index.html:218` & `:121` (`.site-footer h4`,
  band-olive eyebrow: `#d8d6b0` on olive, 12px) = **~3.65 : 1** — the footer's
  column headings ("SITE", "STUDIO") fall well under 4.5. → Lighten to chalk
  `#F6F3EA`.

### Nice to have (skip if budget tight)

- **Brick CTA on the olive hero block** — brick `#C24A33` (L≈0.166) vs olive
  `#6E6C3E` (L≈0.144) is only **~1.1 : 1** in luminance; the button reads only
  because red-vs-green hue carries it, so in grayscale / for some colour-blind
  users the CTA shape merges into the field. → Add a 2px teak or chalk keyline
  around the hero button so separation survives loss of hue.
- **Celadon sage unconfirmed in pixels** — the third accent's only placement
  (home process band, `docs/index.html:489`; services band) is below the fold in
  every captured shot. → Re-capture a full-height home or services screenshot so
  the least-confirmed palette member is verified as rendered.

## Summary for the synthesiser

Palette fidelity is genuinely good (cream surface, all eight shades present and
doing work — not the usual drift), but text-over-colour contrast fails AA across
the build, headlined by the **primary CTA label at 4.38 : 1** — fix the colour
values, not the palette.
