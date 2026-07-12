<?php /* Template Name: Freistellen Bilder Ecommerce (DE) */ ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
<style>
        /* ===== Page-scoped styles — Freistellen E-commerce ===== */

        /* --- Hero showcase (same structure as drop-shadow-service.html) --- */
        .dt-showcase {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/clipping%20path%20cover.png');
            background-size: auto calc(100% - 100px);
            background-position: right bottom;
            background-repeat: no-repeat;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .dt-showcase-content {
            position: relative; z-index: 2;
            max-width: 52%;
            padding: 120px 0 80px;
        }
        .dt-showcase-eyebrow {
            display: inline-block;
            background: rgba(195,0,157,0.08);
            color: var(--magenta); font-size: 12px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 6px 16px; border-radius: 50px;
            margin-bottom: 20px;
        }
        .dt-showcase-content h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 42px; font-weight: 800;
            color: var(--navy); margin-bottom: 18px; line-height: 1.15;
        }
        .dt-showcase-lead {
            font-weight: 600; font-size: 16px;
            color: #111; margin-bottom: 14px; line-height: 1.6;
        }
        .dt-showcase-content p {
            font-size: 15px; color: #555;
            line-height: 1.8; margin-bottom: 16px;
        }
        .dt-showcase-icons {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 10px 20px; margin: 24px 0 32px; list-style: none; padding: 0;
        }
        .dt-showcase-icons li {
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; font-weight: 500; color: var(--navy);
        }
        .dt-showcase-icons li i {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(195,0,157,0.1); display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 13px; color: var(--magenta); flex-shrink: 0;
        }
        .dt-showcase-actions { display: flex; gap: 16px; flex-wrap: wrap; }
        @media (max-width: 992px) {
            .dt-showcase-content { max-width: 55%; }
        }
        @media (max-width: 768px) {
            .dt-showcase {
                min-height: auto;
                flex-direction: column;
                background-image: none;
                padding-top: 90px;
                align-items: stretch;
                justify-content: flex-start;
            }
            .dt-showcase-image {
                display: block;
                width: 100%;
                aspect-ratio: 1108 / 874;
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/clipping%20path%20cover.png');
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
                margin-bottom: 24px;
            }
            .dt-showcase-content {
                max-width: 100%;
                padding: 0 0 40px;
            }
            .dt-showcase-content h1 { font-size: 28px; }
            .dt-showcase-icons { grid-template-columns: 1fr; }
        }
        @media (min-width: 769px) {
            .dt-showcase-image { display: none; }
        }

        /* --- Generic section heads (reuse site classes via .container) --- */
        .dt-section { padding: 100px 0; }
        .dt-section.alt { background: var(--bg-light); }
        .dt-head { text-align: center; max-width: 760px; margin: 0 auto 60px; }
        .dt-head .section-title { margin-bottom: 14px; }
        .dt-head p { color: var(--text-light); font-size: 17px; }

        /* --- Value cards (Vorteile) --- */
        .dt-values { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .dt-value-card {
            background: var(--white); border-radius: var(--radius); padding: 40px 32px;
            box-shadow: var(--shadow-sm); border: 1px solid var(--border);
            transition: var(--transition);
        }
        .dt-value-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-8px); border-color: rgba(195,0,157,0.25); }
        .dt-value-icon {
            width: 64px; height: 64px; border-radius: 18px; background: var(--gradient);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 24px; box-shadow: 0 8px 20px rgba(195,0,157,0.3);
        }
        .dt-value-card h3 { font-size: 20px; margin-bottom: 14px; }
        .dt-value-card p { color: var(--text-light); font-size: 15px; line-height: 1.7; }

        /* --- Services grid --- */
        .dt-services { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
        .dt-service-item {
            display: flex; gap: 22px; padding: 32px; background: var(--white);
            border: 1px solid var(--border); border-radius: var(--radius);
            box-shadow: var(--shadow-sm); transition: var(--transition);
        }
        .dt-service-item:hover { box-shadow: var(--shadow-md); transform: translateY(-5px); }
        .dt-service-ico {
            flex-shrink: 0; width: 60px; height: 60px; border-radius: 16px;
            background: var(--gradient-soft); color: var(--magenta);
            display: flex; align-items: center; justify-content: center; font-size: 24px;
        }
        .dt-service-item h3 { font-size: 19px; margin-bottom: 8px; }
        .dt-service-item p { color: var(--text-light); font-size: 14.5px; line-height: 1.65; }

        /* --- Process (dark) --- */
        .dt-process {
            padding: 100px 0; position: relative; overflow: hidden;
            background:
                radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(155deg, #01015E 0%, #16006e 45%, #0a0050 75%, #01015E 100%);
            background-size: 28px 28px, 100% 100%;
        }
        .dt-process .dt-head .section-title { color: #fff; }
        .dt-process .dt-head p { color: rgba(255,255,255,0.7); }
        .dt-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; position: relative; z-index: 2; }
        .dt-step { text-align: center; }
        .dt-step-num {
            width: 60px; height: 60px; border-radius: 50%; background: var(--gradient);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 24px;
            margin: 0 auto 24px; box-shadow: 0 10px 30px rgba(195,0,157,0.4);
        }
        .dt-step h3 { color: #fff; font-size: 20px; margin-bottom: 12px; }
        .dt-step p { color: rgba(255,255,255,0.72); font-size: 14.5px; line-height: 1.7; }

        /* --- Pricing --- */
        .dt-pricing { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; max-width: 920px; margin: 0 auto; }
        .dt-price-card {
            background: var(--white); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 40px 36px; transition: var(--transition); position: relative;
        }
        .dt-price-card:hover { box-shadow: var(--shadow-md); }
        .dt-price-card.featured { border: 2px solid var(--magenta); box-shadow: var(--shadow-lg); }
        .dt-price-badge {
            position: absolute; top: 0; right: 32px; transform: translateY(-50%);
            background: var(--magenta); color: #fff; font-family: 'Poppins', sans-serif;
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
            padding: 6px 16px; border-radius: 100px;
        }
        .dt-price-card h3 { font-size: 22px; margin-bottom: 10px; }
        .dt-price-card > p { color: var(--text-light); font-size: 14.5px; margin-bottom: 20px; }
        .dt-price-amount {
            font-family: 'Poppins', sans-serif; font-size: 28px; font-weight: 800;
            color: var(--navy); margin-bottom: 24px;
        }
        .dt-price-card.featured .dt-price-amount { color: var(--magenta); }
        .dt-price-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px; }
        .dt-price-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 14.5px; color: var(--text); }
        .dt-price-list li i { color: var(--magenta); margin-top: 4px; font-size: 13px; flex-shrink: 0; }

        /* --- Testimonial --- */
        .dt-testimonial { padding: 100px 0; background: var(--bg-light); text-align: center; }
        .dt-testimonial-stars { color: #ffb800; font-size: 24px; margin-bottom: 24px; letter-spacing: 4px; }
        .dt-testimonial blockquote {
            font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; font-style: italic;
            color: var(--navy); line-height: 1.45; max-width: 760px; margin: 0 auto 28px;
        }
        .dt-testimonial-text { font-size: 17px; color: var(--text-light); max-width: 680px; margin: 0 auto 28px; line-height: 1.8; }
        .dt-testimonial-author { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--navy); }
        .dt-testimonial-author span { color: var(--magenta); font-weight: 600; }

        /* --- FAQ --- */
        .dt-faq-list { max-width: 820px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px; }
        .dt-faq-item { border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; background: var(--white); }
        .dt-faq-q {
            width: 100%; display: flex; justify-content: space-between; align-items: center; gap: 16px;
            padding: 24px 28px; background: none; border: none; cursor: pointer; text-align: left;
            font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 600; color: var(--navy);
            transition: var(--transition);
        }
        .dt-faq-q:hover { background: var(--gradient-soft); }
        .dt-faq-q .dt-faq-icon { color: var(--magenta); font-size: 22px; flex-shrink: 0; transition: var(--transition); }
        .dt-faq-item.open .dt-faq-icon { transform: rotate(45deg); }
        .dt-faq-a { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
        .dt-faq-a-inner { padding: 0 28px 24px; color: var(--text-light); font-size: 15px; line-height: 1.8; border-top: 1px solid var(--border); padding-top: 20px; }

        /* --- Final CTA --- */
        .dt-cta {
            padding: 100px 0; text-align: center; position: relative; overflow: hidden;
            background: linear-gradient(155deg, #01015E 0%, #16006e 50%, #0a0050 100%);
        }
        .dt-cta h2 { color: #fff; font-size: 40px; font-weight: 800; margin-bottom: 18px; }
        .dt-cta p { color: rgba(255,255,255,0.8); font-size: 18px; max-width: 600px; margin: 0 auto 36px; }

        /* --- Responsive --- */
        @media (max-width: 992px) {
            .dt-values { grid-template-columns: 1fr; }
            .dt-services { grid-template-columns: 1fr; }
            .dt-steps { grid-template-columns: 1fr; gap: 48px; }
            .dt-pricing { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .dt-section { padding: 70px 0; }
            .dt-process, .dt-testimonial, .dt-cta { padding: 70px 0; }
            .dt-cta h2 { font-size: 30px; }
            .dt-testimonial blockquote { font-size: 22px; }
            .dt-service-item { flex-direction: column; }
        }
    </style>
</head>
<body <?php body_class(); ?>>
<!-- ============ HEADER / NAVIGATION ============ -->
    <header class="header" id="header">
        <div class="container nav-container">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="logo">
                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/graphics-pixels-logo-2-HR.png" alt="Graphics Pixels Logo">
            </a>
            <nav class="nav" id="nav-menu">
                <ul class="nav-list">
                    <li class="nav-item"><a href="<?php echo esc_url( home_url('/services/') ); ?>" class="nav-link">Services</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">Photo Editing <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu dropdown-wide">
                            <li><a href="<?php echo esc_url( home_url('/clipping-path-service/') ); ?>"><i class="fas fa-chevron-right"></i> Clipping Path service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/photo-retouching-service/') ); ?>"><i class="fas fa-chevron-right"></i> Photo Retouching service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/ghost-mannequin-service/') ); ?>"><i class="fas fa-chevron-right"></i> Ghost Mannequin service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/headshot-photo-editing/') ); ?>"><i class="fas fa-chevron-right"></i> Headshot photo editing</a></li>
                            <li><a href="<?php echo esc_url( home_url('/background-removal-service/') ); ?>"><i class="fas fa-chevron-right"></i> Background Removal service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/color-correction-service/') ); ?>"><i class="fas fa-chevron-right"></i> Color Correction Service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/drop-shadow-service/') ); ?>"><i class="fas fa-chevron-right"></i> Drop Shadow Service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/image-masking-service/') ); ?>"><i class="fas fa-chevron-right"></i> Image Masking service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/ecommerce-image-editing-services/') ); ?>"><i class="fas fa-chevron-right"></i> E-commerce Image Editing</a></li>
                            <li><a href="<?php echo esc_url( home_url('/photo-restoration-service/') ); ?>"><i class="fas fa-chevron-right"></i> Photo Restoration Service</a></li>
                            <li><a href="<?php echo esc_url( home_url('/ai-generated-image-fixes/') ); ?>"><i class="fas fa-chevron-right"></i> AI-generated Image Fixes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">3D Service <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo esc_url( home_url('/3d-product-modeling-service/') ); ?>"><i class="fas fa-chevron-right"></i> 3D Modeling</a></li>
                            <li><a href="<?php echo esc_url( home_url('/3d-rendering-service/') ); ?>"><i class="fas fa-chevron-right"></i> 3D Rendering</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="<?php echo esc_url( home_url('/video-editing/') ); ?>" class="nav-link">Video Editing</a></li>
                    <li class="nav-item"><a href="<?php echo esc_url( home_url('/portfolio/') ); ?>" class="nav-link">Portfolio</a></li>
                    <li class="nav-item"><a href="<?php echo esc_url( home_url('/pricing/') ); ?>" class="nav-link">Pricing</a></li>
                    <li class="nav-item"><a href="<?php echo esc_url( home_url('/about-us/') ); ?>" class="nav-link">About Us</a></li>
                    <li class="nav-item"><a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="nav-link">Contact</a></li>
                </ul>
                <a href="#free-trial" class="btn btn-primary nav-cta">Free Trial</a>
            </nav>
            <button class="nav-toggle" id="nav-toggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- ============ HERO / SHOWCASE ============ -->
    <section class="dt-showcase">
        <div class="dt-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="dt-showcase-content reveal" data-reveal="left">
                <span class="dt-showcase-eyebrow">✨ Premium-Postproduktion für den deutschen E-Commerce</span>
                <h1>Professionelles Bilder Freistellen — 100% Handgemacht</h1>
                <p class="dt-showcase-lead">Maximieren Sie die Conversion-Rate Ihres Online-Shops mit pixelgenauer Bildbearbeitung.</p>
                <p>Das Postproduktionsstudio <strong>Graphics Pixels</strong> liefert erstklassige visuelle Lösungen für E-Commerce-Marken, Fotografen und Agenturen in Deutschland. Keine fehlerhaften KI-Automatisierungen – nur präzise Pfade per Photoshop-Zeichenstift-Werkzeug. Lieferung innerhalb von 24 bis 48 Stunden.</p>
                <ul class="dt-showcase-icons">
                    <li><i class="fas fa-shield-halved"></i> NDA &amp; Vertraulichkeit</li>
                    <li><i class="fas fa-bolt"></i> 24h-48h Lieferung</li>
                    <li><i class="fas fa-lock"></i> DSGVO-Konform</li>
                </ul>
                <div class="dt-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Jetzt kostenlose Testphase starten (Bis zu 5 Bilder)</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TRUST COUNTER ============ -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" data-count="120" data-suffix="+">120+</div>
                    <div class="stat-label">Interne Bildbearbeiter</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" data-count="250" data-suffix="+">250+</div>
                    <div class="stat-label">Globale Projekte</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" data-count="24" data-suffix="-48h">24-48h</div>
                    <div class="stat-label">Regellieferzeit</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" data-count="100" data-suffix="%">100%</div>
                    <div class="stat-label">Manuelle Pfade</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VORTEILE ============ -->
    <section class="dt-section" id="vorteile">
        <div class="container">
            <div class="dt-head">
                <span class="section-tag">Vorteile</span>
                <h2 class="section-title">Warum Graphics Pixels wählen?</h2>
                <p>Menschliche Präzision statt fehlerhafter Algorithmen für Ihren maximalen Verkaufserfolg.</p>
            </div>
            <div class="dt-values">
                <div class="dt-value-card">
                    <div class="dt-value-icon"><i class="fas fa-pen-nib"></i></div>
                    <h3>Exklusives Freistellen per Hand (Keine KI)</h3>
                    <p>Automatische KI-Tools versagen oft bei feinen Details. Unser internes Team von über 120 Bildbearbeitern erstellt jeden Pfad manuell. Das garantiert absolut saubere Kanten für den Zoom-Modus auf Shopify, Amazon und für den High-End-Druck.</p>
                </div>
                <div class="dt-value-card">
                    <div class="dt-value-icon"><i class="fas fa-shirt"></i></div>
                    <h3>Experten für Invisible-Mannequin (Ghost Mannequin)</h3>
                    <p>Verleihen Sie Ihrer Kleidung natürliches Volumen und perfekte Symmetrie. Wir fügen Kragenrückseiten präzise ein, entfernen Schaufensterpuppen unsichtbar und korrigieren Stofffalten nach den strengen Qualitätsstandards der Modeindustrie.</p>
                </div>
                <div class="dt-value-card">
                    <div class="dt-value-icon"><i class="fas fa-shield-halved"></i></div>
                    <h3>Datensicherheit &amp; DSGVO-Konformität</h3>
                    <p>Wir wissen, wie wichtig der Schutz neuer Kollektionen und sensibler Unternehmensdaten in Deutschland ist. Alle Bilddaten werden auf sicheren Servern verarbeitet. Gerne unterzeichnen wir vor Projektbeginn eine Vertraulichkeitsvereinbarung (NDA).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ LEISTUNGEN ============ -->
    <section class="dt-section alt" id="leistungen">
        <div class="container">
            <div class="dt-head">
                <span class="section-tag">Leistungen</span>
                <h2 class="section-title">Unsere Postproduktions-Dienstleistungen</h2>
                <p>Erstklassige Bildbearbeitung auf den Punkt gebracht für Web, Print und Marktplätze.</p>
            </div>
            <div class="dt-services">
                <div class="dt-service-item">
                    <div class="dt-service-ico"><i class="fas fa-image"></i></div>
                    <div>
                        <h3>Bilder Freistellen &amp; Hintergrundentfernung</h3>
                        <p>Reinweiße Hintergründe optimiert für Online-Marktplätze (Amazon/eBay) oder transparente Hintergründe (PNG/PSD) perfekt vorbereitet für Ihr Webdesign.</p>
                    </div>
                </div>
                <div class="dt-service-item">
                    <div class="dt-service-ico"><i class="fas fa-gem"></i></div>
                    <div>
                        <h3>High-End Schmuck- und Produktretusche</h3>
                        <p>Präzise Entfernung störender Spiegelungen, Polieren von rauen Metalloberflächen und gezieltes Hervorheben des natürlichen Glanzes von Edelsteinen.</p>
                    </div>
                </div>
                <div class="dt-service-item">
                    <div class="dt-service-ico"><i class="fas fa-scissors"></i></div>
                    <div>
                        <h3>Komplexes Maskieren (Image Masking)</h3>
                        <p>Chirurgisch exaktes Freistellen extrem schwieriger Motive wie feine Haare, Pelze, filigrane Spitzen, Netze und transparente Objekte.</p>
                    </div>
                </div>
                <div class="dt-service-item">
                    <div class="dt-service-ico"><i class="fas fa-clone"></i></div>
                    <div>
                        <h3>Natürliche Schatten und Spiegelungen</h3>
                        <p>Erstellung von realistischen Schlagschatten, weichen Verläufen oder edlen Spiegelungen für mehr Tiefe, Gewicht und Dreidimensionalität.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ ABLAUF ============ -->
    <section class="dt-process" id="ablauf">
        <div class="container">
            <div class="dt-head">
                <span class="section-tag light">Ablauf</span>
                <h2 class="section-title">Wie funktioniert es?</h2>
                <p>Ein reibungsloser, schneller und vollkommen transparenter Workflow für Ihr Team.</p>
            </div>
            <div class="dt-steps">
                <div class="dt-step">
                    <div class="dt-step-num">1</div>
                    <h3>Bilder sicher hochladen</h3>
                    <p>Laden Sie Ihre Rohdateien über unser geschütztes Kundenportal hoch oder teilen Sie einen Link (Drive, Dropbox, FTP) inklusive Ihrer präzisen Bearbeitungsvorgaben.</p>
                </div>
                <div class="dt-step">
                    <div class="dt-step-num">2</div>
                    <h3>Bearbeitung &amp; Qualitätskontrolle</h3>
                    <p>Unsere Experten bearbeiten jedes Detail manuell per Hand. Im Anschluss prüft ein Senior-Supervisor jedes Bild penibel auf die Einhaltung Ihrer Qualitätsstandards.</p>
                </div>
                <div class="dt-step">
                    <div class="dt-step-num">3</div>
                    <h3>Fertige Daten herunterladen</h3>
                    <p>Sie erhalten die fertigen Bilder innerhalb von 24–48 Stunden im Wunschformat zurück – auf Wunsch direkt performance-optimiert in WebP oder AVIF.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PREISE ============ -->
    <section class="dt-section" id="preise">
        <div class="container">
            <div class="dt-head">
                <span class="section-tag">Preise</span>
                <h2 class="section-title">Flexible Preise nach Maß</h2>
                <p>Keine versteckten Fixkosten oder Knebelabos. Sie zahlen ausschließlich für das, was Sie bestellen.</p>
            </div>
            <div class="dt-pricing">
                <div class="dt-price-card">
                    <h3>Kleinere Mengen</h3>
                    <p>Perfekt für Start-ups, Boutiquen und kleinere Kampagnentests.</p>
                    <div class="dt-price-amount">Individuelles Angebot</div>
                    <ul class="dt-price-list">
                        <li><i class="fas fa-check"></i> Keine Mindestbestellmenge nötig</li>
                        <li><i class="fas fa-check"></i> Formate: PSD, PNG, WebP und AVIF</li>
                        <li><i class="fas fa-check"></i> Schneller, persönlicher Kundensupport</li>
                    </ul>
                </div>
                <div class="dt-price-card featured">
                    <span class="dt-price-badge">Beliebt</span>
                    <h3>Großvolumen / E-Commerce</h3>
                    <p>Ideal für etablierte Online-Shops und Full-Service-Agenturen mit hohem Monatsvolumen.</p>
                    <div class="dt-price-amount">Degressive Preise 🔥</div>
                    <ul class="dt-price-list">
                        <li><i class="fas fa-check"></i> Stark vergünstigte Mengenstaffelung</li>
                        <li><i class="fas fa-check"></i> Kapazitäten für über 3.000+ Bilder/Woche</li>
                        <li><i class="fas fa-check"></i> Dediziertes Editoren-Team &amp; Projektmanager</li>
                        <li><i class="fas fa-check"></i> DSGVO-konforme NDA-Absicherung</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TESTIMONIAL ============ -->
    <section class="dt-testimonial">
        <div class="container">
            <div class="dt-testimonial-stars">★ ★ ★ ★ ★</div>
            <blockquote>"Ein verlässlicher Partner für unser E-Commerce-Wachstum"</blockquote>
            <p class="dt-testimonial-text">
                "Wir lagern das gesamte Retuschevolumen unseres Mode- und Schuh-Shops in Hamburg an Graphics Pixels aus. Sie bearbeiten über 3.000 Bilder pro Woche mit gleichbleibend chirurgischer Präzision bei Farbanpassungen und Ghost Mannequins. Die Zuverlässigkeit ist absolut erstklassig."
            </p>
            <div class="dt-testimonial-author">— Matthias K., <span>Head of E-Commerce, Berlin</span></div>
        </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="dt-section alt" id="faq">
        <div class="container">
            <div class="dt-head">
                <span class="section-tag">FAQ</span>
                <h2 class="section-title">Häufig gestellte Fragen (FAQ)</h2>
                <p>Glasklare Antworten – optimiert für die Suchanfragen und Web-Anforderungen im Jahr 2026.</p>
            </div>
            <div class="dt-faq-list">
                <div class="dt-faq-item">
                    <button class="dt-faq-q">
                        <span>Gibt es eine Mindestbestellmenge bei Graphics Pixels?</span>
                        <i class="fas fa-plus dt-faq-icon"></i>
                    </button>
                    <div class="dt-faq-a">
                        <div class="dt-faq-a-inner">
                            Nein, wir verlangen keine Mindestbestellmenge. Wir betreuen kleine Chargen von 10 Bildern für Start-ups mit der gleichen technischen Sorgfalt wie Großprojekte von über 10.000 Bildern für etablierte Marken, und bieten flexible, degressive Preise für den europäischen Markt.
                        </div>
                    </div>
                </div>
                <div class="dt-faq-item">
                    <button class="dt-faq-q">
                        <span>In welchen Dateiformaten liefern Sie die bearbeiteten Bilder?</span>
                        <i class="fas fa-plus dt-faq-icon"></i>
                    </button>
                    <div class="dt-faq-a">
                        <div class="dt-faq-a-inner">
                            Wir liefern in gängigen Formaten wie PSD mit Ebenen, TIFF und PNG. Um im Jahr 2026 die strengen Core Web Vitals von Google zu erfüllen und die Ladezeit Ihres Shops zu minimieren, optimieren wir die Daten auf Wunsch direkt in den Next-Gen-Formaten WebP und AVIF ohne Qualitätsverlust.
                        </div>
                    </div>
                </div>
                <div class="dt-faq-item">
                    <button class="dt-faq-q">
                        <span>Wie läuft der kostenlose Test ab?</span>
                        <i class="fas fa-plus dt-faq-icon"></i>
                    </button>
                    <div class="dt-faq-a">
                        <div class="dt-faq-a-inner">
                            Der Prozess ist transparent, kostenlos und unverbindlich. Sie laden einfach 1 bis 5 Testbilder über unser Online-Formular hoch und fügen Ihre Bearbeitungswünsche hinzu. Unser Team bearbeitet die Bilder und sendet sie Ihnen zurück. Sie entscheiden sich erst für eine Zusammenarbeit, wenn Sie mit der Qualität zu 100% zufrieden sind.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA FINAL ============ -->
    <section class="dt-cta" id="testphase">
        <div class="container">
            <h2>Bereit für makellose Produktbilder?</h2>
            <p>Schließen Sie sich erfolgreichen Online-Marken an und vertrauen Sie auf präzise, manuelle Postproduktion von Graphics Pixels.</p>
            <a href="#free-trial" class="btn btn-primary">Jetzt kostenlose Testphase starten</a>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-col footer-about">
                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/graphics-pixels-logo-2-HR.png" alt="Graphics Pixels" class="footer-logo">
                <p class="footer-address">
                    <i class="fas fa-location-dot"></i>
                    Unit 4, Storm 12 Plaza Shopping Centre, 54 St Marys Road, Southampton, United Kingdom, SO14 0BH
                </p>
                <p class="footer-contact"><i class="fas fa-phone"></i> +44 7462 284915</p>
                <p class="footer-contact"><i class="fas fa-envelope"></i> info@graphicspixels.com</p>
            </div>
            <div class="footer-col">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#free-trial">Free Trial</a></li>
                    <li><a href="<?php echo esc_url( home_url('/pricing/') ); ?>">Pricing</a></li>
                    <li><a href="<?php echo esc_url( home_url('/about-us/') ); ?>">About</a></li>
                    <li><a href="<?php echo esc_url( home_url('/contact/') ); ?>">Contact</a></li>
                    <li><a href="<?php echo esc_url( home_url('/blog/') ); ?>">Blog</a></li>
                    <li><a href="<?php echo esc_url( home_url('/faq/') ); ?>">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="<?php echo esc_url( home_url('/clipping-path-service/') ); ?>">Clipping Path Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/photo-retouching-service/') ); ?>">Photo Retouching Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/ghost-mannequin-service/') ); ?>">Ghost Mannequin Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/headshot-photo-editing/') ); ?>">Headshot Photo Editing</a></li>
                    <li><a href="<?php echo esc_url( home_url('/background-removal-service/') ); ?>">Background Removal Service</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>More Services</h4>
                <ul>
                    <li><a href="<?php echo esc_url( home_url('/color-correction-service/') ); ?>">Color Correction Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/drop-shadow-service/') ); ?>">Drop Shadow Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/image-masking-service/') ); ?>">Image Masking Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/ecommerce-image-editing-services/') ); ?>">E-commerce Image Editing</a></li>
                    <li><a href="<?php echo esc_url( home_url('/photo-restoration-service/') ); ?>">Photo Restoration Service</a></li>
                    <li><a href="<?php echo esc_url( home_url('/ai-generated-image-fixes/') ); ?>">AI-generated Image Fixes</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <p>Copyright &copy; 2013 GRAPHICSPIXELS. All rights reserved.</p>
                <div class="social-links">
                    <a href="https://www.pinterest.com/graphicspixels/" target="_blank" rel="noopener" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="https://www.youtube.com/@graphicspixels" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://twitter.com/graphicspixelss" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/grap.hicspixels/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/graphicspixels/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61573139442036" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="back-to-top" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>

    <!-- ============ FREE TRIAL MODAL ============ -->
    <div class="trial-modal-overlay" id="trialModalOverlay" role="dialog" aria-modal="true" aria-label="Free Trial Form">
        <div class="trial-modal" id="trialModal">
            <button class="trial-modal-close" id="trialModalClose" aria-label="Close modal">
                <i class="fas fa-times"></i>
            </button>
            <div class="trial-modal-head">
                <span class="trial-modal-tag">Get Started</span>
                <h2 class="trial-modal-title">Get Your Free Trial</h2>
            </div>
            <form class="free-trial-form" id="modal-trial-form">
                <div class="form-row">
                    <input type="text" placeholder="Your Name*" required>
                    <input type="email" placeholder="Add Email*" required>
                </div>
                <div class="form-row">
                    <input type="tel" placeholder="Phone*" required>
                    <input type="url" placeholder="Website">
                </div>
                <select required>
                    <option value="" disabled selected>Select The Service</option>
                    <option>Clipping Path</option>
                    <option>Ghost Mannequin &amp; Neck Joint</option>
                    <option>Photo Retouching</option>
                    <option>Background Removal</option>
                    <option>Color Correction</option>
                    <option>Image Masking</option>
                    <option>3D Service</option>
                    <option>Video Editing</option>
                </select>
                <textarea placeholder="Your message" rows="3"></textarea>
                <div class="file-upload">
                    <label for="modal-file-input"><i class="fas fa-cloud-arrow-up"></i> Choose a file</label>
                    <input type="file" id="modal-file-input">
                    <span class="file-name">No file chosen</span>
                </div>
                <p class="upload-note">If the size is more than 25 MB, share your images via cloud (Google Drive, Dropbox or WeTransfer).</p>
                <input type="url" placeholder="Paste the link here (URL)">
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>
    </div>

    <!-- WhatsApp Chat Button -->
    <a href="https://wa.me/8801890373731" target="_blank" class="whatsapp-button" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- FAQ accordion -->
    <script>
    (function () {
        // --- FAQ accordion ---
        document.querySelectorAll('.dt-faq-item').forEach(function (item) {
            var q = item.querySelector('.dt-faq-q');
            var a = item.querySelector('.dt-faq-a');
            q.addEventListener('click', function () {
                var isOpen = item.classList.contains('open');
                document.querySelectorAll('.dt-faq-item').forEach(function (other) {
                    other.classList.remove('open');
                    other.querySelector('.dt-faq-a').style.maxHeight = null;
                });
                if (!isOpen) {
                    item.classList.add('open');
                    a.style.maxHeight = a.scrollHeight + 'px';
                }
            });
        });
    })();
    </script>
<?php wp_footer(); ?>
</body>
</html>
