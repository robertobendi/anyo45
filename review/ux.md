# USER EXPERIENCE REVIEW

## What I saw

Four screenshots opened (home desktop + mobile, about desktop, contact desktop); no work/services captures, so those pages judged from markup only. The home hero is a left olive block (~58%) holding a mono kicker "EST. BATANGAS CITY · LICENSED ARCHITECTS", a huge Archivo headline "FORM & DESIGN FOR HOW YOU LIVE IN BATANGAS", a one-line subhead naming the firm as "a licensed Batangas architectural practice… from first concept to construction documents", and a brick "REQUEST CONSULTATION →" button; the right ~42% is the ref-01 render with a teak keyline, tagged "ANYO AT DISENYO · CONCEPT RENDER". A first-time visitor can answer what/who/next-action in one read — the 5-second test passes. Scrolling down: 01 name-meaning (anyo—form/disenyo—design) on a teak band, 02 "ARCHITECTURE, END TO END" three scope rows, 03 "RENDERS FROM THE STUDIO" with two entries (both labeled "Concept render"/"In design"), 04 four-step process on sage, then an olive closing CTA "LET'S DESIGN THE HOME YOU'LL LIVE IN". Funnel order is coherent and the CTA repeats three times (header, hero, closing band).

The proof layer is thin: the only trust assets visible are the "LICENSED ARCHITECTS" claim, a city-level address, two *unbuilt* concept renders, and a Facebook/Messenger link. No phone, no hours, no year established, no named architect, no testimonial, no photo of a finished building anywhere on home, about, or contact (footer = "Batangas City, Batangas / Philippines" + Facebook only). The About page lead reads "A small Batangas architectural studio…" and defers proof with "Licensure and credentials are available on request" (`docs/about.html:334,362`). Critically, the contact form — the primary inquiry mechanism — posts to `https://formspree.io/f/REPLACE_ME` (`docs/contact.html:346`), an unconfigured endpoint.

## Findings

### Ship blockers (must fix before publish)

- **Contact consultation form** — `docs/contact.html:346` `action="https://formspree.io/f/REPLACE_ME"` — the build's primary conversion mechanism (BRIEF §1: "convert a prospect into a consultation inquiry") POSTs to a dead Formspree ID; a homeowner who fills name/email/phone/project and hits "Send request" gets an error, believes they've made contact, and never retries. The Messenger fallback and "fastest channel today is Facebook" copy soften it but most users will use the form first. → Wire the real Formspree ID before publish, or until then replace the `<form>` with the working Messenger CTA so no submit can silently fail.

### Important (should fix this revision pass)

- **Home trust layer** — home page hero/sections — the conversion objective is credibility-for-a-high-trust purchase, yet the page substantiates nothing: "LICENSED ARCHITECTS" is asserted with no PRC number, no architect name/face, no year established, and the "Selected work" section shows two renders both tagged "Concept render"/"In design" (`docs/index.html:461,478`) — i.e. zero evidence of a delivered building. The funnel asks a homeowner to call on self-description alone. → Surface the cheapest available proof on home — the named licensed architect + license no., a "practicing since [year]" line, and one client sentence — even one is a step-change over none.
- **About lead copy** — `docs/about.html:334` "A small Batangas architectural studio…" — BRIEF §0 names "looks small/early-stage" as the exact perception to defeat; opening About by self-labeling "small" reinforces the doubt the funnel exists to remove. → Recast as a confident capability statement ("A Batangas architectural practice that designs climate-first homes and draws them to build") and drop "small".
- **Contact channels** — footer + contact "Find us" block (`docs/contact.html:399-401`) — no phone, no hours, no street; the only live channels are Facebook + Messenger. The brief flagged these as [verify]/"must gather before launch", so this is a data gap, but a credibility site for a high-value local service that can't be phoned loses ready-to-call prospects. → Gather and add a `tel:` line and hours before publish; they are the strongest "this is a real, reachable practice" signals.

### Nice to have (skip if budget tight)

- **Hero kicker** — `docs/index.html:379` "EST. Batangas City · Licensed Architects" — "EST." conventionally precedes a *year*, so "EST. Batangas City" parses as "Established Batangas City" and wastes a prime trust slot. → Change to "EST. [year] · BATANGAS CITY" once the founding year is known, or "BASED IN BATANGAS CITY · LICENSED ARCHITECTS".
- **Nav label "Services"** — header/footer nav — generic per the brief's own spec; acceptable because section headings ("Architecture, end to end") carry the scent, so low priority. → Optional: leave as-is; the inner-page H2s already disambiguate.

## Summary for the synthesiser

The page wins the 5-second test and the funnel is coherent, but the conversion path it's built around is broken (form → dead Formspree endpoint) and the credibility it's selling is unproven (no phone, no named/licensed architect, no built work) — fix the form to ship, then add real proof to actually convert.

---

UX review written.
