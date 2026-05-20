@include('layouts.style')
<style>
      .footer { background: var(--gray-900); color: #cbd5e1; padding: 3rem 0; border-top: 1px solid var(--gray-800); }
    .footer-grid { display: grid; gap: 2rem; grid-template-columns: 1fr; }
    @media (min-width: 768px) { .footer-grid { grid-template-columns: repeat(4, 1fr); } }
    .footer-brand h3 { font-size: 1.25rem; color: white; margin-bottom: 1rem; }
    .footer-brand p { font-size: 0.875rem; }
    .footer-links h4 { font-size: 1rem; color: white; font-weight: 700; margin-bottom: 1rem; }
    .footer-links ul { list-style: none; }
    .footer-links li { margin-bottom: 0.5rem; }
    .footer-links a { font-size: 0.875rem; transition: 0.3s; }
    .footer-links a:hover { color: var(--accent); }
    .footer-contact h4 { font-size: 1rem; color: white; font-weight: 700; margin-bottom: 1rem; }
    .footer-contact ul { list-style: none; }
    .footer-contact li { margin-bottom: 0.5rem; }
    .footer-contact a { font-size: 0.875rem; transition: 0.3s; }
    .footer-contact a:hover { color: var(--accent); }
    .footer-location h4 { font-size: 1rem; color: white; font-weight: 700; margin-bottom: 1rem; }
    .footer-location p { font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; }
    .footer-copyright { text-align: center; padding-top: 2rem; margin-top: 2rem; border-top: 1px solid var(--gray-800); font-size: 0.75rem; color: #64748b; }

</style>
<section id="contact" class="contact">
<div style="background: rgba(212, 175, 55, 0.1); border: 1px solid #D4AF37; border-radius: var(--radius-lg); padding: 1rem; margin: 2rem 0; text-align: center;">
    <span style="color: #D4AF37; font-weight: 600;">
        <i class="fas fa-lock mr-2"></i>Confidential Access
    </span>
    <p style="margin: 0.5rem 0 0; color: var(--gray-600); font-size: 0.9rem;">
        A secret passphrase is hidden within this portfolio. 
        Include it in your message to verify you've explored my work thoroughly.
    </p>
</div>
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2 class="text-4xl font-bold mb-6">Let's Work Together</h2>
                <p>
                    I'm available for freelance projects and full-time opportunities. 
                    Whether you need a web application, IoT solution, or telecom system design, 
                    let's discuss how I can help.
                </p>
                
                <div class="space-y-4">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="contact-label">Email</div>
                            <a href="mailto:abdullahtarhini55@gmail.com" class="contact-value">abdullahtarhini55@gmail.com</a>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div class="contact-label">Location</div>
                            <div class="contact-value">Alay,Baalshmay</div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div class="contact-label">Phone</div>
                            <a href="tel:+96170389556" class="contact-value">+961 70 389 556</a>
                        </div>
                    </div>
                </div>
                <div class="social-links">
                    <a href="https://github.com/TAR-MULTIPLEXER" target="_blank" class="social-link">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/abdullah-tarhini-88aa99290/" target="_blank" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://instagram.com/yourusername" target="_blank" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="contact-form">
                <form action="https://formspree.io/f/xojkrpld" method="POST">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" required class="form-input" placeholder="Your name">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" required class="form-input" placeholder="your@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="4" required class="form-input form-textarea" placeholder="Tell me about your project..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>