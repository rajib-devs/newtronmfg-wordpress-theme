<style>
/* ============================================================
   Newtron MFG — Quality Oversight Process Journey
   Self-contained. All selectors scoped to .nt-journey
   ============================================================ */
.nt-journey{
  --nt-ink:#16232f;
  --nt-muted:#5c6b78;
  --nt-muted-2:#8a97a3;
  --nt-green:#8bc53f;
  --nt-green-dark:#4f9a1e;
  --nt-navy:#0a1420;
  --nt-line:#e3e8ec;
  --nt-surface:#f6f8fa;
  --nt-dot:58px;
  --nt-rail-pad:10px;
  --nt-step-scroll:58vh;          /* scroll distance per step */
  --nt-header-offset:84px;        /* the theme's sticky site header height (main.css .header-inner) — mobile rail sticks below it, not under it */
  --nt-ease:cubic-bezier(.22,.7,.28,1);

  position:relative;
  padding:clamp(44px,6vw,64px) 0 0;
  background:
    radial-gradient(120% 80% at 50% 0%, #ffffff 0%, #fbfcfd 45%, var(--nt-surface) 100%);
  /* no overflow clipping here — the pinned journey below uses position:sticky,
     and any overflow value other than visible on an ancestor breaks sticky */
  font-family:'Poppins',Arial,Helvetica,sans-serif;
  color:var(--nt-ink);
}
/* faint blueprint grid — sets the manufacturing tone without shouting */
.nt-journey::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background-image:
    linear-gradient(rgba(22,35,47,.045) 1px,transparent 1px),
    linear-gradient(90deg,rgba(22,35,47,.045) 1px,transparent 1px);
  background-size:56px 56px;
  -webkit-mask-image:radial-gradient(85% 60% at 50% 38%,#000 0%,transparent 78%);
          mask-image:radial-gradient(85% 60% at 50% 38%,#000 0%,transparent 78%);
  opacity:.75;
}
.nt-journey *,.nt-journey *::before,.nt-journey *::after{box-sizing:border-box}
.nt-j-inner{position:relative;width:min(1180px,92%);margin:0 auto;overflow-x:hidden}

/* scroll-driven pinning: the section holds while you scroll through the steps */
.nt-j-scroller{position:relative;height:calc(100vh + 4 * var(--nt-step-scroll))}
.nt-j-sticky{
  /* pins right below the theme's own sticky site header (main.css
     .site-header, 84px) instead of under it — top:0 here would let the
     real header's higher z-index cover the top of this rail. */
  /* height matches the visible window below the pinned top offset, not a
     full 100vh — the box starts at top:var(--nt-header-offset), so a full
     100vh box would always overhang the viewport bottom by that same
     84px, invisibly. That hidden overhang used to be harmless (content
     was top-aligned into the visible part only), but centering content
     within the *true* box height would drag it down into that hidden
     strip. Sizing the box to what's actually on screen keeps flex-start
     and center both correct. */
  position:sticky;top:var(--nt-header-offset);
  min-height:calc(100vh - var(--nt-header-offset));min-height:calc(100svh - var(--nt-header-offset));
  display:flex;align-items:flex-start;
  padding:clamp(8px,1vw,18px) 0 clamp(14px,1.8vw,26px);
}

/* ---------- entrance choreography ---------- */
.nt-journey [data-rise]{
  opacity:0;transform:translateY(22px);
  transition:opacity .7s var(--nt-ease),transform .7s var(--nt-ease);
  transition-delay:var(--d,0ms);
}
.nt-journey.is-in [data-rise]{opacity:1;transform:none}

/* ---------- header ---------- */
.nt-j-head{text-align:center;max-width:760px;margin:0 auto clamp(22px,2.8vw,34px)}
.nt-j-eyebrow{
  display:inline-flex;align-items:center;gap:9px;
  font-size:12.5px;letter-spacing:.12em;text-transform:uppercase;font-weight:700;
  color:var(--nt-green-dark);margin-bottom:14px;
}
.nt-j-eyebrow i{
  width:7px;height:7px;border-radius:50%;background:var(--nt-green);
  box-shadow:0 0 0 0 rgba(139,197,63,.6);animation:ntBeacon 2.6s ease-out infinite;
}
@keyframes ntBeacon{0%{box-shadow:0 0 0 0 rgba(139,197,63,.55)}70%{box-shadow:0 0 0 11px rgba(139,197,63,0)}100%{box-shadow:0 0 0 0 rgba(139,197,63,0)}}
.nt-j-head h2{
  font-size:clamp(28px,3.4vw,40px);line-height:1.15;font-weight:700;
  margin:0 0 14px;color:var(--nt-ink);letter-spacing:-.01em;
}
.nt-j-head p{margin:0;font-size:16px;line-height:1.65;color:var(--nt-muted)}
.nt-j-mobile-hint{display:none}

/* ---------- rail ---------- */
.nt-j-rail{
  position:relative;
  display:grid;grid-template-columns:repeat(5,1fr);
  padding:var(--nt-rail-pad) 0 0;
  margin-bottom:clamp(20px,2.4vw,30px);
}
/* the track is a grid item spanning all columns, so it measures the real
   content width — including the off-screen part when the rail scrolls */
.nt-j-track{grid-column:1/-1;grid-row:1;position:relative;height:0;pointer-events:none}
.nt-j-track-inner{
  position:absolute;left:10%;right:10%;
  top:calc(var(--nt-dot)/2);
  height:3px;border-radius:3px;
}
.nt-j-track-line{position:absolute;inset:0;border-radius:3px;background:var(--nt-line)}
/* dashed "planned route" texture on the not-yet-travelled part */
.nt-j-track-line::after{
  content:'';position:absolute;inset:0;border-radius:3px;
  background:repeating-linear-gradient(90deg,rgba(22,35,47,.14) 0 6px,transparent 6px 14px);
}
.nt-j-track-fill{
  position:absolute;left:0;top:0;bottom:0;width:0;border-radius:3px;
  background:linear-gradient(90deg,var(--nt-green-dark),var(--nt-green));
  box-shadow:0 0 14px rgba(139,197,63,.5);
  transition:width 1s var(--nt-ease);
}
/* the part travelling the line */
.nt-j-carrier{
  /* the carrier's left% is computed against the track's 10%/90% inset,
     which doesn't line up with the nodes' plain grid-column centers — it
     used to peek out from behind the enlarged active dot instead of
     staying hidden under it. The active dot's own highlight + ring already
     shows current position, so just hide this redundant travelling badge. */
  display:none;
}
.nt-j-carrier svg{width:13px;height:13px;stroke:var(--nt-green-dark);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.nt-j-carrier::after{
  content:'';position:absolute;inset:-6px;border-radius:12px;
  border:1.5px solid rgba(139,197,63,.55);opacity:0;
}
.nt-journey.is-moving .nt-j-carrier::after{animation:ntCarrierPing .9s var(--nt-ease)}
@keyframes ntCarrierPing{0%{opacity:.9;transform:scale(.7)}100%{opacity:0;transform:scale(1.5)}}

/* ---------- nodes ---------- */
.nt-j-node{
  position:relative;z-index:2;grid-row:1;
  display:flex;flex-direction:column;align-items:center;gap:10px;
  background:none;border:0;padding:0 6px;margin:0;cursor:pointer;
  font:inherit;color:inherit;text-align:center;
  -webkit-tap-highlight-color:transparent;
}
.nt-j-dot{
  position:relative;width:var(--nt-dot);height:var(--nt-dot);border-radius:50%;
  background:#fff;border:2px solid var(--nt-line);
  display:grid;place-items:center;
  transition:border-color .45s var(--nt-ease),background .45s var(--nt-ease),
             transform .45s var(--nt-ease),box-shadow .45s var(--nt-ease);
}
.nt-j-dot svg{
  width:23px;height:23px;fill:none;stroke:var(--nt-muted-2);stroke-width:1.9;
  stroke-linecap:round;stroke-linejoin:round;
  transition:stroke .45s var(--nt-ease);
}
.nt-j-dot::after{ /* activation ring */
  content:'';position:absolute;inset:-3px;border-radius:50%;
  border:2px solid var(--nt-green);opacity:0;
}
.nt-j-num{
  font-size:11.5px;font-weight:700;letter-spacing:.1em;color:var(--nt-muted-2);
  transition:color .4s var(--nt-ease);
}
.nt-j-label{
  font-size:13.5px;font-weight:600;line-height:1.35;color:var(--nt-muted);
  max-width:14ch;transition:color .4s var(--nt-ease);
}

.nt-j-node:nth-of-type(1){grid-column:1}
.nt-j-node:nth-of-type(2){grid-column:2}
.nt-j-node:nth-of-type(3){grid-column:3}
.nt-j-node:nth-of-type(4){grid-column:4}
.nt-j-node:nth-of-type(5){grid-column:5}

.nt-j-node:hover .nt-j-dot{border-color:#c9d6c0;transform:translateY(-2px)}
.nt-j-node:hover .nt-j-label{color:var(--nt-ink)}
.nt-j-node:focus-visible{outline:none}
.nt-j-node:focus-visible .nt-j-dot{box-shadow:0 0 0 4px rgba(79,154,30,.28)}

/* done = already travelled */
.nt-j-node.is-done .nt-j-dot{border-color:var(--nt-green);background:#f3f9ec}
.nt-j-node.is-done .nt-j-dot svg{stroke:var(--nt-green-dark)}
.nt-j-node.is-done .nt-j-num{color:var(--nt-green-dark)}
.nt-j-node.is-done .nt-j-label{color:var(--nt-ink)}

/* active = you are here */
.nt-j-node.is-active .nt-j-dot{
  border-color:var(--nt-green);background:var(--nt-green);
  transform:translateY(-3px) scale(1.06);
  box-shadow:0 10px 24px rgba(79,154,30,.32);
}
.nt-j-node.is-active .nt-j-dot svg{stroke:var(--nt-navy)}
.nt-j-node.is-active .nt-j-dot::after{animation:ntRing 1.6s var(--nt-ease) infinite}
.nt-j-node.is-active .nt-j-num{color:var(--nt-green-dark)}
.nt-j-node.is-active .nt-j-label{color:var(--nt-ink);font-weight:700}
@keyframes ntRing{0%{opacity:.75;transform:scale(1)}70%{opacity:0;transform:scale(1.35)}100%{opacity:0;transform:scale(1.35)}}

/* ---------- stage ---------- */
.nt-j-stage{
  position:relative;display:grid;
  border:1px solid var(--nt-line);border-radius:18px;background:#fff;
  box-shadow:0 24px 60px rgba(8,31,49,.09);
  overflow:hidden;
}
.nt-j-stage::before{ /* progress hairline across the top of the card */
  content:'';position:absolute;left:0;top:0;height:3px;width:var(--nt-progress,20%);
  background:linear-gradient(90deg,var(--nt-green-dark),var(--nt-green));
  transition:width 1s var(--nt-ease);z-index:3;
}
.nt-j-panel{
  grid-area:1/1;display:grid;grid-template-columns:1.05fr .95fr;
  min-height:352px;
  opacity:0;visibility:hidden;pointer-events:none;
  transition:opacity .45s ease,visibility .45s;
}
.nt-j-panel.is-active{opacity:1;visibility:visible;pointer-events:auto}
.nt-j-copy{padding:clamp(24px,2.8vw,36px);display:flex;flex-direction:column;justify-content:center}
.nt-j-step-tag{
  display:inline-flex;align-items:center;gap:10px;align-self:flex-start;
  font-size:11.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:var(--nt-green-dark);background:#f3f9ec;border:1px solid rgba(139,197,63,.42);
  padding:6px 12px;border-radius:999px;margin-bottom:16px;
}
.nt-j-step-tag b{font-size:13px;letter-spacing:.04em}
.nt-j-copy h3{
  font-size:clamp(22px,2.4vw,29px);line-height:1.2;font-weight:700;
  margin:0 0 12px;color:var(--nt-ink);letter-spacing:-.01em;
}
.nt-j-copy > p{margin:0 0 22px;font-size:15.5px;line-height:1.68;color:var(--nt-muted);max-width:50ch}
.nt-j-checks{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 22px;padding:0;list-style:none}
.nt-j-checks li{
  display:inline-flex;align-items:center;gap:7px;
  font-size:13px;font-weight:500;color:var(--nt-ink);
  background:var(--nt-surface);border:1px solid var(--nt-line);
  padding:7px 12px 7px 10px;border-radius:8px;
}
.nt-j-checks li svg{width:13px;height:13px;flex:none;stroke:var(--nt-green-dark);fill:none;stroke-width:2.6;stroke-linecap:round;stroke-linejoin:round}
.nt-j-outcome{
  display:flex;align-items:flex-start;gap:11px;
  border-left:3px solid var(--nt-green);background:linear-gradient(90deg,#f3f9ec,rgba(246,248,250,0));
  padding:12px 14px;border-radius:0 8px 8px 0;
}
.nt-j-outcome span{font-size:10.5px;font-weight:700;letter-spacing:.11em;text-transform:uppercase;color:var(--nt-green-dark);display:block;margin-bottom:3px}
.nt-j-outcome p{margin:0;font-size:14.5px;line-height:1.55;font-weight:600;color:var(--nt-ink)}

/* ---------- stage visual ---------- */
.nt-j-visual{
  position:relative;background:var(--nt-surface);border-left:1px solid var(--nt-line);
  display:grid;place-items:center;padding:clamp(22px,2.6vw,34px);overflow:hidden;
}
.nt-j-visual::before{
  content:'';position:absolute;inset:0;
  background-image:radial-gradient(rgba(22,35,47,.09) 1px,transparent 1px);
  background-size:19px 19px;opacity:.7;
}
.nt-j-scene{position:relative;width:100%;max-width:330px}

/* panel content stagger — replays every time the step becomes active */
.nt-j-panel.is-active [data-anim]{animation:ntPanelIn .62s var(--nt-ease) both;animation-delay:var(--d,0ms)}
@keyframes ntPanelIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.nt-j-panel.is-active .nt-j-checks li{animation:ntChipIn .5s var(--nt-ease) both;animation-delay:calc(220ms + var(--i,0) * 55ms)}
@keyframes ntChipIn{from{opacity:0;transform:translateY(9px) scale(.96)}to{opacity:1;transform:none}}

/* ---------- controls ---------- */
.nt-j-controls{
  display:flex;align-items:center;gap:16px;flex-wrap:wrap;
  margin-top:18px;
}
.nt-j-hint{
  display:inline-flex;align-items:center;gap:8px;flex:none;
  font-size:11.5px;font-weight:700;letter-spacing:.11em;text-transform:uppercase;
  color:var(--nt-muted-2);transition:opacity .4s var(--nt-ease);
}
.nt-j-hint svg{width:13px;height:13px;stroke:var(--nt-muted-2);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;animation:ntNudge 1.9s ease-in-out infinite}
@keyframes ntNudge{0%,100%{transform:translateY(-2px)}50%{transform:translateY(2px)}}
.nt-journey.is-underway .nt-j-hint{opacity:0}
.nt-j-timer{position:relative;flex:1 1 190px;height:3px;border-radius:3px;background:var(--nt-line);overflow:hidden;min-width:120px}
.nt-j-timer i{
  position:absolute;inset:0;transform-origin:0 50%;transform:scaleX(var(--p,0));
  background:linear-gradient(90deg,var(--nt-green-dark),var(--nt-green));
}
.nt-j-count{font-size:12.5px;font-weight:600;color:var(--nt-muted);flex:none;letter-spacing:.02em}
.nt-j-count b{color:var(--nt-ink)}

/* ---------- inspection strip ---------- */
.nt-j-strip{
  margin-top:18px;padding-top:16px;border-top:1px solid var(--nt-line);
  display:flex;flex-wrap:wrap;align-items:center;gap:9px;
}
.nt-j-strip > span{font-size:13px;font-weight:700;color:var(--nt-ink);margin-right:4px}
.nt-j-strip b{
  font-size:12.5px;font-weight:500;color:var(--nt-muted);
  background:#fff;border:1px solid var(--nt-line);border-radius:999px;padding:6px 13px;
  transition:color .4s var(--nt-ease),border-color .4s var(--nt-ease),background .4s var(--nt-ease),transform .4s var(--nt-ease);
}
.nt-journey.is-inspecting .nt-j-strip b{
  color:var(--nt-green-dark);border-color:rgba(139,197,63,.55);background:#f3f9ec;
  transform:translateY(-2px);
  transition-delay:calc(var(--i,0) * 60ms);
}

/* ============================================================
   Scene animations (fire when their panel goes active)
   ============================================================ */
.nt-j-scene .draw{stroke-dasharray:var(--len,260);stroke-dashoffset:var(--len,260)}
.nt-j-panel.is-active .nt-j-scene .draw{animation:ntDraw 1.05s var(--nt-ease) both;animation-delay:var(--d,120ms)}
@keyframes ntDraw{to{stroke-dashoffset:0}}
.nt-j-scene .pop{opacity:0}
.nt-j-panel.is-active .nt-j-scene .pop{animation:ntPop .5s var(--nt-ease) both;animation-delay:var(--d,600ms)}
@keyframes ntPop{from{opacity:0;transform:translateY(7px) scale(.92)}to{opacity:1;transform:none}}
.nt-j-scene .fill-bar{transform:scaleX(0);transform-origin:0 50%}
.nt-j-panel.is-active .nt-j-scene .fill-bar{animation:ntFill .9s var(--nt-ease) both;animation-delay:var(--d,300ms)}
@keyframes ntFill{to{transform:scaleX(var(--to,1))}}

/* scene 3 — live signal */
.nt-j-panel.is-active .nt-j-scene .pulse{animation:ntPulse 2.1s ease-in-out infinite;animation-delay:var(--d,0ms)}
@keyframes ntPulse{0%,100%{opacity:.25;r:3}50%{opacity:1;r:5}}

/* scene 5 — release stamp */
.nt-j-stamp{
  position:absolute;right:-4px;bottom:-6px;
  font-size:13px;font-weight:800;letter-spacing:.16em;color:var(--nt-green-dark);
  border:2.5px solid var(--nt-green-dark);border-radius:7px;padding:7px 13px;
  background:rgba(255,255,255,.92);transform:rotate(-9deg);opacity:0;
}
.nt-j-panel.is-active .nt-j-stamp{animation:ntStamp .55s cubic-bezier(.2,1.5,.4,1) both;animation-delay:1.35s}
@keyframes ntStamp{
  0%{opacity:0;transform:rotate(-9deg) scale(2.1)}
  60%{opacity:1;transform:rotate(-9deg) scale(.94)}
  100%{opacity:1;transform:rotate(-9deg) scale(1)}
}

/* scene cards (used by 02 / 05) */
.nt-j-rows{display:grid;gap:10px}
.nt-j-row{
  display:flex;align-items:center;gap:11px;background:#fff;border:1px solid var(--nt-line);
  border-radius:10px;padding:11px 13px;box-shadow:0 4px 14px rgba(8,31,49,.05);
}
.nt-j-row .lbl{font-size:12.5px;font-weight:600;color:var(--nt-ink);flex:1;min-width:0}
.nt-j-row .bar{position:relative;width:64px;height:5px;border-radius:5px;background:var(--nt-line);overflow:hidden;flex:none}
.nt-j-row .bar i{position:absolute;inset:0;border-radius:5px;background:var(--nt-green);transform-origin:0 50%}
.nt-j-row .tick{width:19px;height:19px;border-radius:50%;background:#f3f9ec;display:grid;place-items:center;flex:none}
.nt-j-row .tick svg{width:11px;height:11px;stroke:var(--nt-green-dark);fill:none;stroke-width:3;stroke-linecap:round;stroke-linejoin:round}
.nt-j-row.is-muted{opacity:.5}

/* scene 4 — readout */
.nt-j-readout{background:#fff;border:1px solid var(--nt-line);border-radius:12px;padding:18px;box-shadow:0 6px 20px rgba(8,31,49,.06)}
.nt-j-readout .ro-top{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:4px}
.nt-j-readout .ro-label{font-size:10.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--nt-muted-2)}
.nt-j-readout .ro-val{font-size:31px;font-weight:700;color:var(--nt-ink);font-variant-numeric:tabular-nums;letter-spacing:-.01em}
.nt-j-readout .ro-val small{font-size:14px;font-weight:600;color:var(--nt-muted);margin-left:3px}
.nt-j-readout .ro-band{position:relative;height:26px;margin:12px 0 6px}
.nt-j-readout .ro-band .zone{position:absolute;left:0;right:0;top:11px;height:5px;border-radius:5px;background:var(--nt-line)}
.nt-j-readout .ro-band .ok{position:absolute;left:29%;width:42%;top:11px;height:5px;border-radius:5px;background:rgba(139,197,63,.42)}
.nt-j-readout .ro-band .needle{
  position:absolute;top:2px;width:3px;height:23px;border-radius:3px;background:var(--nt-green-dark);
  left:6%;box-shadow:0 0 0 4px rgba(139,197,63,.18);
}
.nt-j-panel.is-active .nt-j-readout .ro-band .needle{animation:ntNeedle 1.5s var(--nt-ease) both;animation-delay:.25s}
@keyframes ntNeedle{0%{left:6%}55%{left:63%}100%{left:49%}}
.nt-j-readout .ro-foot{display:flex;justify-content:space-between;font-size:10.5px;color:var(--nt-muted-2);font-weight:600}
.nt-j-passrow{display:flex;gap:7px;flex-wrap:wrap;margin-top:13px}
.nt-j-passrow em{
  font-style:normal;font-size:11px;font-weight:600;color:var(--nt-green-dark);
  background:#f3f9ec;border:1px solid rgba(139,197,63,.4);border-radius:6px;padding:4px 9px;
}

/* ============================================================
   Responsive
   ============================================================ */
/* on a big desktop monitor the card is much shorter than the pinned box
   (which has to stay a full viewport tall for the scroll-jack math), so
   flex-start left all of that slack hanging below the card as dead space
   on every step. Scoped to the side-by-side desktop layout — at
   tablet/mobile widths the illustration stacks below the copy instead,
   content height varies more per step, and centering was pushing the
   tallest steps' content up above the fold where flex-start had at least
   kept the top safely on-screen. */
@media(min-width:1001px){
  .nt-j-sticky{align-items:center}
}
/* short laptop viewports: shed the least essential rows so the pinned
   view never hides its own controls */
@media(min-width:761px) and (max-height:940px){
  .nt-j-strip{display:none}
  .nt-j-sticky{padding:16px 0}
  .nt-j-head p{font-size:14px;line-height:1.5;max-width:72ch;margin-left:auto;margin-right:auto}
  .nt-j-head{margin-bottom:14px}
  .nt-j-rail{margin-bottom:14px}
  .nt-j-panel{min-height:0;grid-template-columns:1fr}
  .nt-j-visual{display:none}
  .nt-j-copy{padding:18px 26px}
  .nt-journey{--nt-dot:44px}
  .nt-j-step-tag{margin-bottom:10px}
  .nt-j-copy h3{font-size:22px;margin-bottom:8px}
  .nt-j-copy > p{font-size:14px;line-height:1.5;margin-bottom:14px}
  .nt-j-checks{margin-bottom:14px}
  .nt-j-checks li{padding:5px 10px 5px 8px;font-size:12.5px}
  .nt-j-outcome{padding:9px 12px}
  .nt-j-outcome p{font-size:13.5px}
  .nt-j-controls{margin-top:12px}
}
@media(min-width:761px) and (max-height:700px){
  .nt-j-head p{display:none}
  .nt-j-head{margin-bottom:10px}
  .nt-j-copy > p{-webkit-line-clamp:3;display:-webkit-box;-webkit-box-orient:vertical;overflow:hidden}
}
@media(max-width:1000px){
  .nt-j-panel{grid-template-columns:1fr;min-height:0}
  .nt-j-visual{border-left:0;border-top:1px solid var(--nt-line);padding:26px}
  .nt-j-scene{max-width:300px}
  .nt-j-label{font-size:12.5px}
}
@media(max-width:760px){
  .nt-journey{--nt-dot:48px}
  /* grid items default to a content-based min-width, so a long label
     ("Supplier Qualification") was forcing its column past the other four
     and pushing the last node off the right edge. min-width:0 lets the
     column actually shrink to its 1fr share; the label still shows in
     full, just wrapped onto its own lines instead of forcing overflow. */
  .nt-j-node{min-width:0}
  .nt-j-label{font-size:11.5px;max-width:none}
  /* the pinned viewport on a phone is too short for the copy card AND its
     illustration to both fit — the illustration is decorative, so it's the
     one that gives way (same trade-off already made for short desktop
     windows above). Without this the scene got shoved off the bottom of
     the pin, permanently unreachable since scrolling here advances steps
     instead of scrolling the card. */
  .nt-j-visual{display:none}
  .nt-j-panel{min-height:0}
  /* dropping the illustration alone still left the copy card ~50px taller
     than a typical 375x812 phone viewport (rail + header offset eat the
     rest), clipping the outcome box. Trim the card's own vertical rhythm —
     same content, tighter spacing — rather than the text itself. */
  .nt-j-rail{margin-bottom:10px}
  .nt-j-copy{padding:14px 22px}
  .nt-j-copy > p{margin-bottom:12px}
  .nt-j-checks{margin-bottom:12px}
  .nt-j-outcome{padding:9px 12px}
  .nt-j-controls{gap:12px}
  .nt-j-count{order:3;width:100%}
  .nt-j-head{margin-bottom:22px}
  .nt-j-head p{font-size:14.5px}
  .nt-j-strip{gap:7px}
}
@media(max-width:460px){
  .nt-j-checks li{font-size:12.2px;padding:6px 10px 6px 9px}
  .nt-j-copy > p{font-size:14.8px}
}

/* phones in landscape (~375-430px tall): the width-based rules above
   don't kick in together with the height-based ones (a 667px-wide phone
   in landscape skips the 761px+ "short laptop" rules but still gets the
   full 760px-and-under "portrait phone" spacing), so on a genuinely short
   viewport the card still overflowed by 70px+. Shrinking every font down
   to ~10px to force a fit would have thrown away real B2B content
   (spec/checklist copy buyers actually read), so instead the copy column
   gets a capped height and scrolls internally — full sentences and all
   four checklist chips stay legible and present, just reachable via a
   short scroll inside the card rather than the page. Placed last so it
   wins over both the laptop- and phone-width rules above regardless of
   viewport width. */
@media(max-height:460px){
  .nt-journey{--nt-dot:32px}
  .nt-j-sticky{padding:6px 0}
  .nt-j-rail{padding-top:6px;margin-bottom:6px}
  .nt-j-node{gap:3px}
  .nt-j-label{display:none}
  .nt-j-dot svg{width:16px;height:16px}
  .nt-j-panel{min-height:0;grid-template-columns:1fr}
  .nt-j-visual{display:none}
  .nt-j-copy{
    position:relative;
    padding:8px 16px;
    justify-content:flex-start;
    max-height:calc(100svh - var(--nt-header-offset) - 102px);
    overflow-y:auto;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:thin;
  }
  /* badge only renders once JS confirms there's actually more to reveal
     (.nt-copy-scrollable) — sticky keeps it pinned to the visible bottom
     edge while scrolling, then it settles inline once you reach the real
     end of the content, so it never overlaps text once there's nothing
     left to hide */
  .nt-j-copy.nt-copy-scrollable.nt-copy-at-bottom::after{display:none}
  .nt-j-copy.nt-copy-scrollable::after{
    content:'\2193 more details';
    align-self:flex-end;
    position:sticky;
    bottom:2px;
    font-size:9px;font-weight:700;letter-spacing:.04em;
    color:var(--nt-green-dark);background:rgba(255,255,255,.94);
    border:1px solid rgba(139,197,63,.45);border-radius:999px;
    padding:2px 8px;pointer-events:none;
  }
  .nt-j-step-tag{margin-bottom:6px;padding:4px 9px;font-size:10.5px}
  .nt-j-copy h3{font-size:18px;margin-bottom:5px}
  .nt-j-copy > p{font-size:13px;line-height:1.45;margin-bottom:10px;max-width:none}
  .nt-j-checks{margin-bottom:10px;gap:6px}
  .nt-j-checks li{font-size:11.5px;padding:4px 8px 4px 7px}
  .nt-j-outcome{padding:7px 10px}
  .nt-j-outcome span{font-size:9.5px}
  .nt-j-outcome p{font-size:12px;line-height:1.4}
  .nt-j-controls{margin-top:4px;gap:8px}
  .nt-j-hint{display:none}
  .nt-j-timer{display:none}
  .nt-j-count{font-size:11px}
}

/* let a scroll naturally rest on each step instead of sailing past it —
   plain CSS, the browser handles the "stop" on its own, no JS involved so
   it can't get stuck the way a JS scroll-lock can. proximity (not
   mandatory) only pulls in when you're already close to a step, so it
   stays gentle and never fights you leaving the section at either end. */
html{scroll-snap-type:y proximity}
.nt-j-snap-stops i{
  position:absolute;left:0;height:1px;width:1px;
  scroll-snap-align:start;
}
.nt-j-snap-stops i:nth-child(1){top:0}
.nt-j-snap-stops i:nth-child(2){top:var(--nt-step-scroll)}
.nt-j-snap-stops i:nth-child(3){top:calc(var(--nt-step-scroll) * 2)}
.nt-j-snap-stops i:nth-child(4){top:calc(var(--nt-step-scroll) * 3)}
.nt-j-snap-stops i:nth-child(5){top:calc(var(--nt-step-scroll) * 4)}

/* ============================================================
   Reduced motion — everything still works, nothing moves
   ============================================================ */
@media(prefers-reduced-motion:reduce){
  .nt-journey *,.nt-journey *::before,.nt-journey *::after{
    animation-duration:.001ms !important;animation-iteration-count:1 !important;
    transition-duration:.001ms !important;
  }
  .nt-journey [data-rise]{opacity:1;transform:none}
  .nt-j-scroller{height:auto}
  .nt-j-sticky{position:static;min-height:0}
  html{scroll-snap-type:none}
  .nt-j-scene .draw{stroke-dashoffset:0}
  .nt-j-scene .pop,.nt-j-stamp{opacity:1}
  .nt-j-scene .fill-bar{transform:scaleX(var(--to,1))}
}
</style>

<section class="nt-journey" id="quality-process" aria-labelledby="nt-j-title">

 <!-- header sits above the pinned scroller as plain content, so it scrolls
      past normally and the rail below it can pin flush to the top of the
      viewport instead of appearing wherever the header happens to end. -->
 <div class="nt-j-inner">
  <header class="nt-j-head">
    <span class="nt-j-eyebrow" data-rise><i></i>Our Process</span>
    <h2 id="nt-j-title" data-rise style="--d:80ms">Quality Oversight, Start to Finish</h2>
    <p data-rise style="--d:160ms">Many companies struggle with offshore manufacturing &mdash; communication barriers, inconsistent quality, missed deadlines. Newtron eliminates those risks by acting as your manufacturing partner, not simply a sourcing company.</p>
    <span class="nt-j-mobile-hint" aria-hidden="true">
      <svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
      Scroll to move through each step
    </span>
  </header>
 </div>

 <div class="nt-j-scroller" data-scroller>
  <div class="nt-j-snap-stops" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
  <div class="nt-j-sticky">
   <div class="nt-j-inner">

    <!-- ── rail ───────────────────────────────────────────── -->
    <div class="nt-j-rail" role="tablist" aria-label="Quality oversight process" data-rise style="--d:240ms">
      <div class="nt-j-track" aria-hidden="true">
        <div class="nt-j-track-inner">
          <span class="nt-j-track-line"></span>
          <span class="nt-j-track-fill" data-fill></span>
          <span class="nt-j-carrier" data-carrier>
            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
          </span>
        </div>
      </div>

      <button class="nt-j-node is-active" role="tab" id="nt-tab-0" aria-controls="nt-panel-0" aria-selected="true" tabindex="0">
        <span class="nt-j-dot"><svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg></span>
        <span class="nt-j-num">01</span>
        <span class="nt-j-label">Engineering Review</span>
      </button>

      <button class="nt-j-node" role="tab" id="nt-tab-1" aria-controls="nt-panel-1" aria-selected="false" tabindex="-1">
        <span class="nt-j-dot"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
        <span class="nt-j-num">02</span>
        <span class="nt-j-label">Supplier Qualification</span>
      </button>

      <button class="nt-j-node" role="tab" id="nt-tab-2" aria-controls="nt-panel-2" aria-selected="false" tabindex="-1">
        <span class="nt-j-dot"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>
        <span class="nt-j-num">03</span>
        <span class="nt-j-label">Production Monitoring</span>
      </button>

      <button class="nt-j-node" role="tab" id="nt-tab-3" aria-controls="nt-panel-3" aria-selected="false" tabindex="-1">
        <span class="nt-j-dot"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg></span>
        <span class="nt-j-num">04</span>
        <span class="nt-j-label">Quality Inspection</span>
      </button>

      <button class="nt-j-node" role="tab" id="nt-tab-4" aria-controls="nt-panel-4" aria-selected="false" tabindex="-1">
        <span class="nt-j-dot"><svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></span>
        <span class="nt-j-num">05</span>
        <span class="nt-j-label">Final U.S. Review</span>
      </button>
    </div>

    <!-- ── stage ──────────────────────────────────────────── -->
    <div class="nt-j-stage" data-rise style="--d:320ms">

      <!-- 01 ─ Engineering Review -->
      <div class="nt-j-panel is-active" role="tabpanel" id="nt-panel-0" aria-labelledby="nt-tab-0">
        <div class="nt-j-copy">
          <span class="nt-j-step-tag" data-anim><b>01</b> Before production</span>
          <h3 data-anim style="--d:70ms">Engineering Review</h3>
          <p data-anim style="--d:130ms">Every project begins with a comprehensive engineering review. Our U.S. team verifies your drawings, CAD files, material specifications, manufacturing tolerances, finishes, and assembly requirements &mdash; before a single part is cut.</p>
          <ul class="nt-j-checks">
            <li style="--i:0"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Drawings &amp; CAD files</li>
            <li style="--i:1"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Material specifications</li>
            <li style="--i:2"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Tolerances &amp; finishes</li>
            <li style="--i:3"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Assembly requirements</li>
          </ul>
          <div class="nt-j-outcome" data-anim style="--d:330ms">
            <div><span>What you get</span><p>Production starts from a verified, unambiguous spec &mdash; not an assumption.</p></div>
          </div>
        </div>
        <div class="nt-j-visual">
          <div class="nt-j-scene">
            <svg viewBox="0 0 300 210" width="100%" role="img" aria-label="Technical drawing with dimensions being verified">
              <rect x="8" y="8" width="284" height="194" rx="10" fill="#fff" stroke="#e3e8ec"/>
              <!-- part outline -->
              <path class="draw" style="--len:520;--d:150ms" d="M78 66h120a14 14 0 0 1 14 14v56a14 14 0 0 1-14 14H78a14 14 0 0 1-14-14V80a14 14 0 0 1 14-14Z" fill="none" stroke="#16232f" stroke-width="2"/>
              <circle class="draw" style="--len:76;--d:600ms" cx="96" cy="108" r="12" fill="none" stroke="#4f9a1e" stroke-width="1.8"/>
              <circle class="draw" style="--len:76;--d:700ms" cx="180" cy="108" r="12" fill="none" stroke="#4f9a1e" stroke-width="1.8"/>
              <!-- dimension lines -->
              <path class="draw" style="--len:160;--d:850ms" d="M64 178h148" stroke="#8bc53f" stroke-width="1.4" fill="none"/>
              <path class="draw" style="--len:40;--d:850ms" d="M64 172v12M212 172v12" stroke="#8bc53f" stroke-width="1.4" fill="none"/>
              <path class="draw" style="--len:110;--d:980ms" d="M240 66v84" stroke="#8bc53f" stroke-width="1.4" fill="none"/>
              <path class="draw" style="--len:30;--d:980ms" d="M234 66h12M234 150h12" stroke="#8bc53f" stroke-width="1.4" fill="none"/>
              <g class="pop" style="--d:1150ms">
                <rect x="108" y="186" width="60" height="16" rx="4" fill="#f3f9ec" stroke="#8bc53f" stroke-width="1"/>
                <text x="138" y="197.5" text-anchor="middle" font-size="10" font-weight="700" fill="#4f9a1e" font-family="Poppins,Arial,sans-serif">±0.05 mm</text>
              </g>
              <g class="pop" style="--d:1300ms">
                <rect x="30" y="24" width="98" height="18" rx="4" fill="#f6f8fa" stroke="#e3e8ec"/>
                <text x="42" y="36.5" font-size="10" font-weight="600" fill="#5c6b78" font-family="Poppins,Arial,sans-serif">REV&nbsp;B &mdash; verified</text>
              </g>
            </svg>
          </div>
        </div>
      </div>

      <!-- 02 ─ Supplier Qualification -->
      <div class="nt-j-panel" role="tabpanel" id="nt-panel-1" aria-labelledby="nt-tab-1" hidden>
        <div class="nt-j-copy">
          <span class="nt-j-step-tag" data-anim><b>02</b> Partner selection</span>
          <h3 data-anim style="--d:70ms">Supplier Qualification</h3>
          <p data-anim style="--d:130ms">We work only with carefully selected manufacturing partners that meet our standards for capability, equipment, quality systems, and production performance. Your part is placed with a shop already proven to build it.</p>
          <ul class="nt-j-checks">
            <li style="--i:0"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Capability match</li>
            <li style="--i:1"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Equipment &amp; capacity</li>
            <li style="--i:2"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Quality systems</li>
            <li style="--i:3"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Production performance</li>
          </ul>
          <div class="nt-j-outcome" data-anim style="--d:330ms">
            <div><span>What you get</span><p>A vetted partner selected for your part &mdash; not the cheapest bid of the week.</p></div>
          </div>
        </div>
        <div class="nt-j-visual">
          <div class="nt-j-scene">
            <div class="nt-j-rows">
              <div class="nt-j-row pop" style="--d:200ms">
                <span class="lbl">Capability match</span>
                <span class="bar"><i class="fill-bar" style="--to:.96;--d:400ms"></i></span>
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
              </div>
              <div class="nt-j-row pop" style="--d:320ms">
                <span class="lbl">Equipment &amp; capacity</span>
                <span class="bar"><i class="fill-bar" style="--to:.88;--d:520ms"></i></span>
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
              </div>
              <div class="nt-j-row pop" style="--d:440ms">
                <span class="lbl">Quality systems</span>
                <span class="bar"><i class="fill-bar" style="--to:.92;--d:640ms"></i></span>
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
              </div>
              <div class="nt-j-row pop is-muted" style="--d:560ms">
                <span class="lbl">Unqualified shop</span>
                <span class="bar"><i class="fill-bar" style="--to:.34;--d:760ms;background:#c9d4df"></i></span>
                <span class="tick" style="background:#f1f3f5"><svg viewBox="0 0 24 24" style="stroke:#8a97a3"><path d="M18 6 6 18M6 6l12 12"/></svg></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 03 ─ Production Monitoring -->
      <div class="nt-j-panel" role="tabpanel" id="nt-panel-2" aria-labelledby="nt-tab-2" hidden>
        <div class="nt-j-copy">
          <span class="nt-j-step-tag" data-anim><b>03</b> During the run</span>
          <h3 data-anim style="--d:70ms">Production Monitoring</h3>
          <p data-anim style="--d:130ms">Throughout manufacturing we maintain regular communication with our production partners, monitor progress, answer engineering questions, and resolve issues before they become costly delays.</p>
          <ul class="nt-j-checks">
            <li style="--i:0"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Regular status contact</li>
            <li style="--i:1"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Progress tracking</li>
            <li style="--i:2"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Engineering Q&amp;A</li>
            <li style="--i:3"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Early issue resolution</li>
          </ul>
          <div class="nt-j-outcome" data-anim style="--d:330ms">
            <div><span>What you get</span><p>Issues get solved on the production floor &mdash; not on your receiving dock.</p></div>
          </div>
        </div>
        <div class="nt-j-visual">
          <div class="nt-j-scene">
            <svg viewBox="0 0 300 200" width="100%" role="img" aria-label="Live production monitoring signal">
              <rect x="8" y="8" width="284" height="184" rx="10" fill="#fff" stroke="#e3e8ec"/>
              <path d="M28 150h244" stroke="#eef1f4" stroke-width="1"/>
              <path d="M28 110h244" stroke="#eef1f4" stroke-width="1"/>
              <path d="M28 70h244" stroke="#eef1f4" stroke-width="1"/>
              <!-- signal trace -->
              <path class="draw" style="--len:400;--d:150ms" d="M28 140c22 0 26-46 44-46s24 34 42 34 24-52 44-52 26 40 46 40 24-26 40-26" fill="none" stroke="#8bc53f" stroke-width="2.4" stroke-linecap="round"/>
              <circle class="pulse" style="--d:0ms" cx="72" cy="94" r="4" fill="#4f9a1e"/>
              <circle class="pulse" style="--d:700ms" cx="158" cy="86" r="4" fill="#4f9a1e"/>
              <circle class="pulse" style="--d:1400ms" cx="244" cy="130" r="4" fill="#4f9a1e"/>
              <g class="pop" style="--d:900ms">
                <rect x="150" y="26" width="126" height="30" rx="8" fill="#f3f9ec" stroke="#8bc53f" stroke-width="1"/>
                <circle cx="166" cy="41" r="4" fill="#4f9a1e"/>
                <text x="178" y="45" font-size="11" font-weight="600" fill="#16232f" font-family="Poppins,Arial,sans-serif">Run on schedule</text>
              </g>
              <g class="pop" style="--d:1200ms">
                <rect x="24" y="164" width="150" height="22" rx="6" fill="#f6f8fa" stroke="#e3e8ec"/>
                <text x="36" y="179" font-size="10.5" font-weight="600" fill="#5c6b78" font-family="Poppins,Arial,sans-serif">Eng. question &rarr; answered</text>
              </g>
            </svg>
          </div>
        </div>
      </div>

      <!-- 04 ─ Quality Inspection -->
      <div class="nt-j-panel" role="tabpanel" id="nt-panel-3" aria-labelledby="nt-tab-3" hidden>
        <div class="nt-j-copy">
          <span class="nt-j-step-tag" data-anim><b>04</b> Every production run</span>
          <h3 data-anim style="--d:70ms">Quality Inspection</h3>
          <p data-anim style="--d:130ms">Every production run undergoes inspection based on your requirements &mdash; from dimensional checks and First Article Inspection to material, finish, and functional testing. Inspection reports and documentation can be provided on request.</p>
          <ul class="nt-j-checks">
            <li style="--i:0"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Dimensional inspection</li>
            <li style="--i:1"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>First Article Inspection</li>
            <li style="--i:2"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Material verification</li>
            <li style="--i:3"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Functional testing</li>
          </ul>
          <div class="nt-j-outcome" data-anim style="--d:330ms">
            <div><span>What you get</span><p>Documented evidence that the run meets specification &mdash; available on request.</p></div>
          </div>
        </div>
        <div class="nt-j-visual">
          <div class="nt-j-scene">
            <div class="nt-j-readout pop" style="--d:120ms">
              <div class="ro-top">
                <span class="ro-label">Bore &oslash; measured</span>
                <span class="ro-label" style="color:#4f9a1e">In tolerance</span>
              </div>
              <div class="ro-val"><span data-count data-to="12.03" data-decimals="2">0.00</span><small>mm</small></div>
              <div class="ro-band">
                <span class="zone"></span><span class="ok"></span><span class="needle"></span>
              </div>
              <div class="ro-foot"><span>11.95</span><span>NOMINAL 12.00</span><span>12.05</span></div>
              <div class="nt-j-passrow">
                <em class="pop" style="--d:1500ms">FAI passed</em>
                <em class="pop" style="--d:1600ms">Material certified</em>
                <em class="pop" style="--d:1700ms">Finish verified</em>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 05 ─ Final U.S. Review -->
      <div class="nt-j-panel" role="tabpanel" id="nt-panel-4" aria-labelledby="nt-tab-4" hidden>
        <div class="nt-j-copy">
          <span class="nt-j-step-tag" data-anim><b>05</b> Before shipment</span>
          <h3 data-anim style="--d:70ms">Final U.S. Review</h3>
          <p data-anim style="--d:130ms">Before shipment, our U.S. project managers verify that production meets the approved specifications &mdash; helping ensure you receive parts that are ready for production or assembly the day they arrive.</p>
          <ul class="nt-j-checks">
            <li style="--i:0"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Spec conformance</li>
            <li style="--i:1"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Documentation package</li>
            <li style="--i:2"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Packaging &amp; labeling</li>
            <li style="--i:3"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>Ship release</li>
          </ul>
          <div class="nt-j-outcome" data-anim style="--d:330ms">
            <div><span>What you get</span><p>A U.S.-based team that signs off on the shipment &mdash; and answers to you.</p></div>
          </div>
        </div>
        <div class="nt-j-visual">
          <div class="nt-j-scene">
            <div class="nt-j-rows">
              <div class="nt-j-row pop" style="--d:180ms">
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
                <span class="lbl">Meets approved specification</span>
              </div>
              <div class="nt-j-row pop" style="--d:340ms">
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
                <span class="lbl">Inspection documentation complete</span>
              </div>
              <div class="nt-j-row pop" style="--d:500ms">
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
                <span class="lbl">Packaged &amp; labeled for your line</span>
              </div>
              <div class="nt-j-row pop" style="--d:660ms">
                <span class="tick"><svg viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg></span>
                <span class="lbl">Released for shipment</span>
              </div>
            </div>
            <span class="nt-j-stamp">RELEASED</span>
          </div>
        </div>
      </div>

    </div><!-- /stage -->

    <!-- ── controls ───────────────────────────────────────── -->
    <div class="nt-j-controls" data-rise style="--d:400ms">
      <span class="nt-j-hint" aria-hidden="true">
        <svg viewBox="0 0 24 24"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
        Scroll to follow the process
      </span>
      <span class="nt-j-timer" data-timer aria-hidden="true"><i></i></span>
      <span class="nt-j-count">Step <b data-current>1</b> of 5 &mdash; <span data-stepname>Engineering Review</span></span>
    </div>

   </div>
  </div>
 </div>

 <!-- ── inspection strip (sits below the pinned journey) ── -->
 <div class="nt-j-inner" style="padding:0 0 clamp(40px,5vw,64px)">
    <div class="nt-j-strip" data-rise style="--d:460ms;margin-top:0;padding-top:0;border-top:0">
      <span>Inspections may include</span>
      <b style="--i:0">Dimensional inspections</b>
      <b style="--i:1">First Article Inspection (FAI)</b>
      <b style="--i:2">Material verification</b>
      <b style="--i:3">Surface finish verification</b>
      <b style="--i:4">Functional testing</b>
      <b style="--i:5">Assembly verification</b>
      <b style="--i:6">Packaging inspections</b>
    </div>
 </div>
</section>

<script>
(function(){
  var root = document.querySelector('.nt-journey');
  if(!root || root.dataset.ntInit) return;
  root.dataset.ntInit = '1';

  var mq         = window.matchMedia;
  var reduced    = mq && mq('(prefers-reduced-motion: reduce)').matches;
  var pinned     = !reduced;   /* pinned scroll-drive: same on desktop + mobile — scroll position maps straight to step, no scroll-jacking */
  var nodes   = [].slice.call(root.querySelectorAll('.nt-j-node'));
  var panels  = [].slice.call(root.querySelectorAll('.nt-j-panel'));
  var rail    = root.querySelector('.nt-j-rail');
  var fill    = root.querySelector('[data-fill]');
  var carrier = root.querySelector('[data-carrier]');
  var stage   = root.querySelector('.nt-j-stage');
  var head    = root.querySelector('.nt-j-head');
  var timer   = root.querySelector('[data-timer] i');
  var scroller= root.querySelector('[data-scroller]');
  var curEl   = root.querySelector('[data-current]');
  var nameEl  = root.querySelector('[data-stepname]');
  var LAST    = nodes.length - 1;

  var index = -1;

  /* ---------- step switching ---------- */
  function setStep(i){
    i = Math.max(0, Math.min(LAST, i));
    if(i === index) return;
    index = i;

    nodes.forEach(function(n, k){
      n.classList.toggle('is-active', k === index);
      n.classList.toggle('is-done', k < index);
      n.setAttribute('aria-selected', k === index ? 'true' : 'false');
      n.tabIndex = k === index ? 0 : -1;
    });

    panels.forEach(function(p, k){
      var on = k === index;
      if(on) p.removeAttribute('hidden');
      p.classList.toggle('is-active', on);
      if(!on) setTimeout(function(){ if(!p.classList.contains('is-active')) p.hidden = true; }, 450);
    });

    var pct = (index / LAST) * 100;
    fill.style.width = pct + '%';
    carrier.style.left = pct + '%';
    stage.style.setProperty('--nt-progress', (((index + 1) / (LAST + 1)) * 100) + '%');

    root.classList.add('is-moving');
    setTimeout(function(){ root.classList.remove('is-moving'); }, 900);

    curEl.textContent = index + 1;
    nameEl.textContent = nodes[index].querySelector('.nt-j-label').textContent;
    root.classList.toggle('is-inspecting', index === 3);

    countUp(panels[index]);
    scrollNodeIntoView(nodes[index]);
    root.classList.toggle('is-underway', index > 0);
    updateCopyScrollHint(panels[index]);
  }

  /* on short viewports (phones in landscape) .nt-j-copy scrolls internally
     instead of clipping content — flag it so CSS can show a small "more
     below" cue, since the scrollbar alone is easy to miss on touch devices */
  function updateCopyScrollHint(panel){
    if(!panel) return;
    var copy = panel.querySelector('.nt-j-copy');
    if(!copy) return;
    if(!copy._ntHintBound){
      copy._ntHintBound = true;
      copy.addEventListener('scroll', function(){
        copy.classList.toggle('nt-copy-at-bottom', copy.scrollTop + copy.clientHeight >= copy.scrollHeight - 2);
      }, {passive:true});
    }
    requestAnimationFrame(function(){
      copy.classList.toggle('nt-copy-scrollable', copy.scrollHeight > copy.clientHeight + 1);
      copy.classList.toggle('nt-copy-at-bottom', copy.scrollTop + copy.clientHeight >= copy.scrollHeight - 2);
    });
  }

  /* horizontal rail follows the active step on small screens */
  function scrollNodeIntoView(node){
    if(rail.scrollWidth <= rail.clientWidth + 4) return;
    var target = node.offsetLeft - (rail.clientWidth - node.offsetWidth) / 2;
    if(rail.scrollTo) rail.scrollTo({left:target, behavior: reduced ? 'auto' : 'smooth'});
    else rail.scrollLeft = target;
  }

  /* ---------- measurement counter (step 04) ---------- */
  function countUp(panel){
    var el = panel.querySelector('[data-count]');
    if(!el) return;
    var to = parseFloat(el.getAttribute('data-to'));
    var dp = parseInt(el.getAttribute('data-decimals'), 10) || 0;
    if(reduced){ el.textContent = to.toFixed(dp); return; }
    var start = null, dur = 1300;
    (function frame(t){
      if(start === null) start = t;
      var p = Math.min(1, (t - start) / dur);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = (to * eased).toFixed(dp);
      if(p < 1) requestAnimationFrame(frame);
    })(performance.now());
  }

  /* ---------- scroll drives the journey ---------- */
  /* the section is pinned; how far you have scrolled through it decides the step */
  function travel(){
    var span = scroller.offsetHeight - window.innerHeight;
    if(span <= 0) return 0;
    var passed = -scroller.getBoundingClientRect().top;
    return Math.min(1, Math.max(0, passed / span));
  }

  /* deliberately unthrottled: requestAnimationFrame-gated throttling can
     wedge permanently if a single rAF callback ever fails to fire (backgrounded
     tab, a browser quirk, etc.), silently freezing every future scroll update
     with no way to recover. setStep() already no-ops when the step hasn't
     changed, so a plain per-event call is cheap and can't get stuck. */
  function onScroll(){
    /* belt-and-suspenders for the header's own IntersectionObserver: an
       instant jump straight into the pinned section (an anchor link,
       scrollIntoView, a very fast fling) can land here before the header
       was ever "seen" onscreen, which would otherwise leave the rail/stage
       permanently at opacity:0. Reaching the pin at all is proof enough
       that it should be visible. */
    root.classList.add('is-in');
    var p = travel();
    timer.style.setProperty('--p', p);
    setStep(Math.round(p * LAST));
  }

  /* jumping to a step (click/keyboard) means scrolling there, computed from
     the same proportional map onScroll() reads from — so clicking a node and
     scrolling there by hand always agree. Reduced motion: no scroll-linking
     at all, just switch the panel directly. */
  function goTo(i){
    if(!pinned || scroller.offsetHeight <= window.innerHeight){ setStep(i); return; }
    var span = scroller.offsetHeight - window.innerHeight;
    var y = scroller.getBoundingClientRect().top + window.pageYOffset + (i / LAST) * span;
    window.scrollTo({top:Math.round(y), behavior:'smooth'});
  }

  /* ---------- interaction ---------- */
  nodes.forEach(function(n, k){
    n.addEventListener('click', function(){ goTo(k); });
  });

  rail.addEventListener('keydown', function(e){
    var map = {ArrowRight:1, ArrowDown:1, ArrowLeft:-1, ArrowUp:-1};
    var next = null;
    if(map[e.key]) next = Math.max(0, Math.min(LAST, index + map[e.key]));
    else if(e.key === 'Home') next = 0;
    else if(e.key === 'End') next = LAST;
    if(next === null) return;
    e.preventDefault();
    goTo(next); nodes[next].focus({preventScroll:true});
  });

  /* ---------- wiring ---------- */
  /* the header now scrolls into view on its own, ahead of the pinned rail/
     stage, so it's what triggers the entrance fade — by the time the rail
     and stage are reached, is-in is already set and they just appear
     directly (their own motion comes from the scroll-driven pin itself). */
  if('IntersectionObserver' in window){
    new IntersectionObserver(function(entries){
      entries.forEach(function(en){ if(en.isIntersecting) root.classList.add('is-in'); });
    }, {threshold:.15}).observe(head);
  }else{
    root.classList.add('is-in');
  }

  if(pinned){
    window.addEventListener('scroll', onScroll, {passive:true});
    window.addEventListener('resize', onScroll);
  }
  /* orientation change can flip the scroll-hint need without changing the
     current step, which onScroll's setStep() would otherwise no-op on */
  window.addEventListener('resize', function(){ updateCopyScrollHint(panels[index]); });

  /* ---------- boot ---------- */
  setStep(0);
  if(pinned){
    onScroll();
    /* re-measure once layout has actually settled (webfonts / late images
       can change section height right after first paint) */
    window.addEventListener('load', onScroll);
    setTimeout(onScroll, 60);
    setTimeout(onScroll, 400);
  }else{
    root.classList.add('is-in');
  }
})();
</script>
