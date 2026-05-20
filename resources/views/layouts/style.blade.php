<style>
    :root {
    --primary: #0a0a0a; 
    --accent: #D4AF37;
    --accent-hover: #B5952F; 
    
    --secondary: #10b981;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --white: #ffffff;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        --radius: 0.75rem;
        --radius-lg: 1rem;
        --radius-xl: 1.5rem;
        --radius-full: 9999px;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--gray-50);
        color: var(--gray-800);
        line-height: 1.6;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Montserrat', 'Inter', sans-serif;
        font-weight: 700;
        line-height: 1.2;
        color: var(--primary);
    }
    a { text-decoration: none; color: inherit; transition: 0.3s; }
    img { max-width: 100%; height: auto; display: block; }
    button { cursor: pointer; border: none; font: inherit; }
    input, textarea { font: inherit; }

    /* ===== UTILITIES ===== */
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
    .flex { display: flex; }
    .flex-wrap { flex-wrap: wrap; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 0.5rem; }
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }
    .gap-8 { gap: 2rem; }
    .gap-12 { gap: 3rem; }
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: 1fr; }
    .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
    .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
    @media (min-width: 768px) {
        .md\:grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .md\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .md\:flex { display: flex; }
        .md\:hidden { display: none; }
    }
    @media (min-width: 1024px) {
        .lg\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
    }
    .text-center { text-align: center; }
    .text-sm { font-size: 0.875rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-2xl { font-size: 1.5rem; }
    .text-3xl { font-size: 1.875rem; }
    .text-4xl { font-size: 2.25rem; }
    .text-5xl { font-size: 3rem; }
    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mb-10 { margin-bottom: 2.5rem; }
    .mb-12 { margin-bottom: 3rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-6 { margin-top: 1.5rem; }
    .mt-8 { margin-top: 2rem; }
    .mt-12 { margin-top: 3rem; }
    .mt-20 { margin-top: 5rem; }
    .py-3 { padding: 0.75rem 0; }
    .py-4 { padding: 1rem 0; }
    .py-6 { padding: 1.5rem 0; }
    .py-8 { padding: 2rem 0; }
    .py-12 { padding: 3rem 0; }
    .py-20 { padding: 5rem 0; }
    .px-4 { padding: 0 1rem; }
    .px-6 { padding: 0 1.5rem; }
    .px-8 { padding: 0 2rem; }
    .rounded { border-radius: 0.25rem; }
    .rounded-lg { border-radius: var(--radius-lg); }
    .rounded-xl { border-radius: var(--radius-xl); }
    .rounded-full { border-radius: var(--radius-full); }
    .shadow { box-shadow: var(--shadow); }
    .shadow-lg { box-shadow: var(--shadow-lg); }
    .shadow-2xl { box-shadow: var(--shadow-2xl); }
    .overflow-hidden { overflow: hidden; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .fixed { position: fixed; }
    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
    .top-4 { top: 1rem; }
    .left-4 { left: 1rem; }
    .right-4 { right: 1rem; }
    .bottom-10 { bottom: 2.5rem; }
    .z-10 { z-index: 10; }
    .z-50 { z-index: 50; }
    .hidden { display: none; }
    .block { display: block; }
    .inline-block { display: inline-block; }
    .w-full { width: 100%; }
    .max-w-2xl { max-width: 42rem; }
    .max-w-3xl { max-width: 48rem; }
    .max-w-4xl { max-width: 56rem; }
    .h-48 { height: 12rem; }
    .h-96 { height: 24rem; }
    .min-h-screen { min-height: 100vh; }
    .object-cover { object-fit: cover; }
    .leading-tight { line-height: 1.25; }
    .leading-relaxed { line-height: 1.625; }
    .tracking-widest { letter-spacing: 0.1em; }
    .uppercase { text-transform: uppercase; }
    .italic { font-style: italic; }
    .transition { transition: all 0.3s ease; }
    .transform { transform: translateZ(0); }
    .backdrop-blur-sm { backdrop-filter: blur(4px); }

    /* ===== COLORS ===== */
    .bg-primary { background: var(--primary); }
    .bg-white { background: var(--white); }
    .bg-gray-50 { background: var(--gray-50); }
    .bg-gray-100 { background: var(--gray-100); }
    .bg-gray-200 { background: var(--gray-200); }
    .bg-accent { background: var(--accent); }
    .bg-cyan-100 { background: #cffafe; }
    .bg-orange-100 { background: #ffedd5; }
    .bg-blue-100 { background: #dbeafe; }
    .bg-white\/5 { background: rgba(255,255,255,0.05); }
    .bg-white\/10 { background: rgba(255,255,255,0.1); }
    .bg-white\/90 { background: rgba(255,255,255,0.9); }
    .bg-black { background: #000; }
    .bg-black\/50 { background: rgba(0,0,0,0.5); }
    .bg-black\/90 { background: rgba(0,0,0,0.9); }
    .bg-gradient-to-r { background: linear-gradient(to right, var(--tw-gradient-stops)); }
    .bg-gradient-to-br { background: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
    .from-cyan-400 { --tw-gradient-from: #22d3ee; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
    .to-blue-500 { --tw-gradient-to: #3b82f6; }
    .text-primary { color: var(--primary); }
    .text-white { color: var(--white); }
    .text-accent { color: var(--accent); }
    .text-cyan-400 { color: #22d3ee; }
    .text-cyan-600 { color: #0891b2; }
    .text-orange-500 { color: #f97316; }
    .text-blue-500 { color: #3b82f6; }
    .text-blue-600 { color: #2563eb; }
    .text-gray-300 { color: var(--gray-300); }
    .text-gray-400 { color: var(--gray-400); }
    .text-gray-500 { color: var(--gray-500); }
    .text-gray-600 { color: var(--gray-600); }
    .text-gray-700 { color: var(--gray-700); }
    .text-slate-300 { color: #cbd5e1; }
    .text-slate-400 { color: #94a3b8; }
    .text-slate-600 { color: #475569; }
    .text-slate-800 { color: #1e293b; }
    .text-transparent { color: transparent; }
    .bg-clip-text { background-clip: text; -webkit-background-clip: text; }
    .border { border: 1px solid; }
    .border-gray-300 { border-color: var(--gray-300); }
    .border-white\/20 { border-color: rgba(255,255,255,0.2); }
    .border-slate-500 { border-color: #64748b; }
    .border-slate-800 { border-color: #1e293b; }
    .border-t { border-top: 1px solid; }
  /* ===== NAVIGATION ===== */
    .nav { position: fixed; top: 0; left: 0; right: 0; z-index: 50; background: rgba(255,255,255,0.9); backdrop-filter: blur(4px); box-shadow: var(--shadow); }
    .nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; }
    .nav-logo { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
    .nav-logo span { color: var(--accent); }
    .nav-links { display: none; gap: 2rem; }
    .nav-links a { color: var(--gray-600); font-weight: 500; }
    .nav-links a:hover { color: var(--accent); }
    @media (min-width: 768px) { .nav-links { display: flex; } }
    /* ===== BADGES ===== */
    .badge { display: inline-block; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; border-radius: var(--radius-full); }
    .badge-cyan { background: var(--accent); color: white; }
    .badge-orange { background: #f97316; color: white; }
    .badge-purple { background: #a855f7; color: white; }
    .badge-blue { background: #2563eb; color: white; }
    .badge-gray { background: #64748b; color: white; }

    /* ===== BUTTONS ===== */
    .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 2rem; font-weight: 600; border-radius: var(--radius-full); transition: 0.3s; }
    .btn-primary { background: var(--accent); color: white; }
    .btn-primary:hover { background: #0891b2; }
    .btn-outline { border: 2px solid var(--gray-500); color: white; }
    .btn-outline:hover { border-color: white; }
    .btn-sm { padding: 0.5rem 1rem; font-size: 0.875rem; }
    .btn-block { display: flex; width: 100%; }

   

    /* ===== HERO SECTION ===== */
    .hero { position: relative; background: var(--primary); color: white; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; padding-top: 5rem; }
    .hero-grid { position: absolute; inset: 0; opacity: 0.1; background-image: linear-gradient(#06b6d4 1px, transparent 1px), linear-gradient(90deg, #06b6d4 1px, transparent 1px); background-size: 40px 40px; }
    .hero-content { position: relative; z-index: 10; text-align: center; max-width: 48rem; height: 85vh; }
    .hero-title { font-size: clamp(0.5rem, 2vw, 2.5rem); font-weight: 800; line-height: 1.1; margin-bottom: 1rem; }
    .hero-title span { font-size: clamp(4.5rem, 5vw, 4rem); background: linear-gradient(to right, #22d3ee, #3b82f6); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .hero-subtitle { font-size: 1.25rem; color: #cbd5e1; margin-bottom: 2.5rem; }
    .hero-cta { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .hero-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; max-width: 36rem; margin: 1.5rem auto 0; }
    .hero-stat-value { font-size: 2.5rem; font-weight: 700; color: var(--accent); }
    .hero-stat-label { font-size: 0.875rem; color: #94a3b8; margin-top: 0.25rem; }
    .scroll-indicator { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); animation: bounce 2s infinite; }
    @keyframes bounce { 0%, 100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-10px); } }

    /* ===== ABOUT SECTION ===== */
    .about { padding: 5rem 0; background: white; }
    .about-grid { display: grid; gap: 3rem; align-items: center; }
    @media (min-width: 768px) { .about-grid { grid-template-columns: 1fr 1fr; } }
    .about-text p { color: var(--gray-600); margin-bottom: 1rem; line-height: 1.75; }
    .about-text strong { color: var(--primary); }
    .about-features { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .about-feature { display: flex; align-items: center; gap: 0.75rem; }
    .about-feature i { color: var(--accent); font-size: 1.25rem; }
    .about-image { position: relative; }
    .about-image::before { content: ''; position: absolute; inset: -1rem; background: linear-gradient(to right, #22d3ee, #3b82f6); border-radius: var(--radius-xl); opacity: 0.2; filter: blur(20px); }
    .about-image img { position: relative; border-radius: var(--radius-xl); box-shadow: var(--shadow-2xl); width: 100%;height:500px;display: flex;float: right;
object-fit: cover; }
    .projects { padding: 5rem 0; background: var(--gray-50); }
    .projects-header { text-align: center; margin-bottom: 3rem; }
    .projects-header h2 { font-size: 2.25rem; margin-bottom: 1rem; }
    .projects-header p { color: var(--gray-600); max-width: 42rem; margin: 0 auto; }
    .filter-buttons { display: flex; justify-content: center; gap: 1rem; margin-bottom: 3rem; flex-wrap: wrap; }
    .filter-btn { padding: 0.5rem 1.5rem; border-radius: var(--radius-full); font-weight: 600; transition: 0.3s; background: white; color: var(--gray-600); box-shadow: var(--shadow); }
    .filter-btn:hover, .filter-btn.active { background: var(--accent); color: white; }
    .projects-grid { display: grid; gap: 2rem; grid-template-columns: 1fr; }
    @media (min-width: 768px) { .projects-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .projects-grid { grid-template-columns: repeat(3, 1fr); } }

    /* ===== PROJECT CARD ===== */
    .project-card { background: white; border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow); transition: 0.3s; }
    .project-card:hover { box-shadow: var(--shadow-2xl); transform: translateY(-4px); }
    .project-image { position: relative; height: 12rem; overflow: hidden; }
    .project-image img { width: 100%; height: 100%; object-fit: cover; }
    .project-image-placeholder { width: 100%; height: 100%; background: linear-gradient(to bottom right, #22d3ee, #3b82f6); display: flex; align-items: center; justify-content: center; }
    .project-image-placeholder i { font-size: 3rem; color: rgba(255,255,255,0.5); }
    .project-badges { position: absolute; top: 1rem; left: 1rem; right: 1rem; display: flex; justify-content: space-between; }
    .project-content { padding: 1.5rem; }
    .project-category { font-size: 0.75rem; font-weight: 700; color: var(--accent); text-transform: uppercase; }
    .project-title { font-size: 1.25rem; font-weight: 700; margin: 0.5rem 0; color: var(--primary); }
    .project-desc { font-size: 0.875rem; color: var(--gray-600); margin-bottom: 1rem; }
    .project-tags { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
    .project-tag { padding: 0.25rem 0.5rem; background: var(--gray-100); color: var(--gray-600); font-size: 0.75rem; border-radius: 0.25rem; }
    .project-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .project-btn { flex: 1; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 600; border-radius: 0.5rem; text-align: center; transition: 0.3s; }
    .project-btn-live { background: var(--accent); color: white; }
    .project-btn-live:hover { background: #0891b2; }
    .project-btn-details { background: var(--gray-600); color: white; }
    .project-btn-details:hover { background: #334155; }
    .project-icon-btn { padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: 0.5rem; transition: 0.3s; }
    .project-icon-btn:hover { border-color: var(--gray-600); }
    .project-note { font-size: 0.75rem; color: var(--gray-500); font-style: italic; margin-top: 0.75rem; }

    /* ===== SKILLS SECTION ===== */
    .skills { padding: 5rem 0; background: white; }
    .skills-header { text-align: center; margin-bottom: 3rem; }
    .skills-header h2 { font-size: 2.25rem; margin-bottom: 0.5rem; }
    .skills-header p { color: var(--gray-600); }
    .skills-grid { display: grid; gap: 2rem; grid-template-columns: 1fr; }
    @media (min-width: 768px) { .skills-grid { grid-template-columns: repeat(3, 1fr); } }
    .skill-card { background: var(--gray-50); border-radius: var(--radius-xl); padding: 2rem; transition: 0.3s; }
    .skill-card:hover { box-shadow: var(--shadow-lg); }
    .skill-icon { width: 3.5rem; height: 3.5rem; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; }
    .skill-icon.cyan { background: #cffafe; color: var(--accent); }
    .skill-icon.orange { background: #ffedd5; color: #f97316; }
    .skill-icon.blue { background: #dbeafe; color: #3b82f6; }
    .skill-icon i { font-size: 1.5rem; }
    .skill-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; }
    .skill-tags { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .skill-tag { padding: 0.25rem 0.75rem; background: white; color: var(--gray-600); font-size: 0.875rem; border-radius: var(--radius-full); }

    /* ===== CONTACT SECTION ===== */
    .contact { padding: 5rem 0; background: var(--primary); color: white; }
    .contact-grid { display: grid; gap: 3rem; grid-template-columns: 1fr; }
    @media (min-width: 768px) { .contact-grid { grid-template-columns: 1fr 1fr; } }
    .contact-info h2 { font-size: 2.25rem; margin-bottom: 1.5rem; }
    .contact-info p { color: #cbd5e1; margin-bottom: 2rem; line-height: 1.75; }
    .contact-item { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .contact-icon { width: 3rem; height: 3rem; border-radius: var(--radius-full); background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; }
    .contact-icon i { color: var(--accent); }
    .contact-label { font-size: 0.875rem; color: #94a3b8; }
    .contact-value { color: white; }
    .contact-value a:hover { color: var(--accent); }
    .social-links { display: flex; gap: 1rem; margin-top: 2rem; }
    .social-link { width: 2.5rem; height: 2.5rem; border-radius: var(--radius-full); background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .social-link:hover { background: var(--accent); }

    .contact-form { background: rgba(255,255,255,0.05); border-radius: var(--radius-xl); padding: 2rem; }
    .form-group { margin-bottom: 1rem; }
    .form-label { display: block; font-size: 0.875rem; color: #cbd5e1; margin-bottom: 0.5rem; }
    .form-input { width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: var(--radius-lg); color: white; }
    .form-input::placeholder { color: #94a3b8; }
    .form-input:focus { outline: none; border-color: var(--accent); }
    .form-textarea { min-height: 8rem; resize: vertical; }

    /* ===== FOOTER ===== */
  
    /* ===== MODAL ===== */
    .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; overflow-y: auto; display: none; }
    .modal.active { display: flex; align-items: center; justify-content: center; }
    .modal-content { background: white; border-radius: var(--radius-xl); max-width: 56rem; width: 100%; margin: 2rem; overflow: hidden; }
    .modal-close { position: absolute; top: 1rem; right: 1rem; z-index: 10; background: white; border-radius: var(--radius-full); padding: 0.5rem; box-shadow: var(--shadow); transition: 0.3s; }
    .modal-close:hover { background: var(--gray-100); }
    .modal-image { height: 24rem; background: var(--gray-100); }
    .modal-image img { width: 100%; height: 100%; object-fit: cover; }
    .modal-body { padding: 2rem; }
    .modal-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .modal-title { font-size: 1.875rem; font-weight: 700; color: var(--primary); }
    .modal-category { color: var(--accent); font-weight: 600; }
    .modal-section { margin-top: 1.5rem; }
    .modal-section h3 { font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 0.75rem; }
    .modal-desc { color: var(--gray-600); line-height: 1.75; }
    .modal-tech { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .modal-tech span { padding: 0.25rem 0.5rem; background: var(--gray-100); color: var(--gray-600); font-size: 0.75rem; border-radius: 0.25rem; }
    .modal-specs { background: var(--gray-50); padding: 1rem; border-radius: var(--radius-lg); }
    .modal-specs-item { display: flex; justify-content: space-between; font-size: 0.875rem; padding: 0.25rem 0; }
    .modal-specs-key { color: var(--gray-600); }
    .modal-specs-value { font-weight: 600; }
    .modal-actions { display: flex; gap: 1rem; margin-top: 2rem; }
    .modal-btn { padding: 0.75rem 1.5rem; border-radius: var(--radius-lg); font-weight: 600; transition: 0.3s; }
    .modal-btn-close { background: var(--gray-200); color: var(--gray-700); }
    .modal-btn-close:hover { background: var(--gray-300); }
    .modal-btn-demo { background: var(--accent); color: white; }
    .modal-btn-demo:hover { background: #0891b2; }

    /* ===== PAGINATION ===== */
    .pagination { display: flex; justify-content: center; gap: 0.25rem; margin-top: 3rem; flex-wrap: wrap; }
    .pagination span, .pagination a { padding: 0.5rem 1rem; border-radius: var(--radius); font-size: 0.875rem; transition: 0.3s; }
    .pagination .disabled { color: var(--gray-400); cursor: not-allowed; }
    .pagination a { color: var(--gray-600); border: 1px solid var(--gray-300); }
    .pagination a:hover { background: var(--accent); color: white; border-color: var(--accent); }
    .pagination .active { background: var(--accent); color: white; border-color: var(--accent); }

    /* ===== ANIMATIONS ===== */
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    .animate-bounce { animation: bounce 2s infinite; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
        .text-5xl { font-size: 2.5rem; }
        .hero-stats { grid-template-columns: 1fr; gap: 1.5rem; }
        .about-features { grid-template-columns: 1fr; }
        .projects-grid, .skills-grid, .contact-grid, .footer-grid { grid-template-columns: 1fr; }
        .modal-content { margin: 1rem; }
        .modal-image { height: 16rem; }
    }
</style>