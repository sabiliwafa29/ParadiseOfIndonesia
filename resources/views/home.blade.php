@extends('layouts.app')
@section('content')

<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION — Cinematic Split-Glass Slideshow
     Design: Ken Burns zoom · Glassmorphism card · Thumbnail strip
     ═══════════════════════════════════════════════════════════ -->
<section class="relative w-full overflow-hidden bg-black" id="hero-section" style="height:100svh;min-height:580px;max-height:900px;">

    {{-- ── SLIDESHOW BACKGROUND ─────────────────────────────── --}}
    <div class="absolute inset-0" id="heroSlideshow" aria-hidden="true">

        {{-- Each slide: full-bleed image with Ken Burns zoom --}}
        @php
        $heroSlides = [
            ['img' => '/images/hero/slideshow/hiace.jpg',     'key' => 'hero_slide_hiace'],
            ['img' => '/images/hero/slideshow/xenia.jpg',     'key' => 'hero_slide_xenia'],
            ['img' => '/images/hero/slideshow/avanza.jpg',    'key' => 'hero_slide_avanza'],
            ['img' => '/images/hero/slideshow/bus.jpg',       'key' => 'hero_slide_bus'],
            ['img' => '/images/hero/slideshow/travel-van.jpg','key' => 'hero_slide_van'],
        ];
        @endphp

        @foreach($heroSlides as $i => $slide)
        <div class="hero-slide{{ $i === 0 ? ' is-active' : '' }}"
             data-index="{{ $i }}"
             role="img"
             aria-label="{{ __('messages.' . $slide['key']) }}">
            <div class="hero-slide-img"
                 style="background-image:url('{{ $slide['img'] }}')"></div>
        </div>
        @endforeach
    </div>

    {{-- ── LAYERED OVERLAYS ─────────────────────────────────── --}}
    {{-- cinematic letterbox vignette --}}
    <div class="absolute inset-0 z-10 pointer-events-none"
         style="background:linear-gradient(to right,rgba(0,0,0,.72) 0%,rgba(0,0,0,.35) 55%,rgba(0,0,0,.15) 100%),
                            linear-gradient(to top,rgba(0,0,0,.6) 0%,transparent 40%)">
    </div>

    {{-- ambient amber glow (brand colour) --}}
    <div class="absolute z-10 pointer-events-none"
         style="width:520px;height:380px;top:10%;left:-80px;
                background:radial-gradient(ellipse,rgba(245,158,11,.18) 0%,transparent 70%);
                filter:blur(40px)"></div>

    {{-- ── GLASS CONTENT CARD ───────────────────────────────── --}}
    <div class="absolute inset-0 z-20 flex items-center">
        <div class="w-full max-w-7xl mx-auto px-6 md:px-10 lg:px-16">
            <div class="hero-glass-card" id="heroCard">

                {{-- slide counter --}}
                <div class="hero-counter" id="heroCounter">
                    <span id="heroCounterCurrent">01</span>
                    <span class="hero-counter-sep">/</span>
                    <span>05</span>
                </div>

                {{-- brand chip --}}
                <div class="hero-brand-chip" id="heroChip">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#F59E0B">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span>{{ __('messages.hero_brand') }}</span>
                </div>

                {{-- headline --}}
                <h1 class="hero-headline" id="heroHeadline">
                    {{ __('messages.hero_welcome') }}
                </h1>

                {{-- description --}}
                <p class="hero-desc" id="heroDesc">
                    {{ __('messages.hero_description') }}
                </p>

                {{-- CTA row --}}
                <div class="hero-cta-row" id="heroCtas">
                    <a href="#services" class="hero-btn-primary">
                        <span>{{ __('messages.view_all') }} {{ __('messages.travel_services') }}</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="https://wa.me/6281585333325?text=Halo,%20saya%20tertarik%20dengan%20layanan%20PNB%20Travel"
                       target="_blank" rel="noopener" class="hero-btn-ghost">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <span>{{ __('messages.contact_us') }}</span>
                    </a>
                </div>

                {{-- trust pills --}}
                <div class="hero-trust-row" id="heroTrust">
                    <div class="hero-trust-pill">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Licensed & Official</span>
                    </div>
                    <div class="hero-trust-pill">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>24/7 Support</span>
                    </div>
                    <div class="hero-trust-pill">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>1000+ Partners</span>
                    </div>
                    <div class="hero-trust-pill">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>All Indonesia</span>
                    </div>
                </div>

                {{-- animated progress bar --}}
                <div class="hero-progress-track">
                    <div class="hero-progress-bar" id="heroProgressBar"></div>
                </div>

            </div>{{-- /glass card --}}
        </div>
    </div>

    {{-- ── THUMBNAIL STRIP ──────────────────────────────────── --}}
    <div class="absolute bottom-0 left-0 right-0 z-30" id="heroThumbStrip">
        <div class="hero-thumb-strip">
            @foreach($heroSlides as $i => $slide)
            <button class="hero-thumb{{ $i === 0 ? ' is-active' : '' }}"
                    data-index="{{ $i }}"
                    aria-label="Go to slide {{ $i + 1 }}: {{ __('messages.' . $slide['key']) }}">
                <div class="hero-thumb-img"
                     style="background-image:url('{{ $slide['img'] }}')"></div>
                <div class="hero-thumb-label">{{ __('messages.' . $slide['key']) }}</div>
            </button>
            @endforeach
        </div>
    </div>

    {{-- ── NAV ARROWS ───────────────────────────────────────── --}}
    <button class="hero-arrow hero-arrow-prev" id="heroPrev" aria-label="Previous slide">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button class="hero-arrow hero-arrow-next" id="heroNext" aria-label="Next slide">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- ── SCROLL CUE ───────────────────────────────────────── --}}
    <div class="hero-scroll-cue" aria-hidden="true">
        <span>Scroll</span>
        <div class="hero-scroll-line"></div>
    </div>

</section>

{{-- ════════════════════════════════════════════════════════════
     HERO STYLES
     ════════════════════════════════════════════════════════════ --}}
<style>
/* ── Slide images ───────────────────────────────────────────── */
.hero-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity .9s cubic-bezier(.4,0,.2,1);
    will-change: opacity;
}
.hero-slide.is-active { opacity: 1; }

.hero-slide-img {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transform: scale(1.06);
    transition: transform 6s ease-out;
    will-change: transform;
}
.hero-slide.is-active .hero-slide-img {
    transform: scale(1.0);   /* Ken Burns: zoom out slowly */
}

/* ── Glass content card ─────────────────────────────────────── */
.hero-glass-card {
    position: relative;
    max-width: 560px;
    padding: 2.5rem 2.5rem 1.75rem;
    background: rgba(10, 14, 28, 0.52);
    backdrop-filter: blur(22px) saturate(1.4);
    -webkit-backdrop-filter: blur(22px) saturate(1.4);
    border: 1px solid rgba(255,255,255,.10);
    border-radius: 24px;
    box-shadow: 0 8px 64px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.08);
    overflow: hidden;
}
@media (max-width: 767px) {
    .hero-glass-card {
        max-width: 100%;
        padding: 1.75rem 1.5rem 1.25rem;
        border-radius: 18px;
        margin: 0 0 120px;
    }
}

/* ── Slide counter ──────────────────────────────────────────── */
.hero-counter {
    position: absolute;
    top: 1.5rem;
    right: 1.75rem;
    display: flex;
    align-items: baseline;
    gap: 4px;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .1em;
    color: rgba(255,255,255,.5);
    font-variant-numeric: tabular-nums;
}
.hero-counter #heroCounterCurrent {
    font-size: 1.1rem;
    color: #F59E0B;
    font-weight: 800;
}
.hero-counter-sep { font-size: .65rem; margin: 0 1px; }

/* ── Brand chip ─────────────────────────────────────────────── */
.hero-brand-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 14px 5px 10px;
    background: rgba(245,158,11,.15);
    border: 1px solid rgba(245,158,11,.3);
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #FCD34D;
    margin-bottom: 1.1rem;
    animation: hero-fadein .5s ease both;
}

/* ── Headline ───────────────────────────────────────────────── */
.hero-headline {
    font-size: clamp(1.9rem, 4.5vw, 3.25rem);
    font-weight: 900;
    line-height: 1.07;
    letter-spacing: -.02em;
    color: #fff;
    margin-bottom: .9rem;
    animation: hero-slidein .55s .06s ease both;
}
.hero-headline em {
    font-style: normal;
    background: linear-gradient(90deg,#F59E0B,#FBBF24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ── Description ────────────────────────────────────────────── */
.hero-desc {
    font-size: clamp(.82rem, 1.6vw, .96rem);
    line-height: 1.7;
    color: rgba(255,255,255,.7);
    margin-bottom: 1.8rem;
    font-weight: 300;
    animation: hero-slidein .55s .12s ease both;
}

/* ── CTA buttons ────────────────────────────────────────────── */
.hero-cta-row {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-bottom: 1.4rem;
    animation: hero-fadein .5s .2s ease both;
}
.hero-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: .75rem 1.6rem;
    background: linear-gradient(135deg,#F59E0B,#D97706);
    color: #1a0a00;
    font-weight: 800;
    font-size: .85rem;
    letter-spacing: .02em;
    border-radius: 999px;
    text-decoration: none;
    transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    box-shadow: 0 4px 24px rgba(245,158,11,.35);
}
.hero-btn-primary:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 32px rgba(245,158,11,.5);
    filter: brightness(1.08);
}
.hero-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: .73rem 1.4rem;
    background: rgba(255,255,255,.07);
    color: rgba(255,255,255,.85);
    font-weight: 700;
    font-size: .85rem;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 999px;
    text-decoration: none;
    transition: background .2s ease, transform .2s ease, border-color .2s ease;
    backdrop-filter: blur(8px);
}
.hero-btn-ghost:hover {
    background: rgba(255,255,255,.14);
    border-color: rgba(255,255,255,.4);
    transform: translateY(-2px);
    color: #fff;
}

/* ── Trust pills ────────────────────────────────────────────── */
.hero-trust-row {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-bottom: 1.2rem;
    animation: hero-fadein .5s .28s ease both;
}
.hero-trust-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 500;
    color: rgba(255,255,255,.6);
    white-space: nowrap;
}
.hero-trust-pill svg { flex-shrink: 0; }

/* ── Progress bar ───────────────────────────────────────────── */
.hero-progress-track {
    height: 2px;
    background: rgba(255,255,255,.12);
    border-radius: 999px;
    overflow: hidden;
    margin: 0 -.5rem;
}
.hero-progress-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg,#F59E0B,#FBBF24);
    border-radius: 999px;
    transition: width linear;
}
.hero-progress-bar.is-running {
    width: 100%;
}

/* ── Navigation arrows ──────────────────────────────────────── */
.hero-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 30;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 50%;
    color: rgba(255,255,255,.8);
    cursor: pointer;
    transition: background .2s ease, transform .2s ease, border-color .2s ease;
    backdrop-filter: blur(10px);
}
.hero-arrow:hover {
    background: rgba(255,255,255,.2);
    border-color: rgba(255,255,255,.4);
    color: #fff;
    transform: translateY(-50%) scale(1.08);
}
.hero-arrow-prev { left: 1.25rem; }
.hero-arrow-next { right: 1.25rem; }
@media (max-width: 640px) {
    .hero-arrow { display: none; }
}

/* ── Thumbnail strip ────────────────────────────────────────── */
.hero-thumb-strip {
    display: flex;
    gap: 0;
    overflow-x: auto;
    scrollbar-width: none;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(16px);
    border-top: 1px solid rgba(255,255,255,.08);
}
.hero-thumb-strip::-webkit-scrollbar { display: none; }

.hero-thumb {
    position: relative;
    flex: 1 1 0;
    min-width: 80px;
    max-width: 180px;
    height: 72px;
    overflow: hidden;
    cursor: pointer;
    border: none;
    background: none;
    padding: 0;
    transition: flex .3s ease;
}
@media (max-width: 640px) {
    .hero-thumb { height: 56px; min-width: 64px; }
}
.hero-thumb.is-active { flex: 1.6 1 0; }

.hero-thumb-img {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: .45;
    transition: opacity .3s ease;
}
.hero-thumb:hover .hero-thumb-img,
.hero-thumb.is-active .hero-thumb-img { opacity: .75; }

.hero-thumb-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 4px 8px;
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .04em;
    color: rgba(255,255,255,.0);
    background: linear-gradient(to top,rgba(0,0,0,.7),transparent);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color .3s ease;
    text-align: left;
}
.hero-thumb.is-active .hero-thumb-label,
.hero-thumb:hover .hero-thumb-label {
    color: rgba(255,255,255,.85);
}

/* amber accent line on active thumb */
.hero-thumb::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: #F59E0B;
    transform: scaleX(0);
    transition: transform .3s ease;
    transform-origin: left;
}
.hero-thumb.is-active::after { transform: scaleX(1); }

/* ── Scroll cue ─────────────────────────────────────────────── */
.hero-scroll-cue {
    position: absolute;
    bottom: 88px;
    right: 2rem;
    z-index: 25;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,.35);
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    pointer-events: none;
}
.hero-scroll-line {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, rgba(255,255,255,.3), transparent);
    animation: hero-scroll-pulse 1.8s ease-in-out infinite;
}
@keyframes hero-scroll-pulse {
    0%,100% { opacity:.3; transform:scaleY(1); }
    50% { opacity:.8; transform:scaleY(.6); transform-origin:top; }
}
@media (max-width: 640px) {
    .hero-scroll-cue { display: none; }
}

/* ── Entrance animations ────────────────────────────────────── */
@keyframes hero-fadein {
    from { opacity:0; } to { opacity:1; }
}
@keyframes hero-slidein {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Re-animate on slide change ─────────────────────────────── */
.hero-glass-card.is-transitioning .hero-brand-chip,
.hero-glass-card.is-transitioning .hero-headline,
.hero-glass-card.is-transitioning .hero-desc,
.hero-glass-card.is-transitioning .hero-cta-row,
.hero-glass-card.is-transitioning .hero-trust-row {
    animation: none;
    opacity: 0;
    transform: translateY(10px);
}
.hero-glass-card.is-settling .hero-brand-chip {
    animation: hero-fadein .45s .00s ease both;
}
.hero-glass-card.is-settling .hero-headline {
    animation: hero-slidein .5s .06s ease both;
}
.hero-glass-card.is-settling .hero-desc {
    animation: hero-slidein .5s .12s ease both;
}
.hero-glass-card.is-settling .hero-cta-row {
    animation: hero-fadein .45s .19s ease both;
}
.hero-glass-card.is-settling .hero-trust-row {
    animation: hero-fadein .45s .26s ease both;
}
</style>

{{-- ════════════════════════════════════════════════════════════
     HERO SCRIPT
     ════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    const SLIDE_DURATION = 5000;   // ms between auto-advances
    const TRANSITION_MS  = 900;    // must match CSS opacity transition

    const slides   = Array.from(document.querySelectorAll('.hero-slide'));
    const thumbs   = Array.from(document.querySelectorAll('.hero-thumb'));
    const card     = document.getElementById('heroCard');
    const counter  = document.getElementById('heroCounterCurrent');
    const bar      = document.getElementById('heroProgressBar');
    const prevBtn  = document.getElementById('heroPrev');
    const nextBtn  = document.getElementById('heroNext');
    const section  = document.getElementById('hero-section');

    let current  = 0;
    let timer    = null;
    let barTimer = null;
    const total  = slides.length;

    /* ── helpers ─────────────────────────────────────────────── */
    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function resetProgress(durationMs) {
        clearTimeout(barTimer);
        bar.style.transition = 'none';
        bar.classList.remove('is-running');
        bar.style.width = '0%';
        // force reflow
        void bar.offsetWidth;
        bar.style.transition = 'width ' + durationMs + 'ms linear';
        // tiny delay so CSS picks up the transition
        barTimer = setTimeout(function () {
            bar.classList.add('is-running');
            bar.style.width = '100%';
        }, 30);
    }

    function goTo(index, skipAnimation) {
        if (index === current && !skipAnimation) return;
        const prev = current;
        current = ((index % total) + total) % total;

        /* update slide visibility */
        slides[prev].classList.remove('is-active');
        slides[current].classList.add('is-active');

        /* update thumbnails */
        thumbs[prev].classList.remove('is-active');
        thumbs[current].classList.add('is-active');

        /* update counter */
        counter.textContent = pad(current + 1);

        /* stagger card text */
        if (!skipAnimation && card) {
            card.classList.remove('is-settling');
            card.classList.add('is-transitioning');
            setTimeout(function () {
                card.classList.remove('is-transitioning');
                card.classList.add('is-settling');
            }, TRANSITION_MS / 2);
        }

        /* restart progress bar */
        resetProgress(SLIDE_DURATION);
    }

    function next() { goTo(current + 1, false); }
    function prev() { goTo(current - 1, false); }

    function startAutoplay() {
        clearInterval(timer);
        timer = setInterval(next, SLIDE_DURATION);
    }

    function resetAutoplay() {
        clearInterval(timer);
        startAutoplay();
    }

    /* ── events ──────────────────────────────────────────────── */
    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            goTo(parseInt(this.dataset.index, 10), false);
            resetAutoplay();
        });
    });

    if (prevBtn) prevBtn.addEventListener('click', function () { prev(); resetAutoplay(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { next(); resetAutoplay(); });

    /* pause on hover / focus-within */
    if (section) {
        section.addEventListener('mouseenter', function () { clearInterval(timer); });
        section.addEventListener('mouseleave', function () { startAutoplay(); });
        section.addEventListener('focusin',    function () { clearInterval(timer); });
        section.addEventListener('focusout',   function () { startAutoplay(); });
    }

    /* keyboard navigation */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft')  { prev(); resetAutoplay(); }
        if (e.key === 'ArrowRight') { next(); resetAutoplay(); }
    });

    /* touch / swipe support */
    var touchStartX = 0;
    if (section) {
        section.addEventListener('touchstart', function (e) {
            touchStartX = e.touches[0].clientX;
        }, { passive: true });
        section.addEventListener('touchend', function (e) {
            var dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 40) {
                if (dx < 0) next(); else prev();
                resetAutoplay();
            }
        }, { passive: true });
    }

    /* ── init ────────────────────────────────────────────────── */
    // Trigger Ken Burns on slide 0 immediately
    slides[0].classList.add('is-active');
    card && card.classList.add('is-settling');
    resetProgress(SLIDE_DURATION);
    startAutoplay();
})();
</script>
<!-- Travel Services Section - Main Content -->
<section id="services" class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 md:mb-20">
            <span class="inline-block px-5 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold mb-6 uppercase tracking-wider">{{ __('messages.travel_services') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6">{{ __('messages.our_travel_services') }}</h2>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">{{ __('messages.travel_services_desc') }}</p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            @foreach($travelServices as $service)
            <div class="group relative bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 flex flex-col">
                <!-- Image -->
                <div class="relative h-56 overflow-hidden">
                    @if($service->image)
                        <img src="{{ asset($service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    @endif
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <!-- Type Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-block px-4 py-1.5 bg-blue-600 text-white rounded-full text-xs font-bold shadow-lg uppercase tracking-wide">{{ $service->type }}</span>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="flex-1 p-6 md:p-8 flex flex-col">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors leading-tight">{{ $service->name }}</h3>
                    <p class="text-gray-600 leading-relaxed line-clamp-3 mb-6">{{ Str::limit($service->description, 150) }}</p>
                    
                    <!-- Price & CTA -->
                    <div class="mt-auto pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-sm text-gray-500 block">{{ __('messages.starting_from') }}</span>
                                <span class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    {{ format_price($service->price) }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('travel-services.show', $service) }}" class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transform hover:scale-105 transition-all duration-300">
                            {{ __('messages.view_details') }}
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 md:py-28 bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 relative overflow-hidden">
    <!-- Gradient Orbs -->
    <div class="absolute top-10 right-20 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 left-20 w-64 h-64 bg-blue-500/15 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-5 py-2 bg-white/10 text-blue-300 rounded-full text-sm font-bold mb-6 uppercase tracking-wider border border-white/10">{{ __('messages.why_choose') }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-6">{{ __('messages.tagline') }}</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
            $features = [
                ['icon' => 'M5 13l4 4L19 7', 'name' => __('messages.comfort'), 'desc' => __('messages.comfort_desc'), 'color' => 'emerald'],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => __('messages.complete'), 'desc' => __('messages.complete_desc'), 'color' => 'blue'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => __('messages.affordable'), 'desc' => __('messages.affordable_desc'), 'color' => 'amber'],
                ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'name' => __('messages.enjoy'), 'desc' => __('messages.enjoy_desc'), 'color' => 'purple'],
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'name' => __('messages.happy'), 'desc' => __('messages.happy_desc'), 'color' => 'pink'],
                ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'name' => __('messages.custom'), 'desc' => __('messages.custom_desc'), 'color' => 'indigo'],
            ];
            @endphp

            @foreach($features as $feature)
            <div class="group text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-{{ $feature['color'] }}-400 to-{{ $feature['color'] }}-600 rounded-2xl flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-all duration-300 shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="text-white font-bold mb-2">{{ $feature['name'] }}</h3>
                <p class="text-blue-200/60 text-sm hidden md:block">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 md:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-10 md:p-16 border border-blue-100">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-6">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ __('messages.stay_updated') }}</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">{{ __('messages.subscribe_newsletter') }}</p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input type="email" placeholder="{{ __('messages.enter_email') }}" class="flex-1 px-6 py-4 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 border border-gray-200 shadow-sm">
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transform hover:scale-105 transition-all duration-300">
                    {{ __('messages.subscribe') }}
                </button>
            </form>
            
            <p class="mt-6 text-gray-400 text-sm">{{ __('messages.privacy_notice') }}</p>
        </div>
    </div>
</section>

@endsection
