<?php
require_once __DIR__ . '/includes/bootstrap.php';
CSRF::validateOrDie();
flash('success', 'Thank you! Your message has been received. I will get back to you soon.');
redirect(base_url('contact.php'));
