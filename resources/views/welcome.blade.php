<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jigeen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #8A2BE2;
            --secondary: #E6E6FA;
            --text: #333333;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--secondary);
            color: var(--text);
        }

        .navbar {
            background: var(--white);
            padding: 1rem 2rem;
        }

        .navbar-brand img.brand-logo {
            height: 45px;
            max-width: 180px;
            object-fit: contain;
        }

        .nav-link {
            color: var(--text);
            margin: 0 1rem;
            font-weight: 500;
        }

        .btn-connect {
            background: transparent;
            color: #8A2BE2;
            border: 1px solid #8A2BE2;
            border-radius: 25px;
            padding: 8px 24px;
            margin-right: 1rem;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-connect:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-register {
            background: #8A2BE2;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 24px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-register:hover {
            opacity: 0.9;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            overflow: hidden;
            padding: 0;
        }

        .hero-content {
            position: absolute;
            z-index: 2;
            padding: 5rem;
            top: 0;
            left: 0;
            height: 100%;
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .hero-content h1 {
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
            line-height: 1.1;
        }

        .hero-content h1 span:first-child {
            color: #8A2BE2;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            max-width: 600px;
            line-height: 1.5;
        }

        .btn-action {
            background: white;
            color: #333;
            border: none;
            border-radius: 30px;
            padding: 15px 35px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-action.rounded-circle {
            padding: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-image {
            position: relative;
            height: 100vh;
            width: 100%;
        }

        .hero-image .main-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.2) 70%, rgba(0,0,0,0));
        }

        .chat-container {
            position: absolute;
            top: 40%;
            right: 5%;
            z-index: 3;
            animation: wave 2.5s ease-in-out infinite;
        }
        
        @keyframes wave {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            20% {
                transform: translateY(-15px) rotate(5deg);
            }
            40% {
                transform: translateY(0) rotate(0deg);
            }
            60% {
                transform: translateY(-15px) rotate(-5deg);
            }
            80% {
                transform: translateY(0) rotate(0deg);
            }
            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .chat-bubble {
            width: 450px;
            filter: drop-shadow(0 15px 30px rgba(0,0,0,0.3));
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        
        .chat-bubble:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
        }

        .chat-bubble .user-avatar img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-bubble .chat-content {
            flex: 1;
        }

        .chat-bubble .reactions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
        }

        .chat-bubble .reactions .count {
            color: #8A2BE2;
            font-weight: 600;
        }

        .chat-bubble p {
            margin-bottom: 0.5rem;
        }

        .chat-bubble .reactions {
            font-size: 0.9rem;
            color: #666;
        }

        /* Section de citation */
        .quote-section {
            background: linear-gradient(135deg, #f8f1ff 0%, #fff 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .quote-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(138,43,226,0.05);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .quote-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(138,43,226,0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        /* Styles pour la section Comment ça fonctionne */
        .how-it-works-section {
            padding: 120px 0;
            background-color: #fff;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .how-it-works-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(138,43,226,0.05) 0%, rgba(138,43,226,0) 70%);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            z-index: -1;
        }

        .how-it-works-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(138,43,226,0.05) 0%, rgba(138,43,226,0) 70%);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            z-index: -1;
        }

        .section-header {
            margin-bottom: 70px;
        }

        .how-title {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .how-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: #8A2BE2;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .how-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .features-row {
            justify-content: center;
        }

        .feature-col {
            padding: 20px;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 0;
            background: linear-gradient(135deg, rgba(138,43,226,0.05) 0%, rgba(255,255,255,0) 100%);
            bottom: 0;
            left: 0;
            z-index: -1;
            transition: all 0.4s ease;
            border-radius: 20px;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 50px rgba(138,43,226,0.1);
        }

        .feature-card:hover::before {
            height: 100%;
        }

        .bubble-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 25px;
            position: relative;
        }

        .bubble-icon svg {
            width: 36px;
            height: 36px;
            color: white;
            position: relative;
            z-index: 2;
        }

        .bubble-icon::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            transform: scale(0.85);
            transition: all 0.3s ease;
        }

        .bubble-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: scale(0);
            transition: all 0.3s ease;
        }

        .feature-card:hover .bubble-icon::before {
            transform: scale(0.9);
        }

        .feature-card:hover .bubble-icon::after {
            transform: scale(1.2);
            opacity: 0;
        }

        .purple {
            background: linear-gradient(135deg, #8A2BE2, #9400D3);
        }

        .purple::before {
            background: #8A2BE2;
        }

        .pink {
            background: linear-gradient(135deg, #FF69B4, #FF1493);
        }

        .pink::before {
            background: #FF69B4;
        }

        .blue {
            background: linear-gradient(135deg, #1E90FF, #4169E1);
        }

        .blue::before {
            background: #1E90FF;
        }

        .orange {
            background: linear-gradient(135deg, #FFA500, #FF8C00);
        }

        .orange::before {
            background: #FFA500;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .feature-text {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .btn-learn-more {
            display: inline-block;
            background: transparent;
            color: #8A2BE2;
            border: 2px solid #8A2BE2;
            border-radius: 30px;
            padding: 12px 35px;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-learn-more::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #8A2BE2;
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn-learn-more:hover {
            color: white;
        }

        .btn-learn-more:hover::before {
            width: 100%;
        }

        .quote-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .quote-inner {
            text-align: center;
            position: relative;
        }

        .quote-mark {
            font-size: 120px;
            color: rgba(138,43,226,0.2);
            line-height: 0;
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
        }

        .quote-text {
            font-size: 2.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
            line-height: 1.3;
            position: relative;
            padding-top: 70px;
        }

        .quote-author {
            font-size: 1.2rem;
            color: #8A2BE2;
            font-weight: 500;
        }

        /* Footer créatif */
        .creative-footer {
            position: relative;
            background: #fff;
            color: #333;
        }

        .footer-waves {
            position: relative;
            width: 100%;
            height: 150px;
            overflow: hidden;
        }

        .waves {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100px;
            min-height: 100px;
            max-height: 150px;
        }

        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }

        .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }

        .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }

        .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }

        .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }

        @keyframes move-forever {
            0% {
                transform: translate3d(-90px,0,0);
            }
            100% { 
                transform: translate3d(85px,0,0);
            }
        }

        .footer-content {
            background: #8A2BE2;
            color: white;
            position: relative;
            z-index: 2;
            padding-top: 50px;
        }

        .footer-brand {
            margin-bottom: 30px;
        }

        .footer-logo {
            margin-bottom: 15px;
            display: inline-block;
        }
        
        .footer-brand-logo {
            height: 80px;
            filter: brightness(0) invert(1);
            max-width: 100%;
            object-fit: contain;
        }

        .footer-slogan {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.8);
            line-height: 1.6;
        }

        .footer-social {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: white;
            color: #8A2BE2;
            transform: translateY(-5px);
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: rgba(255,255,255,0.3);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 15px;
        }

        .footer-links a::before {
            content: '\2192';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 20px;
        }

        .footer-links a:hover::before {
            opacity: 1;
        }

        .footer-newsletter {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 30px;
            margin-top: 40px;
        }

        .newsletter-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: white;
        }

        .newsletter-desc {
            color: rgba(255,255,255,0.7);
            margin-bottom: 20px;
        }

        .newsletter-form .form-control {
            background: rgba(255,255,255,0.1);
            border: none;
            height: 50px;
            color: white;
            border-radius: 30px 0 0 30px;
            padding-left: 20px;
        }

        .newsletter-form .form-control::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .newsletter-form .form-control:focus {
            box-shadow: none;
            background: rgba(255,255,255,0.15);
        }

        .newsletter-form .btn-primary {
            background: white;
            color: #8A2BE2;
            border: none;
            font-weight: 600;
            border-radius: 0 30px 30px 0;
            padding: 0 30px;
            height: 50px;
            transition: all 0.3s ease;
        }

        .newsletter-form .btn-primary:hover {
            background: #f8f1ff;
            transform: translateX(3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 50px;
        }

        .footer-copyright {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
        }

        .footer-legal {
            display: flex;
            gap: 20px;
        }

        .footer-legal a {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-legal a:hover {
            color: white;
        }

        /* Styles pour la section Témoignages */
        .testimonials-section {
            background: linear-gradient(135deg, #f8f1ff 0%, #fff 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .testimonials-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(138,43,226,0.05);
            border-radius: 50%;
            top: -150px;
            left: -150px;
            z-index: 0;
        }

        .testimonials-section::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border: 50px solid rgba(138,43,226,0.03);
            border-radius: 50%;
            bottom: -300px;
            right: -300px;
            z-index: 0;
        }

        .testimonials-header {
            position: relative;
            z-index: 1;
            margin-bottom: 60px;
        }

        .testimonials-title {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .testimonials-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: #8A2BE2;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .testimonials-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .testimonials-slider {
            position: relative;
            z-index: 1;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            margin: 20px 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .testimonial-card::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #8A2BE2, #9400D3);
            top: 0;
            left: 0;
            transform: scaleX(0);
            transform-origin: left;
            transition: all 0.4s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(138,43,226,0.1);
        }

        .testimonial-card:hover::before,
        .testimonial-card.highlight::before {
            transform: scaleX(1);
        }

        .testimonial-card.highlight {
            box-shadow: 0 15px 40px rgba(138,43,226,0.15);
            transform: translateY(-10px) scale(1.03);
        }

        .quote-icon {
            font-size: 60px;
            line-height: 1;
            color: rgba(138,43,226,0.1);
            font-family: Georgia, serif;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #444;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            flex-grow: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            margin-top: auto;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #8A2BE2, #9400D3);
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .author-info {
            flex: 1;
        }

        .author-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            line-height: 1;
        }

        .author-meta {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        @media (max-width: 991px) {
            .hero-content h1 {
                font-size: 3rem;
            }

            .chat-bubble {
                position: relative;
                right: auto;
                top: 2rem;
                transform: none;
                margin: 0 auto;
            }

            .quote-text {
                font-size: 2rem;
                padding-top: 60px;
            }

            .quote-mark {
                font-size: 80px;
                top: 20px;
            }

            .footer-waves {
                height: 100px;
            }

            .footer-legal {
                flex-direction: column;
                gap: 10px;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Jigeen" class="brand-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    <a href="/home" class="nav-link">Accueil</a>
                    <a href="#" class="nav-link">Comment ça marche</a>
                    <a href="#" class="nav-link">Témoignages</a>
                    <a href="#" class="nav-link">Contact</a>
                    <a href="/direct-login.php" class="btn btn-connect">Se connecter</a>
                    <a href="/direct-register.php" class="btn btn-register">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-image">
            <img src="{{ asset('images/vitree.jpeg') }}" alt="Femme pensive" class="main-image">
            <div class="overlay"></div>
            <div class="hero-content">
                <h1>
                    <span>Partager</span> votre<br>histoire,<br>
                    <span>Recevez</span> du soutien
                </h1>
                <p>Un espace sécurisé pour les femmes victimes de violences, où vous pouvez partager votre expérience, recevoir du soutien et vous connecter avec des ONG prêtes à vous aider.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-action">Rejoindre la communauté</a>
                    <a href="#" class="btn btn-action">Besoin d'aide immédiate ?</a>
                   
                </div>
            </div>
            <div class="chat-container">
                <img src="{{ asset('images/chat.png') }}" alt="Témoignage" class="chat-bubble">
            </div>
        </div>
    </section>

    <!-- Section Comment ça fonctionne -->
    <section class="how-it-works-section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="how-title">Comment ça fonctionne</h2>
                <p class="how-subtitle">Notre plateforme est construite pour vous offrir un espace sûr et sécurisé, où vous pouvez partager et recevoir du soutien.</p>
            </div>

            <div class="row features-row">
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-card">
                        <div class="feature-icon bubble-icon purple">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                        <h3 class="feature-title">Partager son histoire</h3>
                        <p class="feature-text">Un espace sûr pour raconter votre expérience et briser le silence.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-card">
                        <div class="feature-icon bubble-icon pink">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </div>
                        <h3 class="feature-title">Recevoir du soutien</h3>
                        <p class="feature-text">Une communauté bienveillante prête à vous écouter et vous encourager.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-card">
                        <div class="feature-icon bubble-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <h3 class="feature-title">Connexion avec des ONG</h3>
                        <p class="feature-text">Accès direct à des organisations spécialisées prêtes à vous aider.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-card">
                        <div class="feature-icon bubble-icon orange">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <h3 class="feature-title">Confidentialité assurée</h3>
                        <p class="feature-text">Votre sécurité et anonymat sont notre priorité absolue.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn-learn-more">En savoir plus sur notre mission</a>
            </div>
        </div>
    </section>

    <!-- Section Témoignages -->
    <section class="testimonials-section">
        <div class="container">
            <div class="testimonials-header text-center">
                <h2 class="testimonials-title">Témoignages</h2>
                <p class="testimonials-subtitle">Découvrez comment notre plateforme a aidé d'autres femmes à retrouver espoir et soutien.</p>
            </div>

            <div class="testimonials-slider">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="testimonial-card">
                            <div class="quote-icon">“</div>
                            <p class="testimonial-text">Grâce à cette plateforme, j'ai pu partager mon histoire et trouver du soutien auprès d'autres personnes qui ont vécu des expériences similaires. Je me sens moins seule dans mon parcours.</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <span>M</span>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">Marie</h4>
                                    <p class="author-meta">34 ans</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="testimonial-card highlight">
                            <div class="quote-icon">“</div>
                            <p class="testimonial-text">Après des années de silence, j'ai enfin trouvé un espace sûr pour exprimer ce que j'ai vécu. Les ONG partenaires m'ont fourni l'aide dont j'avais besoin pour reconstruire ma vie.</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <span>S</span>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">Sophie</h4>
                                    <p class="author-meta">27 ans</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="testimonial-card">
                            <div class="quote-icon">“</div>
                            <p class="testimonial-text">En tant que représentante d'une ONG, cette plateforme nous a permis d'aider plus de femmes et d'intervenir plus rapidement. Un outil indispensable pour notre travail.</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <span>L</span>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">Laure</h4>
                                    <p class="author-meta">Coordinatrice ONG</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section de citation inspirante -->
    <section class="quote-section">
        <div class="quote-container">
            <div class="quote-inner">
                <div class="quote-mark">❝</div>
                <h2 class="quote-text">La force d'une femme ne se mesure pas à ses muscles, mais à son courage face à l'adversité</h2>
                <div class="quote-author">- Maya Angelou</div>
            </div>
        </div>
    </section>

    <!-- Footer créatif -->
    <footer class="creative-footer">
        <div class="footer-waves">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(138,43,226,0.7)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(138,43,226,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(138,43,226,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#8A2BE2" />
                </g>
            </svg>
        </div>

        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="footer-brand">
                            <div class="footer-logo">
                                <img src="{{ asset('images/jigeen.png') }}" alt="Jigeen" class="footer-brand-logo">
                            </div>
                            <p class="footer-slogan">Un espace de partage et de soutien pour toutes les femmes.</p>
                        </div>
                        <div class="footer-social">
                            <a href="#" class="social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                            <a href="#" class="social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                            <a href="#" class="social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
                            <a href="#" class="social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <h4 class="footer-title">Explorer</h4>
                                <ul class="footer-links">
                                    <li><a href="#">Accueil</a></li>
                                    <li><a href="#">Notre mission</a></li>
                                    <li><a href="#">Témoignages</a></li>
                                    <li><a href="#">Comment ça marche</a></li>
                                </ul>
                            </div>
                            
                            <div class="col-md-4 mb-4 mb-md-0">
                                <h4 class="footer-title">Ressources</h4>
                                <ul class="footer-links">
                                    <li><a href="#">Numéros d'urgence</a></li>
                                    <li><a href="#">Organisations partenaires</a></li>
                                    <li><a href="#">Groupes de soutien</a></li>
                                    <li><a href="#">Articles & conseils</a></li>
                                </ul>
                            </div>
                            
                            <div class="col-md-4">
                                <h4 class="footer-title">Contact</h4>
                                <ul class="footer-links">
                                    <li><a href="#">Nous contacter</a></li>
                                    <li><a href="#">Faire un don</a></li>
                                    <li><a href="#">Devenir bénévole</a></li>
                                    <li><a href="#">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="footer-newsletter">
                            <h4 class="newsletter-title">Restez informée</h4>
                            <p class="newsletter-desc">Inscrivez-vous à notre newsletter pour recevoir des mises à jour sur nos actions et événements.</p>
                            <form class="newsletter-form">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Votre adresse email">
                                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="container">
                    <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                        <div class="footer-copyright">
                            &copy; 2025 Jigeen. Tous droits réservés.
                        </div>
                        <div class="footer-legal">
                            <a href="#">Conditions d'utilisation</a>
                            <a href="#">Politique de confidentialité</a>
                            <a href="#">Mentions légales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.partners-swiper', {
            slidesPerView: 1,
            spaceBetween: 60,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
            },
            breakpoints: {
                // when window width is >= 480px
                480: {
                    slidesPerView: 1,
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 2,
                },
                // when window width is >= 992px
                992: {
                    slidesPerView: 3,
                },
                // when window width is >= 1200px
                1200: {
                    slidesPerView: 4,
                }
            }
        });
    </script>

   
</body>
</html>