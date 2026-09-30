<style>
    /* ── KEUNGGULAN PREMIUM ────────────────────── */
    .cv-adv-premium {
        background: #ffffff;
        padding: 5rem 0;
    }

    .cv-adv-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    .cv-adv-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 2rem;
        margin-bottom: 3.5rem;
    }

    .cv-adv-section-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #64748B;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .cv-adv-section-label::before {
        content: '';
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #DC2626;
    }

    .cv-adv-section-title {
        font-size: clamp(2rem, 3.5vw, 3rem);
        font-weight: 500;
        color: #0F172A;
        line-height: 1.15;
        letter-spacing: -0.025em;
    }

    /* Premium 7-card grid — matches about section */
    .cv-adv-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }

    /* Special first card: full-height accent (like about card-2) */
    .cv-adv-card-v2 {
        background: #F1F5F9;
        border-radius: 22px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 240px;
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s;
    }

    .cv-adv-card-v2:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(14, 165, 233, 0.1);
    }

    .cv-adv-card-v2.accent {
        background: #DC2626;
    }

    .cv-adv-card-v2.accent-dark {
        background: #0F172A;
    }

    .cv-adv-card-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        flex-shrink: 0;
    }

    .cv-adv-card-icon-wrap.blue-bg {
        background: #FEE2E2;
        color: #DC2626;
    }

    .cv-adv-card-icon-wrap.white-bg {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .cv-adv-card-icon-wrap.dark-bg {
        background: rgba(255, 255, 255, 0.06);
        color: #EF4444;
    }

    .cv-adv-card-num {
        font-size: 2.75rem;
        font-weight: 400;
        line-height: 1;
        letter-spacing: -0.04em;
        color: #0F172A;
        margin-bottom: 0.5rem;
    }

    .cv-adv-card-num.white {
        color: #fff;
    }

    .cv-adv-card-num.blue {
        color: #EF4444;
    }

    .cv-adv-card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #0F172A;
        margin-bottom: 0.5rem;
    }

    .cv-adv-card-title.white {
        color: #fff;
    }

    .cv-adv-card-title.light {
        color: rgba(255, 255, 255, 0.9);
    }

    .cv-adv-card-desc {
        font-size: 0.8125rem;
        line-height: 1.65;
        color: #64748B;
        margin-top: auto;
    }

    .cv-adv-card-desc.white {
        color: rgba(255, 255, 255, 0.75);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .cv-adv-cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .cv-adv-premium {
            padding: 3.5rem 0;
        }

        .cv-adv-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .cv-adv-header p {
            text-align: left !important;
        }

        .cv-adv-cards {
            grid-template-columns: none !important;
            grid-auto-flow: column;
            grid-auto-columns: 78vw;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 1rem;
        }

        .cv-adv-cards::-webkit-scrollbar {
            display: none;
        }

        .cv-adv-cards>* {
            scroll-snap-align: start;
        }

        .cv-adv-card-v2 {
            min-height: 180px;
        }

        .cv-adv-card-span-2 {
            grid-column: auto !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
    }
</style>

<section class="cv-adv-premium" id="keunggulan">
    <div class="cv-adv-inner">
        {{-- Section Header --}}
        <div class="cv-adv-header">
            <div>
                <div class="cv-adv-section-label">KEUNGGULAN</div>
                <h2 class="cv-adv-section-title">Mengapa Pilih<br>CV. Bintang Energy Surabaya?</h2>
            </div>
            <p style="max-width:320px;font-size:0.875rem;color:#64748B;line-height:1.65;text-align:right;">
                Solusi perlindungan dan pelapisan berkualitas tinggi untuk kebutuhan maritim dan industri skala besar di seluruh Indonesia.
            </p>
        </div>

        {{-- Premium Cards Grid --}}
        <div class="cv-adv-cards">

            {{-- Card 1: Kualitas --}}
            <div class="cv-adv-card-v2 accent" data-aos="fade-up" data-aos-delay="0" style="background:#0F172A;">
                <div class="cv-adv-card-icon-wrap" style="background:#DC2626;">
                    <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <div class="cv-adv-card-num white">#1</div>
                <div class="cv-adv-card-title white">Kualitas Premium</div>
                <div class="cv-adv-card-desc white">Menyediakan produk cat dari merk terbaik yang sudah teruji tahan
                    lama dan anti korosi.</div>
            </div>

            {{-- Card 2: Pengiriman --}}
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="80">
                <div class="cv-adv-card-icon-wrap" style="background:#FEE2E2; color:#DC2626;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12l5 5L20 7" />
                    </svg>
                </div>
                <div class="cv-adv-card-title">Cakupan Luas</div>
                <div class="cv-adv-card-desc">Melayani pengiriman ke seluruh wilayah Indonesia dengan ekspedisi yang
                    terpercaya dan berasuransi.</div>
            </div>

            {{-- Card 3: Resmi --}}
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="160">
                <div class="cv-adv-card-icon-wrap" style="background:#FEE2E2; color:#DC2626;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                </div>
                <div class="cv-adv-card-title">Distributor Resmi</div>
                <div class="cv-adv-card-desc">Produk 100% original, tersertifikasi dan didatangkan langsung dari pabrik
                    resmi.</div>
            </div>

            {{-- Card 4: Kapasitas --}}
            <div class="cv-adv-card-v2 accent-dark" data-aos="fade-up" data-aos-delay="240" style="background:#DC2626;">
                <div class="cv-adv-card-icon-wrap" style="background:rgba(255,255,255,0.2); color:#fff;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="cv-adv-card-num" style="color:#fff;">B2B</div>
                <div class="cv-adv-card-title light">Siap Skala Proyek</div>
                <div class="cv-adv-card-desc white">Memiliki kapasitas besar untuk memenuhi permintaan proyek industri
                    dan kontraktor.</div>
            </div>

            {{-- Card 5: Perlindungan --}}
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="0">
                <div class="cv-adv-card-icon-wrap" style="background:#FEE2E2; color:#DC2626;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                </div>
                <div class="cv-adv-card-title" style="margin-top:auto;">Pelindungan Maksimal</div>
                <div class="cv-adv-card-desc">Cocok diaplikasikan untuk perlindungan aset maritim maupun industri dari
                    kondisi ekstrim.</div>
            </div>

            {{-- Card 6: Support --}}
            <div class="cv-adv-card-v2" data-aos="fade-up" data-aos-delay="80">
                <div class="cv-adv-card-icon-wrap" style="background:#FEE2E2; color:#DC2626;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div class="cv-adv-card-title" style="margin-top:auto;">Layanan Konsultasi</div>
                <div class="cv-adv-card-desc">Tim kami selalu siap mendampingi Anda dalam memilih jenis cat dan
                    spesifikasi yang paling tepat.</div>
            </div>

            {{-- Card 7: Pengalaman spans 2 columns --}}
            <div class="cv-adv-card-v2 cv-adv-card-span-2" data-aos="fade-up" data-aos-delay="160"
                style="grid-column: span 2; flex-direction: row; gap: 2rem; align-items: center;">
                <div class="cv-adv-card-icon-wrap"
                    style="flex-shrink:0; width:60px; height:60px; background:#FEE2E2; color:#DC2626;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <div>
                    <div class="cv-adv-card-title" style="font-size:1.125rem; margin-bottom:0.5rem;">Berpengalaman Sejak
                        2007</div>
                    <div class="cv-adv-card-desc">Lebih dari 18 tahun menjadi andalan perusahaan BUMN dan swasta dalam
                        menyuplai produk cat pelindung berstandar internasional.</div>
                </div>
            </div>

        </div>
    </div>
</section>
