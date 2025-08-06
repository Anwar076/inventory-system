
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'InventoryPro') }} - Modern Inventory Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .slide-in {
            animation: slideIn 1s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in {
            animation: fadeIn 1.5s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        .bounce-in {
            animation: bounceIn 1.2s ease-out forwards;
            opacity: 0;
            transform: scale(0.3);
        }
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        .glow {
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.5);
        }
        .typing {
            overflow: hidden;
            border-right: 2px solid;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: #667eea; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">InventoryPro</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-200 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition-colors">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">Get Started</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen gradient-bg flex items-center justify-center pt-16">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="floating absolute top-20 left-10 w-64 h-64 bg-white opacity-5 rounded-full"></div>
            <div class="floating absolute top-40 right-20 w-32 h-32 bg-white opacity-10 rounded-full" style="animation-delay: -1s;"></div>
            <div class="floating absolute bottom-20 left-1/4 w-48 h-48 bg-white opacity-5 rounded-full" style="animation-delay: -2s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="slide-in" style="animation-delay: 0.2s;">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                    <span class="typing">Inventory</span><span class="text-yellow-300">Pro</span>
                </h1>
            </div>
            
            <div class="slide-in" style="animation-delay: 0.5s;">
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    Modern, powerful, and intuitive inventory management system designed for businesses that want to scale
                </p>
            </div>

            <div class="slide-in flex flex-col sm:flex-row gap-4 justify-center items-center mb-12" style="animation-delay: 0.8s;">
                <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 glow">
                    Start Managing Inventory
                </a>
                <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                    Learn More
                </a>
            </div>

            <!-- Stats -->
            <div class="fade-in grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto" style="animation-delay: 1s;">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="1000">0</div>
                    <div class="text-blue-200">Active Users</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="50000">0</div>
                    <div class="text-blue-200">Products Managed</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="99">0</div>
                    <div class="text-blue-200">% Uptime</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="24">0</div>
                    <div class="text-blue-200">/ 7 Support</div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Powerful Features for Modern Businesses</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Everything you need to manage your inventory efficiently and scale your business</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Inventory Tracking</h3>
                    <p class="text-gray-600">Real-time inventory tracking with automated low-stock alerts and predictive analytics</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Advanced Analytics</h3>
                    <p class="text-gray-600">Comprehensive reports and insights to make data-driven decisions for your business</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Multi-Tenant Security</h3>
                    <p class="text-gray-600">Enterprise-grade security with isolated data and role-based access control</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-yellow-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Automation Tools</h3>
                    <p class="text-gray-600">Automated workflows, notifications, and integrations to streamline operations</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-red-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Lightning Fast</h3>
                    <p class="text-gray-600">Built with modern technology for blazing-fast performance and real-time updates</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-indigo-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Ready</h3>
                    <p class="text-gray-600">Fully responsive design with mobile apps for iOS and Android coming soon</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg">
        <div class="max-w-4xl mx-auto text-center px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl text-blue-100 mb-8">Join thousands of businesses that trust InventoryPro for their inventory management needs</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-50 transition-all duration-300 transform hover:scale-105">
                    Get Started Today
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                    Schedule Demo
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">InventoryPro</span>
                    </div>
                    <p class="text-gray-400">Modern inventory management for the digital age.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Status</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} InventoryPro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('[data-count]');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000; // 2 seconds
                const start = performance.now();
                
                const animate = (current) => {
                    const elapsed = current - start;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const currentCount = Math.floor(easeOutQuart * target);
                    
                    counter.textContent = currentCount;
                    
                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                requestAnimationFrame(animate);
            });
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.querySelector('[data-count]')) {
                        animateCounters();
                    }
                    
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe elements
        document.addEventListener('DOMContentLoaded', () => {
            // Observe stats section for counter animation
            const statsSection = document.querySelector('[data-count]')?.closest('div');
            if (statsSection) {
                observer.observe(statsSection);
            }

            // Observe feature cards
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                observer.observe(card);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Parallax effect for floating elements
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.floating');
                
                parallaxElements.forEach((element, index) => {
                    const speed = 0.5 + (index * 0.1);
                    element.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });

            // Add mouse tracking for glass effect
            const nav = document.querySelector('nav');
            document.addEventListener('mousemove', (e) => {
                const rect = nav.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                
                nav.style.background = `radial-gradient(circle at ${x}% ${y}%, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%)`;
            });
        });

        // Add CSS for animation states
        const style = document.createElement('style');
        style.textContent = `
            .feature-card {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease-out;
            }
            .feature-card.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>