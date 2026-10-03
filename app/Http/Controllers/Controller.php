@extends('layouts.app')

@section('title', $brand . ' - We Care About Your Shoes')

@push('styles')
<style>
  /* ── HERO ── */
  .hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 80px 60px 60px;
    min-height: calc(100vh - 76px);
    position: relative;
    overflow: hidden;
  }

  .hero-left { max-width: 520px; z-index: 2; }

  .hero-title {
    font-size: 68px;
    font-weight: 800;
    line-height: 1.08;
    margin-bottom: 24px;
  }
  .hero-title .highlight { color: var(--orange); }
  .hero-title .normal    { color: var(--dark); }

  .hero-desc {
    font-size: 17px;
    font-weight: 500;
    color: var(--gray);
    line-height: 1.7;
    margin-bottom: 40px;
    max-width: 420px;
  }

  .hero-cta { display: flex; gap: 16px; flex-wrap: wrap; }

  .btn-primary {
    background: var(--orange); color: var(--white);
    border: none; padding: 14px 36px; border-radius: 30px;
    font-size: 16px; font-weight: 700; font-family: 'Poppins', sans-serif;
    cursor: pointer; transition: background .2s, transform .15s;
    text-decoration: none; display: inline-block;
  }
  .btn-primary:hover { background: var(--orange-light); transform: translateY(-2px); }

  .btn-outline {
    background: transparent; color: var(--dark);
    border: 2px solid #D0D0D0; padding: 13px 32px; border-radius: 30px;
    font-size: 16px; font-weight: 600; font-family: 'Poppins', sans-serif;
    cursor: pointer; transition: border-color .2s, color .2s;
    text-decoration: none; display: inline-block;
  }
  .btn-outline:hover { border-color: var(--orange); color: var(--orange); }

  /* STATS */
  .stats-row {
    display: flex; gap: 48px;
    margin-top: 48px; padding-top: 32px;
    border-top: 1px solid #EBEBEB;
  }
  .stat-item .num   { font-size: 28px; font-weight: 800; color: var(--orange); }
  .stat-item .label { font-size: 13px; color: var(--gray); font-weight: 500; }

  /* ── HERO RIGHT ── */
  .hero-right {
    position: relative;
    flex-shrink: 0;
    width: 520px;
    height: 520px;
  }

  .circle-ring {
    position: absolute;
    width: 460px; height: 460px;
    border-radius: 50%;
    border: 2px solid #E8E0D8;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
  }
  .circle-bg {
    position: absolute;
    width: 420px; height: 420px;
    border-radius: 50%;
    background: #F5F0EB;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
  }

  .shoe-img-wrap {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -48%);
    z-index: 1;
    width: 370px;
    text-align: center;
  }
  .shoe-img-wrap img {
    width: 100%;
    filter: drop-shadow(0 16px 32px rgba(0,0,0,0.13));
  }

  /* BADGES */
  .badge {
    position: absolute;
    background: var(--white);
    border-radius: 16px;
    padding: 12px 18px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    box-shadow: var(--shadow);
    z-index: 3;
    min-width: 190px;
  }
  .badge-top-left  { top: 60px;  left: -20px; animation: float 3s ease-in-out infinite; }
  .badge-mid-left  { top: 200px; left: -30px; animation: float 3s ease-in-out infinite; animation-delay: 1.5s; }
  .badge-contact   {
    top: 200px; right: -20px; min-width: 170px;
    animation: float 3s ease-in-out infinite;
    animation-delay: 0.8s;
    align-items: center;
    justify-content: space-between;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-6px); }
  }

  .badge-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: #F0F4FF;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 18px;
  }
  .badge-label { font-size: 13px; font-weight: 700; color: var(--dark); margin-bottom: 2px; }
  .badge-sub   { font-size: 11px; color: var(--gray); line-height: 1.4; }

  /* BEFORE / AFTER */
  .before-after {
    position: absolute;
    bottom: 40px; left: 50%;
    transform: translateX(-50%);
    display: flex;
    border-radius: 30px;
    overflow: hidden;
    z-index: 3;
  }
  .ba-before { background: #2B2B2B; color: #fff; padding: 10px 32px; font-size: 14px; font-weight: 700; }
  .ba-after  { background: var(--orange); color: #fff; padding: 10px 32px; font-size: 14px; font-weight: 700; }

  /* BG DECO */
  .bg-deco {
    position: absolute; right: -80px; top: -80px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(240,123,32,0.04);
  }

  /* RESPONSIVE */
  @media (max-width: 900px) {
    .hero { flex-direction: column; padding: 40px 20px; min-height: auto; gap: 40px; }
    .hero-title { font-size: 44px; }
    .hero-right { width: 340px; height: 340px; }
    .circle-bg   { width: 280px; height: 280px; }
    .circle-ring { width: 310px; height: 310px; }
    .shoe-img-wrap { width: 260px; }
    nav { padding: 0 20px; }
    .nav-links { display: none; }
  }
</style>
@endpush

@section('content')
<section class="hero">
  <div class="bg-deco"></div>

  {{-- LEFT --}}
  <div class="hero-left">
    <h1 class="hero-title">
      <span class="highlight">We care</span><br>
      <span class="normal">about your<br>shoes</span>
    </h1>

    <p class="hero-desc">
      Professional cleaning and care to keep your shoes fresh, clean, and like new.
    </p>

    <div class="hero-cta">
      <a href="#" class="btn-primary">Book Now</a>
      <a href="#" class="btn-outline">Learn More</a>
    </div>

    {{-- Stats from controller --}}
    <div class="stats-row">
      @foreach($stats as $stat)
        <div class="stat-item">
          <div class="num">{{ $stat['num'] }}</div>
          <div class="label">{{ $stat['label'] }}</div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- RIGHT: shoe visual --}}
  <div class="hero-right">
    <div class="circle-ring"></div>
    <div class="circle-bg"></div>

    {{-- Badges from controller --}}
    @foreach($badges as $badge)
      <div class="badge badge-{{ $badge['pos'] }}">
        <div class="badge-icon">{{ $badge['icon'] }}</div>
        <div>
          <div class="badge-label">{{ $badge['title'] }}</div>
          <div class="badge-sub">{{ $badge['sub'] }}</div>
        </div>
      </div>
    @endforeach

    {{-- Shoe image --}}
    <div class="shoe-img-wrap">
      @if(file_exists(public_path('images/shoes-before-after.png')))
        <img src="{{ asset('images/shoes-before-after.png') }}" alt="Before and After Shoe Cleaning"/>
      @else
        {{-- SVG placeholder --}}
        <svg viewBox="0 0 380 230" xmlns="http://www.w3.org/2000/svg" width="100%">
          <defs>
            <clipPath id="left-half"><rect x="0" y="0" width="190" height="230"/></clipPath>
            <clipPath id="right-half"><rect x="190" y="0" width="190" height="230"/></clipPath>
          </defs>
          {{-- Before (dirty) --}}
          <g clip-path="url(#left-half)">
            <ellipse cx="190" cy="185" rx="165" ry="30" fill="#BEB0A0" opacity="0.5"/>
            <path d="M30 170 Q60 90 140 75 Q200 65 250 80 Q310 95 340 140 Q350 160 340 175 Q200 185 30 170Z" fill="#A09080"/>
            <path d="M80 110 Q120 75 180 72 Q230 70 270 85" stroke="#888070" stroke-width="3" fill="none"/>
            <path d="M55 140 Q90 115 160 108 Q220 103 280 118" stroke="#8A7A6A" stroke-width="2.5" fill="none"/>
            <path d="M45 158 Q95 140 180 135 Q250 130 320 148" stroke="#8A7A6A" stroke-width="2" fill="none"/>
            <circle cx="120" cy="95" r="4" fill="#7A6A5A"/>
            <circle cx="160" cy="88" r="4" fill="#7A6A5A"/>
            <circle cx="200" cy="84" r="4" fill="#7A6A5A"/>
          </g>
          {{-- After (clean) --}}
          <g clip-path="url(#right-half)">
            <ellipse cx="190" cy="185" rx="165" ry="30" fill="#D8D8D8" opacity="0.5"/>
            <path d="M30 170 Q60 90 140 75 Q200 65 250 80 Q310 95 340 140 Q350 160 340 175 Q200 185 30 170Z" fill="#F0F0F0"/>
            <path d="M80 110 Q120 75 180 72 Q230 70 270 85" stroke="#DDD" stroke-width="3" fill="none"/>
            <path d="M55 140 Q90 115 160 108 Q220 103 280 118" stroke="#CCC" stroke-width="2.5" fill="none"/>
            <path d="M45 158 Q95 140 180 135 Q250 130 320 148" stroke="#CCC" stroke-width="2" fill="none"/>
            <circle cx="230" cy="90" r="5" fill="#DDD"/>
            <circle cx="260" cy="96" r="5" fill="#DDD"/>
            <circle cx="286" cy="106" r="5" fill="#DDD"/>
          </g>
          <line x1="190" y1="60" x2="190" y2="200" stroke="#fff" stroke-width="2.5" stroke-dasharray="6 3"/>
        </svg>
      @endif
    </div>

    {{-- Contact badge --}}
    <div class="badge badge-contact">
      <div>
        <div class="badge-sub">Contact no</div>
        <div class="badge-label">{{ $phone }}</div>
      </div>
      <div class="badge-icon" style="background:#FFF3E8;">📞</div>
    </div>

    {{-- Before / After pill --}}
    <div class="before-after">
      <div class="ba-before">Before</div>
      <div class="ba-after">After</div>
    </div>
  </div>
</section>
@endsection
