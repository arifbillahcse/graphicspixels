<?php /* Template Name: Reviews */ ?>
<?php get_header(); ?>

<style>
        /* ===== Page-scoped styles — Reviews ===== */

        /* --- Page header --- */
        .rv-header { padding: 150px 0 50px; background: var(--gradient-soft); }
        .rv-header .rv-eyebrow {
            font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14px;
            letter-spacing: 2px; text-transform: uppercase; color: var(--magenta);
        }
        .rv-header .rv-eyebrow b { color: var(--navy); }
        .rv-header h1 {
            font-family: 'Poppins', sans-serif; font-size: 44px; font-weight: 800;
            color: var(--navy); text-transform: uppercase; line-height: 1.1; margin-top: 10px;
        }

        /* --- Video review grid --- */
        .rv-videos { padding: 50px 0 30px; }
        .rv-video-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; }
        .rv-card { cursor: pointer; border-radius: var(--radius); overflow: hidden; }
        .rv-card .vt-thumb { padding-top: 60%; border-radius: var(--radius); }
        .rv-card .vt-thumb-overlay { border-radius: var(--radius); }

        /* --- CTA row --- */
        .rv-cta-row { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; margin-top: 44px; }

        /* --- Rating summary --- */
        .rv-summary { padding: 60px 0; background: var(--bg-light); }
        .rv-summary-inner { display: grid; grid-template-columns: 1fr 1.2fr; gap: 60px; align-items: center; }
        .rv-summary-stars { color: #ffb800; font-size: 26px; letter-spacing: 3px; margin-bottom: 12px; }
        .rv-summary-score { display: flex; align-items: baseline; gap: 10px; }
        .rv-summary-score b { font-family: 'Poppins', sans-serif; font-size: 30px; font-weight: 800; color: var(--navy); }
        .rv-summary h2 { font-family: 'Poppins', sans-serif; font-size: 30px; font-weight: 800; color: var(--navy); margin: 6px 0 10px; }
        .rv-summary p { color: var(--text-light); font-size: 15px; max-width: 420px; }
        .rv-bars-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm); padding: 32px 36px; }
        .rv-bars-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
        .rv-bars-head span { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--navy); font-size: 18px; }
        .rv-bars-head .rv-google { display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--text-light); font-size: 14px; }
        .rv-bars-head .rv-google i { font-size: 18px; }
        .rv-bar-row { display: flex; align-items: center; gap: 14px; margin-bottom: 14px; }
        .rv-bar-label { font-size: 13px; font-weight: 600; color: var(--text-light); width: 56px; flex-shrink: 0; }
        .rv-bar-track { flex: 1; height: 8px; border-radius: 100px; background: #e9e9f2; overflow: hidden; }
        .rv-bar-fill { height: 100%; border-radius: 100px; background: var(--navy); }
        .rv-bar-pct { font-size: 13px; font-weight: 700; color: var(--navy); width: 42px; text-align: right; flex-shrink: 0; }

        /* --- Written reviews grid --- */
        .rv-written { padding: 80px 0; }
        .rv-written-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .rv-review { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm); padding: 26px; display: flex; flex-direction: column; gap: 14px; transition: var(--transition); }
        .rv-review:hover { box-shadow: var(--shadow-md); transform: translateY(-4px); }
        .rv-review-head { display: flex; align-items: center; gap: 12px; }
        .rv-avatar { width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; font-weight: 700; color: #fff; font-size: 17px; background: var(--gradient); }
        .rv-review-meta { display: flex; flex-direction: column; line-height: 1.3; }
        .rv-review-name { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--navy); font-size: 15px; }
        .rv-review-loc { font-size: 12.5px; color: var(--text-light); }
        .rv-review-time { margin-left: auto; font-size: 12px; color: var(--text-light); flex-shrink: 0; }
        .rv-review-stars { color: #ffb800; font-size: 14px; letter-spacing: 1px; }
        .rv-review-text { font-size: 14px; color: var(--text); line-height: 1.7; flex: 1; }
        .rv-review-foot { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--text-light); }
        .rv-review-foot i { font-size: 15px; }
        .rv-review.is-hidden { display: none; }
        .rv-loadmore { text-align: center; margin-top: 40px; }

        /* --- Featured on --- */
        .rv-featured { padding: 60px 0; background: var(--bg-light); border-top: 1px solid var(--border); }
        .rv-featured h3 { text-align: center; font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; color: var(--navy); margin-bottom: 36px; }
        .rv-featured-logos { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 50px; }
        .rv-featured-logos span { display: inline-flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 20px; color: #9a9ab0; transition: var(--transition); }
        .rv-featured-logos span i { font-size: 26px; }
        .rv-featured-logos span:hover { color: var(--navy); }

        /* --- Dark CTA banner --- */

        /* --- Responsive --- */
        @media (max-width: 992px) {
            .rv-summary-inner { grid-template-columns: 1fr; gap: 36px; }
            .rv-written-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .rv-header { padding: 120px 0 40px; }
            .rv-header h1 { font-size: 30px; }
            .rv-video-grid { grid-template-columns: 1fr; }
            .rv-written-grid { grid-template-columns: 1fr; }
            .rv-featured-logos { gap: 30px; }
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HEADER ============ -->
    <section class="rv-header">
        <div class="container">
            <p class="rv-eyebrow">Trusted by <b>1,700+ Clients Worldwide</b></p>
            <h1>Real Results From Real<br>Clients Around the World</h1>
        </div>
    </section>

    <!-- ============ VIDEO REVIEWS ============ -->
    <section class="rv-videos">
        <div class="container">
            <div class="rv-video-grid" id="rvVideoGrid">

                <div class="rv-card" data-video-id="U_mQ6MHt-wI">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/U_mQ6MHt-wI/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Mark Vence</span>
                                <span class="vt-card-company">Fashion and Lifestyle Brand Manager · USA</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="An_AGr0jDMQ">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/An_AGr0jDMQ/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Neo N.</span>
                                <span class="vt-card-company">E-Commerce Post-Production Manager · USA</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="y23k3pzTGQw">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/y23k3pzTGQw/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Jorge</span>
                                <span class="vt-card-company">Creative Agency Director · Portugal</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="L9fTaCA_lvI">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/L9fTaCA_lvI/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Brooklyn</span>
                                <span class="vt-card-company">Photography Studio Owner · USA</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="QtF0jp6hfbY">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/QtF0jp6hfbY/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Arthur Brad</span>
                                <span class="vt-card-company">Visual Content Photography · Germany</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="HdKJDaa8K2Q">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/HdKJDaa8K2Q/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Matteo</span>
                                <span class="vt-card-company">Creative Agency · Italy</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="ymumIHlhIJc">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/ymumIHlhIJc/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Sarah Allen</span>
                                <span class="vt-card-company">eCommerce Photography · France</span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card" data-video-id="VCtTRd37F2M">
                    <div class="vt-thumb" style="background-image:url('https://img.youtube.com/vi/VCtTRd37F2M/hqdefault.jpg');">
                        <div class="vt-thumb-overlay"></div>
                        <button class="vt-play" aria-label="Play video"><span class="vt-play-icon"></span></button>
                        <div class="vt-card-footer">
                            <div class="vt-card-info">
                                <span class="vt-card-name">Anika Berg</span>
                                <span class="vt-card-company">Berg Studio · Spain </span>
                            </div>
                            <div class="vt-stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="rv-cta-row">
                <a href="#" class="btn btn-primary">See More Reviews</a>
                <a href="#free-trial" class="btn btn-outline">Get a Free Trial</a>
            </div>
        </div>
    </section>

    <!-- ============ RATING SUMMARY ============ -->
    <section class="rv-summary">
        <div class="container">
            <div class="rv-summary-inner">
                <div>
                    <div class="rv-summary-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <div class="rv-summary-score"><b>4.9</b><span style="color:var(--text-light);font-size:14px;">/ 5 &nbsp;&mdash;&nbsp; 1,700+ verified clients</span></div>
                    <h2>Over 1,700 Five-Star Reviews</h2>
                    <p>More than 8 million product images edited for photographers, e-commerce brands, and studios across 50+ countries. Our clients keep coming back — because quality speaks louder than promises.</p>
                </div>
                <div class="rv-bars-card">
                    <div class="rv-bars-head">
                        <span>Reviews</span>
                        <span class="rv-google"><i class="fab fa-google"></i> Google</span>
                    </div>
                    <div class="rv-bar-row">
                        <span class="rv-bar-label">5-Star</span>
                        <span class="rv-bar-track"><span class="rv-bar-fill" style="width:97%;"></span></span>
                        <span class="rv-bar-pct">97%</span>
                    </div>
                    <div class="rv-bar-row">
                        <span class="rv-bar-label">4-Star</span>
                        <span class="rv-bar-track"><span class="rv-bar-fill" style="width:3%;"></span></span>
                        <span class="rv-bar-pct">3%</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WRITTEN REVIEWS ============ -->
    <section class="rv-written">
        <div class="container">
            <div class="rv-written-grid" id="rvWrittenGrid">

                <div class="rv-review">
                    <div class="rv-review-head">
                        <div class="rv-avatar">A</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Anne Bergeron</span><span class="rv-review-loc">Paris, France</span></div>
                        <span class="rv-review-time">3 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">We send hundreds of fashion product photos every week for background removal. Graphics Pixels handles every batch without a single mistake — clean edges, pure white backgrounds, ready for our Shopify store the next morning. Four years and counting.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review">
                    <div class="rv-review-head">
                        <div class="rv-avatar">C</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Camille Nuttall</span><span class="rv-review-loc">London, UK</span></div>
                        <span class="rv-review-time">5 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">My Amazon listings went from mediocre to polished after just one round of retouching from Graphics Pixels. Their color correction and skin-tone work is second to none. Response time is fast, revisions are free, and pricing is very fair.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review">
                    <div class="rv-review-head">
                        <div class="rv-avatar">J</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Jacky Chapman</span><span class="rv-review-loc">Sydney, Australia</span></div>
                        <span class="rv-review-time">5 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">I shoot jewellery and the clipping path work from Graphics Pixels is extraordinary — every curve traced perfectly, even on fine chains and stone settings. They save me hours every week and the quality is consistently better than my previous in-house editor.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review">
                    <div class="rv-review-head">
                        <div class="rv-avatar">C</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Christoffer Johansson</span><span class="rv-review-loc">Stockholm, Sweden</span></div>
                        <span class="rv-review-time">7 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">We shoot furniture for a large Scandinavian catalogue. Graphics Pixels handles our color grading and perspective corrections at scale — 300-plus images per shoot — with remarkable consistency across every frame. Our print quality has never looked better.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review">
                    <div class="rv-review-head">
                        <div class="rv-avatar">T</div>
                        <div class="rv-review-meta"><span class="rv-review-name">TLF Multi Media</span><span class="rv-review-loc">New York, USA</span></div>
                        <span class="rv-review-time">8 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">We brought Graphics Pixels in for a 2,000-image e-commerce project with a 48-hour deadline. They delivered every image on time, perfectly retouched, with consistent shadows and white backgrounds throughout. Remarkable turnaround. We use them exclusively now.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review">
                    <div class="rv-review-head">
                        <div class="rv-avatar">A</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Amanda Hardwick</span><span class="rv-review-loc">Toronto, Canada</span></div>
                        <span class="rv-review-time">8 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">I run a boutique photography studio and Graphics Pixels handles all my post-processing — retouching, background replacement, drop shadows. Their pricing fits small-studio budgets but the quality rivals agencies charging triple. Never missed a delivery once.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">D</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Daniella Carruthers</span><span class="rv-review-loc">Manchester, UK</span></div>
                        <span class="rv-review-time">9 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">Our ghost mannequin work for an apparel brand looked incredible. The joins are seamless and the hollow neck effect is exactly what fashion buyers expect. Two small revisions were turned around within the hour. Absolutely brilliant service from start to finish.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">A</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Audrey Mballo</span><span class="rv-review-loc">Lyon, France</span></div>
                        <span class="rv-review-time">1 year ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">I needed natural drop shadows added to 150 product photos for a new collection launch. Graphics Pixels nailed the angle, softness and opacity on the very first pass — it looked like the shadows were captured in-studio. Impressive skill and very professional communication.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">R</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Ryan Osei</span><span class="rv-review-loc">Vancouver, Canada</span></div>
                        <span class="rv-review-time">11 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">Complex hair masking on model shots — notoriously difficult. Graphics Pixels got every flyaway strand right with pixel-perfect precision. I've tried three other retouching services this year; none come close to this level of detail at this price point. My go-to from now on.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">M</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Marco Bianchi</span><span class="rv-review-loc">Milan, Italy</span></div>
                        <span class="rv-review-time">4 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">I handed over a box of my grandparents' torn, water-damaged photographs and honestly expected a rough result. What came back looked like the day they were taken — faces rebuilt, colour restored, cracks gone. My whole family was moved to tears. Extraordinary restoration work.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">P</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Priya Nair</span><span class="rv-review-loc">Dubai, UAE</span></div>
                        <span class="rv-review-time">6 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">Our AI-generated product visuals kept coming out with warped hands and garbled logos. Graphics Pixels cleaned up every artefact by hand and made them genuinely usable for our campaign. Fast, meticulous, and they actually understood what looked "off" better than we did.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">L</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Lukas Weber</span><span class="rv-review-loc">Berlin, Germany</span></div>
                        <span class="rv-review-time">7 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">We needed photorealistic 3D renders of a furniture line before the physical samples even existed. The models Graphics Pixels built were indistinguishable from studio photography — right down to the fabric texture and lighting. It saved us an entire product shoot.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">S</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Sofia Reyes</span><span class="rv-review-loc">Madrid, Spain</span></div>
                        <span class="rv-review-time">3 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">They edit all our social media reels and product demo videos now. Clean cuts, tasteful colour grading, and the motion graphics match our brand perfectly. Turnaround is always ahead of schedule and the revision process is painless. A genuinely reliable creative partner.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">J</div>
                        <div class="rv-review-meta"><span class="rv-review-name">James Whitfield</span><span class="rv-review-loc">Austin, USA</span></div>
                        <span class="rv-review-time">9 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">As a corporate photographer I send Graphics Pixels dozens of executive headshots a week. The retouching is natural — nobody looks plastic — skin tones stay true and backgrounds are swapped flawlessly. My clients constantly compliment the final images. Couldn't run my business without them.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">Y</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Yuki Tanaka</span><span class="rv-review-loc">Tokyo, Japan</span></div>
                        <span class="rv-review-time">5 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">We migrated our entire jewellery catalogue to a new platform and needed thousands of images re-edited to spec. Graphics Pixels handled the volume without a hiccup — consistent reflections, clean shadows, exact sizing. Their attention to detail on tiny gemstone facets is remarkable.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">E</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Emily Carter</span><span class="rv-review-loc">Auckland, New Zealand</span></div>
                        <span class="rv-review-time">10 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">Vector conversion of our hand-drawn logo and packaging artwork was flawless — crisp, scalable, print-ready files delivered exactly as promised. They even flagged a couple of alignment issues we'd missed in the original. Thoughtful, skilled team that clearly cares about the outcome.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">O</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Olivia Andersson</span><span class="rv-review-loc">Copenhagen, Denmark</span></div>
                        <span class="rv-review-time">6 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">Bulk e-commerce editing at scale is where they truly shine. We push 500-plus SKUs a month through them — background removal, colour correction, consistent cropping — and every batch comes back uniform and on brand. The reliability alone has transformed our listing workflow.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

                <div class="rv-review is-hidden">
                    <div class="rv-review-head">
                        <div class="rv-avatar">T</div>
                        <div class="rv-review-meta"><span class="rv-review-name">Thabo Molefe</span><span class="rv-review-loc">Cape Town, South Africa</span></div>
                        <span class="rv-review-time">8 months ago</span>
                    </div>
                    <div class="rv-review-stars">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
                    <p class="rv-review-text">Their ghost mannequin and neck-joint work took our clothing brand's product pages to a whole new level. The garments look full and three-dimensional without a model, and the consistency across an entire collection is spot on. Fast, affordable, and genuinely a pleasure to work with.</p>
                    <span class="rv-review-foot"><i class="fab fa-google"></i> See on Google</span>
                </div>

            </div>

            <div class="rv-loadmore">
                <button class="btn btn-primary" id="rvLoadMore">Load More</button>
            </div>
        </div>
    </section>

    <!-- ============ FEATURED ON ============ -->
    <section class="rv-featured">
        <div class="container">
            <h3>Trusted & Reviewed Across Leading Platforms</h3>
            <div class="rv-featured-logos">
                <span><i class="fab fa-google"></i> Google Reviews</span>
                <span><i class="fas fa-star"></i> Trustpilot</span>
                <span><i class="fab fa-shopify"></i> Shopify Partners</span>
                <span><i class="fab fa-amazon"></i> Amazon Community</span>
                <span><i class="fas fa-camera-retro"></i> ShotKit</span>
                <span><i class="fas fa-award"></i> Clutch.co</span>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->

    <!-- ============ VIDEO MODAL ============ -->
    <div class="vt-modal" id="vtModal">
        <div class="vt-modal-backdrop" id="vtBackdrop"></div>
        <div class="vt-modal-box">
            <button class="vt-modal-close" id="vtClose" aria-label="Close video">
                <span class="vt-close-icon"></span>
            </button>
            <div class="vt-modal-frame">
                <iframe id="vtIframe" src="" title="Client review video" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Reviews page interactions -->
    <script>
    (function () {
        var modal   = document.getElementById('vtModal');
        var backdrop= document.getElementById('vtBackdrop');
        var closeBtn= document.getElementById('vtClose');
        var iframe  = document.getElementById('vtIframe');

        function openVideo(id) {
            iframe.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0';
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeVideo() {
            iframe.src = '';
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }

        // Each video card opens the modal with its video id
        document.querySelectorAll('.rv-card').forEach(function (card) {
            card.addEventListener('click', function () {
                openVideo(card.getAttribute('data-video-id'));
            });
        });

        closeBtn.addEventListener('click', closeVideo);
        backdrop.addEventListener('click', closeVideo);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeVideo();
        });

        // Load more written reviews
        var loadBtn = document.getElementById('rvLoadMore');
        if (loadBtn) {
            loadBtn.addEventListener('click', function () {
                var hidden = document.querySelectorAll('.rv-review.is-hidden');
                hidden.forEach(function (el) { el.classList.remove('is-hidden'); });
                loadBtn.style.display = 'none';
            });
        }
    })();
    </script>

<?php get_footer(); ?>
